const express = require('express')
const router = express.Router()
const bcrypt = require('bcrypt')
const mongoose = require('mongoose')
const passport = require('passport')
const {ensureAuthenticated, forwardAuthenticated } = require('./auth')

// Use Models
const User = require('../models/user') 
const db = "mongodb://localhost/serverDB"
mongoose.connect(db, { useNewUrlParser: true, useUnifiedTopology: true})


// Login page
router.get('/login', forwardAuthenticated, (req, res) => {
    res.render('login')
})

// Login handle
router.post('/login', (req, res, next) => {
    passport.authenticate('local', {
        successRedirect: '/home',
        failureRedirect: '/users/login',
        failureFlash: true
    })(req, res, next)
})

// Register page
router.get('/register', forwardAuthenticated, (req, res) => {
    res.render('register')
})

// Router page in post
router.post('/register', (req, res) => {
    const { name, email, password, password2 } = req.body
    let errors = []
    // Check passwordd match
    if (password !== password2) {
        errors.push({ msg: 'Passwords do not match' })
    }
    // Check password's length
    if (password.length < 4) {
        errors.push({ msg: 'Password should be at least 4 characters' })
    }
    // Error messages
    if (errors.length > 0) {
        res.render('register', {
            errors, 
            name, email, password, password2
        })
    } else {
        // Validation passed
        User.findOne({ email: email})
            .then(user => {
                if(user) {
                    //User exists
                    errors.push({ msg: 'Email is already registered'})
                    res.render('register', {
                        errors,
                        name, email, password, password2
                    })
                } else {
                    const newUser = new User({
                        name, email, password
                    })
                    // Hash Password
                    bcrypt.hash(newUser.password, 10, (err,hash) => {
                        if(err) throw err;
                        newUser.password = hash
                        newUser.save()
                            .then(user => {
                                req.flash('success_msg', 'Your are now registered and can log in ')
                                res.redirect('/users/login')
                            })
                            .catch(err => console.log(err))
                    })         
        }
    })
}})

//user info change
router.get('/info-change',ensureAuthenticated,(req,res)=>{
    User.findOne({_id:req.user}).exec((err,user)=>{
        if(err){
            res.send('error occured');
        }else{
            res.render('infoChange',{item:user});
        }
    })
})

router.post('/info-change/updateDB',ensureAuthenticated,(req,res)=>{
    bcrypt.hash(req.body.password,10,(err,hash)=>{
       if(err) throw err;
       User.findOneAndUpdate({_id: req.user},
            {email:req.body.email,password:hash},
            function(err,user) {
                if(err) {
                    res.send({ error: 'database failure' });
                    return;
                }
                User.findOne({_id:user._id}).exec((err,user2)=>{
                    if(err){
                        res.send('error occured');
                    }else{
                        res.render('infoChange',{item:user2,pass:req.body.password});
                    }
                })
            }
        )
    })
})

router.get('/logout', (req, res) => {
    req.logout()
    req.flash('success_msg', 'You are logged out')
    res.redirect('/users/login')
})

module.exports = router;