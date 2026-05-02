const express = require('express');
const jwt = require('jsonwebtoken');
const passport = require('passport');
const GoogleStrategy = require('passport-google-oauth20').Strategy;
const session = require('express-session');
const app = express();

app.use(express.json());

const SECRET = 'paruk';
const REFRESH_SECRET = 'farouq';

let refreshTokens = []; 

app.use(session({ secret: 'paruk_session', resave: false, saveUninitialized: true }));
app.use(passport.initialize());
app.use(passport.session());

passport.use(new GoogleStrategy({
    clientID: '682865857075-4bvr72dabb6e7qh73qm2h7q53gvgiq19.apps.googleusercontent.com', 
    clientSecret: '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',
    callbackURL: 'http://localhost:8081/auth/callback',
    scope: ['profile', 'email'] 
  },
  (accessToken, refreshToken, profile, done) => {
    const user = {
        nama: profile.displayName,
        email: profile.emails[0].value,
        foto: profile.photos[0].value,
        provider: 'google'
    };
    return done(null, user);
  }
));

passport.serializeUser((user, done) => done(null, user));
passport.deserializeUser((user, done) => done(null, user));

app.post('/login', (req, res) => {
    const { username, password } = req.body;
    if (username === 'admin' && password === 'admin') {
        const accessToken = jwt.sign({ user: username }, SECRET, { expiresIn: '15m' }); 
        const refreshToken = jwt.sign({ user: username }, REFRESH_SECRET, { expiresIn: '7d' }); 
        refreshTokens.push(refreshToken); 
        return res.json({ accessToken, refreshToken });
    }
    res.status(401).json({ message: "Login gagal!" });
});

app.post('/refresh', (req, res) => {
    const { token } = req.body;
    if (!token || !refreshTokens.includes(token)) return res.sendStatus(403);
    jwt.verify(token, REFRESH_SECRET, (err, user) => {
        if (err) return res.sendStatus(403);
        const accessToken = jwt.sign({ user: user.user }, SECRET, { expiresIn: '15m' });
        res.json({ accessToken });
    });
});

app.post('/logout', (req, res) => {
    const { token } = req.body;
    refreshTokens = refreshTokens.filter(t => t !== token); 
    res.json({ message: "Logout berhasil, token diblacklist!" });
});


app.get('/google', passport.authenticate('google', { scope: ['profile', 'email'] }));

app.get('/callback', passport.authenticate('google', { failureRedirect: '/' }), (req, res) => {
    const { email, nama, foto, provider } = req.user;

    console.log(`[DB Sim] Mencari user dengan email: ${email}`);
    console.log(`[DB Sim] Status: User ditemukan/dibuat dengan flag oauth_provider: ${provider}`);

    const token = jwt.sign({ user: email }, SECRET, { expiresIn: '15m' });
    
    res.json({
        message: "Login OAuth Berhasil dan Data Terpetakan ke DB Lokal!",
        user: { nama, email, foto, provider }, 
        token: token
    });
});
app.listen(3001, () => console.log("Auth Service Poin 4 & 5 Ready!"));