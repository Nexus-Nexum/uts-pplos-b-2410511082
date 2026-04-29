const jwt = require('jsonwebtoken');
const SECRET = process.env.JWT_SECRET || '';

const verifyToken = (req, res, next) => {
    const token = req.headers['authorization'];
    if (!token) return res.status(403).json({ message: "Token" });

    try {
        const decoded = jwt.verify(token.split(' ')[1], SECRET);
        req.user = decoded;
        next();
    } catch (err) {
        return res.status(401).json({ message: "Token salah" });
    }
};

module.exports = verifyToken;