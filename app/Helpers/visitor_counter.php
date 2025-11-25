<?php
session_start(); // penting untuk track session user

function countVisitor()
{
    $file = __DIR__ . '/counter.txt';

    // Buat file jika belum ada
    if (!file_exists($file)) {
        file_put_contents($file, 0);
    }

    // Baca jumlah saat ini
    $count = (int) file_get_contents($file);

    // Cek apakah session sudah dihitung
    if (!isset($_SESSION['counted'])) {
        $count++; // tambah 1
        file_put_contents($file, $count);
        $_SESSION['counted'] = true; // tandai sudah dihitung
    }

    return $count;
}
