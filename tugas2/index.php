<?php
function cetakBilangan($n) {
    for ($i = 1; $i <= $n; $i++) {
        if ($i % 4 == 0 && $i % 6 == 0) {
            echo "Pemrograman Website 2024<br>";
        } elseif ($i % 5 == 0) {
            echo "2024<br>";
        } elseif ($i % 4 == 0) {
            echo "Pemrograman<br>";
        } elseif ($i % 6 == 0) {
            echo "Website<br>";
        } else {
            echo $i . "<br>";
        }
    }
}

// Mengambil input dari URL parameter
if (isset($_GET['bilangan'])) {
    $n = (int)$_GET['bilangan'];
    if ($n > 0) {
        cetakBilangan($n);
    } else {
        echo "Silakan masukkan bilangan bulat positif.";
    }
} else {
    echo "Silakan masukkan bilangan bulat positif melalui URL. Contoh: ?bilangan=10";
}
?>
