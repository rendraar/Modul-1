<?php
$tinggi = 5; // tinggi segitiga terbalik

for ($i = $tinggi; $i >= 1; $i--) {
    // cetak spasi untuk rata tengah
    for ($j = $tinggi; $j > $i; $j--) {
        echo "&nbsp;&nbsp";
    }
    // cetak bintang
    for ($k = 1; $k <= (2 * $i - 1); $k++) {
        echo "*";
    }
    echo "<br>";
    
}
?>