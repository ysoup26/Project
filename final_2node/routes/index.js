const express = require('express')
const router = express.Router()
const { ensureAuthenticated, forwardAuthenticated } = require('./auth')

//mongoose DB get
const mongoose=require('mongoose');
const Book=require('../models/bookModel')
const Post=require('../models/post')
const Comment=require('../models/comment')
const User=require('../models/user')

//mongoose connect
const db='mongodb://localhost/serverDB';
mongoose.connect(db, {useNewUrlParser: true, useUnifiedTopology: true});

router.get('/', forwardAuthenticated, (req, res) => {
    res.render('index')
})

//main home: post info and user id send
router.get('/home',ensureAuthenticated,(req,res)=>{
    Post.find((err,posts)=>{
        if(err){
            res.status(500),send({err:'database failure'});
            return;
        }
        res.render('home',{items:posts,id:req.user})
    }
    )
})

//search
router.get('/search',ensureAuthenticated,(req,res)=>{
    res.render('search');
})
//regex==contain
router.post('/search/findDB',ensureAuthenticated,(req,res)=>{ 
    Post.find({$or:[{user:{$regex : req.body.text}},{topic:{$regex : req.body.text}},
        {title:{$regex : req.body.text}},{content:{$regex : req.body.text}}]})
    .exec((err,posts)=>{ 
        if(err){
            res.send('error occured');
        }else{
            res.render('search',{items:posts})
        }
    })
})

//upload
router.get('/upload',(req,res)=>{
    res.render('upload');
})
router.post('/upload/uploadDB',ensureAuthenticated,(req,res)=>{
    User.findOne({_id:req.user}).exec((err,user)=>{ //to user name find
        if(err){
            res.send('error occured');
        }
        const post=new Post();
        post.topic=req.body.topic;
        post.title=req.body.title;
        post.user=user.name; //
        post.content=req.body.text;
        post.userId=req.user;
        post.save(function(err){
            if(err){
                res.status(500).send({error:'database failure'});
                return;
            }
            res.redirect('/home');
        })
    })
});

//post
router.get('/post',ensureAuthenticated,(req,res)=>{ 
    Post.findOne({_id:req.query.id}).exec((err,post)=>{ //find click post
        if(err){
            res.send('error occured');
        }else{
            Comment.find({postId:post._id}).exec((err,comment)=>{//find post to comment
                if(comment){
                    //post info &&comment info&&userId info(edit&delete)
                    res.render('post',{item:post,item_comment:comment,userId:req.user})
                }else
                    res.render('post',{item:post,userId:req.user})  
            })
        }
    })
})

//post edit
router.get('/post/edit',(req,res)=>{
    Post.findOne({_id:req.query.id},(err,post)=>{
        if(err){
            res.status(500),send({err:'database failure'});
            return;
        }
        res.render('edit',{item:post})//edit post info
    })
})
router.post('/post/edit/updateDB', (req, res) => {
    Post.findOneAndUpdate({_id: req.query.id},
      {$set:{title:req.body.title,topic:req.body.topic,content:req.body.text}},
      function(err,post) {
        if(err) {
          res.send({ error: 'database failure' });
          return;
        };
        res.redirect('/post?id='+`${req.query.id}`); //go back post
    })
})

//post delete
router.get('/post/delete',(req,res)=>{
    Post.deleteOne({_id:req.query.id},(err,output)=>{
        if(err){
            res.status(500).send({error:'database failure'});
            return;
        }
        res.redirect('/home');
    })
})

//post comment
router.post('/post/comment/uploadDB',ensureAuthenticated,(req,res)=>{
    User.findOne({_id:req.user}).exec((err,user)=>{
        if(err){
            res.send('error occured');
        }
        const comment=new Comment();
        comment.user=user.name;
        comment.text=req.body.text;
        comment.postId=req.query.postId;
        comment.userId=user._id;
        comment.save(function(err){
            if(err){
                res.status(500).send({error:'database failure'});
                return;
            }
            res.redirect('/post?id='+`${req.query.postId}`);
        })
    })
});
router.get('/post/comment/deleteDB',(req,res)=>{
    Comment.deleteOne({_id:req.query.id},(err,output)=>{
        if(err){
            res.status(500).send({error:'database failure'});
            return;
        }
        //console.log(output);
        res.redirect('/post?id='+`${req.query.postId}`);
    })
})

router.get('/dash',(req,res)=>{
    res.render('dashboard');
})

module.exports = router