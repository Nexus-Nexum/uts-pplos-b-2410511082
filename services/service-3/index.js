const express = require('express');
const app = express();
const PORT = 3003;

app.use(express.json());

const riwayat = [
    { id: 1, nama: "Budi", tanggal: "2026-04-01", lokasi: "PMI Pusat" },
    { id: 2, nama: "Siti", tanggal: "2026-03-15", lokasi: "RS Kasih Ibu" }
];

app.get('/history', (req, res) => {
    res.json({
        status: "success",
        service: "History Service (Node.js)",
        data: riwayat
    });
});

app.listen(PORT, () => console.log(`Service 3 jalan di port ${PORT}`));