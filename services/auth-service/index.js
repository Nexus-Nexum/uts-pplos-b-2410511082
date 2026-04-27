const express = require('express');
const jwt = require('jsonwebtoken');
const app = express();
const PORT = 3001;
const SECRET = process.env.JWT_SECRET || 'default_secret';

app.use(express.json());

const users = [{ id: 1, username: 'admin', password: 'password123' }];

app.post('/login', (req, res) => {
    const { username, password } = req.body;
    const user = users.find(u => u.username === username && u.password === password);

    if (user) {
        const token = jwt.sign({ id: user.id, user: user.username }, SECRET, { expiresIn: '1h' });
        return res.json({ 
            status: 'success',
            message: 'Login Berhasil!', 
            token 
        });
    }
    res.status(401).json({ message: 'Login Gagal' });
});

app.get('/verify', (req, res) => {
    res.json({ message: 'Auth Service is UP' });
});

app.listen(PORT, () => console.log(`Auth Service jalan di port ${PORT}`));