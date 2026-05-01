const jwt = require('jsonwebtoken');
const SECRET = 'paruk';

module.exports = (req, res, next) => {
    const token = req.headers['authorization']?.split(' ')[1];
    
    if (!token) return res.status(403).json({ message: "Gak ada token, gak boleh masuk!" });

    jwt.verify(token, SECRET, (err, decoded) => {
        if (err) return res.status(401).json({ message: "Token basi atau salah!" });
        req.user = decoded;
        next();
    });
};