const express = require('express');
const jwt = require('jsonwebtoken');
const app = express();
app.use(express.json());

const SECRET = 'paruk';
const REFRESH_SECRET = 'farouq';

let refreshTokens = []; 

app.post('/login', (req, res) => {
    const { username, password } = req.body;
    if (username === 'admin' && password === 'admin') {
        const accessToken = jwt.sign({ user: username }, SECRET, { expiresIn: '15m' }); 
        const refreshToken = jwt.sign({ user: username }, REFRESH_SECRET, { expiresIn: '7d' }); 
        
        refreshTokens.push(refreshToken); 
        return res.json({ accessToken, refreshToken });
    }
    res.status(401).json({ message: "Login gagal !" });
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

app.listen(3001, () => console.log("Auth Service Full Poin 4 Jalan!"));