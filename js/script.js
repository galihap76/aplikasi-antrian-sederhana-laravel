// Mengambil elemen button pertama pada halaman web
let btn = document.querySelector('button:first-of-type');

// Mengambil elemen nomor antrian
let nomor = document.querySelector('.nomor');

// Mengambil elemen audio pertama pada halaman web
let audioElement = document.querySelector('audio:first-of-type');

// Mengambil elemen button "tambah antrian" pada halaman web
let tambahAntrianBtn = document.getElementById('tambah-antrian');

// Membuat instance dari object XMLHttpRequest
let xhr = new XMLHttpRequest();

// Menambahkan event listener pada button nomor antrian
btn.addEventListener('click', function() {
    // Memuat ulang audio
    audioElement.load();
    // Memainkan audio
    audioElement.play();

    // Mengatur timeout agar fungsi di dalamnya dijalankan setelah 7 detik
    setTimeout(function() {
        // Memanggil fungsi speak dari library responsiveVoice untuk membacakan nomor antrian
        responsiveVoice.speak('Nomor antrian , ' + nomor.innerHTML, 'Indonesian Female');
    }, 7000);
});

// Fungsi untuk mengambil nomor antrian dari server
function getAntrian(){
    // Menetapkan fungsi yang akan dijalankan saat readyState berubah
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // Menampilkan nomor antrian yang diambil dari server ke dalam elemen dengan id "demo"
            nomor.innerHTML = xhr.responseText;
        }
    };
    // Membuat request GET untuk mengambil nomor antrian dari server
    xhr.open("GET", "/get_antrian", true);
    xhr.send();
}

// Memanggil fungsi getAntrian saat halaman dimuat
getAntrian();

// Menambahkan event listener pada button "tambah antrian"
tambahAntrianBtn.addEventListener('click', function() {
    // Menetapkan fungsi yang akan dijalankan saat readyState berubah
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                // Memanggil fungsi getAntrian jika request POST berhasil dilakukan
                getAntrian();
            } else {
                alert("Update antrian gagal!");
            }
        }
    };
    // Membuat request POST untuk menambahkan nomor antrian ke server
    xhr.open('POST', '/update-antrian');
    // Menetapkan content type pada header request
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    // Menetapkan CSRF token pada header request
    xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
    // Mengirim data form ke server
    xhr.send(new FormData(document.querySelector('form')));
});
