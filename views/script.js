document.addEventListener('DOMContentLoaded', function () {
    // Mengambil data dari server menggunakan AJAX
    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'http://localhost:8000/api/anime', true);

    xhr.onload = function () {
        if (this.status === 200) {
            const responseText = this.responseText.trim(); // Menghapus spasi ekstra
    
            // Pengecekan apakah respons kosong atau tidak
            if (responseText.length === 0) {
                console.error("Empty response received");
                return;
            }
    
            try {
                // Mengubah respons menjadi objek JavaScript
                const response = JSON.parse(responseText);
    
                // Cek jika data valid
                if (Array.isArray(response)) {  // Periksa jika response adalah array
                    // Kelompokkan data berdasarkan tipe (type)
                    const groupedData = groupDataByType(response);
    
                    // Tambahkan data ke kategori
                    addItemsToCategory('ongoing-category', groupedData.ongoing || []);
                    addItemsToCategory('complete-category', groupedData.complete || []);
                    addItemsToCategory('movie-category', groupedData.movie || []);
                } else {
                    console.error("Invalid data structure or error in response:", response);
                }
    
            } catch (e) {
                console.error("JSON parsing error:", e);
            }
        } else {
            console.error("Error with the request:", this.status);
        }
    };    

    xhr.onerror = function () {
        console.error("Request failed or there was a network error");
    };

    xhr.send();
});

// Fungsi untuk mengelompokkan data berdasarkan tipe
function groupDataByType(data) {
    return data.reduce((acc, item) => {
        const type = item.type; // Misalnya "ongoing", "complete", atau "movie"
        if (!acc[type]) {
            acc[type] = [];
        }
        acc[type].push(item);
        return acc;
    }, {});
}

// Fungsi untuk menambahkan item ke dalam kategori
function addItemsToCategory(categoryId, items) {
    const categoryContainer = document.getElementById(categoryId);

    // Pastikan kategori ditemukan
    if (!categoryContainer) {
        console.error(`Category container with ID ${categoryId} not found.`);
        return;
    }

    // Perulangan untuk menambahkan item gambar ke kategori
    items.forEach(item => {
        // Buat elemen div untuk item
        const itemElement = document.createElement('div');
        itemElement.classList.add('item');

        // Buat elemen anchor dan image
        const itemLink = document.createElement('a');
        const itemImage = document.createElement('img');
        itemImage.src = '../assets/images/' + item.image_url;
        itemImage.alt = item.anime_name;

        // Tambahkan URL berdasarkan slug, gunakan "#" jika slug kosong
        itemLink.href = item.slug ? `http://localhost:8000/anime/${item.slug}` : '#';

        // Tambahkan image ke link dan link ke itemElement
        itemLink.appendChild(itemImage);
        itemElement.appendChild(itemLink);

        // Tambahkan itemElement ke dalam kategori container
        categoryContainer.appendChild(itemElement);
    });
}
