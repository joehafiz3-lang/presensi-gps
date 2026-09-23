<?php

// Mengarahkan Vercel Runtime langsung ke publik Laravel
$publicPath = __DIR__ . '/../public/index.php';

if (file_exists($publicPath)) {
    require $publicPath;
} else {
    echo "Pesan Error: Berkas utama Laravel di folder public tidak ditemukan.";
}
