1. Versi PHP:
- PHP Version: 8.3.4
- Zend Engine: 4.3.4
PHP ini adalah versi terbaru yang Anda gunakan pada sistem Anda.

2. Versi Database (MySQL atau MariaDB):
MySQL Version: 8.0.30

#  Panduan Penggunaan Aplikasi
Aplikasi ini dirancang untuk memudahkan manajemen kendaraan, termasuk penggunaan kendaraan, pemesanan, serta proses persetujuan. Berikut adalah langkah-langkah untuk menggunakan aplikasi, beserta informasi login yang telah disediakan.

Daftar Username dan Password
Untuk memulai, Anda dapat menggunakan kredensial berikut:

Admin
``` java
Username: waw@example.com
Password: 12345678
Role: Admin
```
Deskripsi: Pengguna dengan hak akses penuh untuk mengelola semua data kendaraan, penggunaan kendaraan, dan proses administrasi lainnya.

Approval
``` java
Username: brian@example.com
Password: 12345678
Role: Approval
```

- Deskripsi: Pengguna dengan hak akses untuk melihat dan mengelola data kendaraan yang memerlukan persetujuan.

## Langkah-langkah Penggunaan
1. Login ke Aplikasi

- Masukkan username dan password yang sesuai dengan peran yang diberikan.
2. Akses Dashboard
- Setelah berhasil login, pengguna akan diarahkan ke dashboard sesuai dengan peran mereka:
- Admin: Dapat mengelola kendaraan, riwayat penggunaan, . dan melakukan ekspor data.
- Approval: Dapat melihat data kendaraan yang memerlukan persetujuan dan melakukan pembaruan status.
3. Mengelola Data Kendaraan

- Admin dapat menambahkan, mengedit, atau menghapus kendaraan dari database.
4. Membuat dan Mengelola Pemesanan

- Admin dapat menambahkan dan mengelola riwayat penggunaan kendaraan.
- Approval dapat memverifikasi dan menyetujui riwayat penggunaan kendaraan yang masuk.
5. Ekspor Data

- Admin dapat mengekspor data riwayat penggunaan kendaraan ke dalam format Excel.