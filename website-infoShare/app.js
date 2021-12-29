const express = require('express')
const flash = require('express-flash')
const session = require('express-session')
const passport = require('passport')

const index = require('./routes/index')
const users = require('./routes/users')

const app = express();

// Passport config
const initializePassport = require('./passport-config')
initializePassport(passport)

// middleware for static files
app.use(express.static('public'));
// middleware for body parser
app.use(express.urlencoded({ extended: true }));

// View : pug 
app.set('views', './views')
app.set('view engine', 'pug')

// BodyParser
app.use(express.urlencoded({ extended: false}))

// Express Session
app.use(session({
    secret: 'secret',
    resave: false,
    saveUninitialized: true
}))

// Passport middleware
app.use(passport.initialize())
app.use(passport.session())

// Express flash
app.use(flash())

// Global variables
app.use((req, res, next) => {
    res.locals.success_msg = req.flash('success_msg'),
    res.locals.error_msg = req.flash('error_msg'),
    res.locals.error = req.flash('error'),
    next()
})

// Controller : Router
app.use('/', index);
app.use('/users',users);

// Start Web Server
app.listen(3000, (req, res) => {
    console.log('Express server is running on port 3000');
})