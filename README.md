
# Bocorocco CI4 Project (Nisaul Husna)

Project ini merupakan bagian dari **Tes Internship – Bocorocco PT. Chosen Mitra Abadi**, 
dibangun menggunakan **CodeIgniter 4** dan **MySQL**.

## Deskripsi

Pada project ini, data produk diambil dari **file JSON** yang berfungsi sebagai sumber utama untuk menampilkan data produk Bocorocco pada bagian frontend.  
Data ini kemudian **disinkronisasikan ke database MySQL** agar dapat digunakan pada sisi backend untuk kebutuhan filtering, kueri, dan perhitungan statistik.

## Struktur Data JSON

File `products.json` berisi array data produk dengan struktur sebagai berikut:

```json
{
  "id": INT,
  "name": STRING,
  "category": STRING,
  "description": STRING,
  "price": INT,
  "release_date": "YYYY-MM-DD",
  "images": {
    "color_name": "path/to/image.png"
  },
  "sizes": [ "35", "36", ... ],
  "colors": [ "nero", "bianco", ... ]
}
```

## Halaman yang Diimplementasikan

Berikut adalah tampilan halaman yang telah dibangun:

1. **Main Page (Ganti Produk)** – halaman utama yang menampilkan daftar produk dan best-seller.
2. **Product Detail Page** – menampilkan detail produk serta tombol “Add to Cart”.
3. **Search Page** – menampilkan hasil pencarian berdasarkan nama produk atau keyword.
4. **Cart Page** – menampilkan isi keranjang belanja dan kontrol kuantitas.
5. **Checkout Page** – menampilkan ringkasan pesanan, alamat, metode pembayaran, promo, dan total harga.

## Setup Project

### 1. Clone Repository

```bash
git clone https://github.com/nisaulUna/bocorocco-project.git
cd bocorocco-project
```

### 2. Import Database

Import file SQL ke database MySQL menggunakan phpMyAdmin atau melalui command line.

### 3. Jalankan Seeder untuk Sinkronisasi JSON

```bash
php spark db:seed ProductSeeder
```

Seeder ini akan membaca data dari `products.json` dan menyimpannya ke tabel `products` dan `product_variants` pada database.

### 4. Jalankan Seeder Data Dummy

```bash
php spark db:seed DummySeeder
```

Seeder ini digunakan untuk mengisi data dummy seperti user, promo, alamat, dan lainnya yang diperlukan untuk simulasi sistem.

## Catatan Tambahan

- Project menggunakan struktur MVC CodeIgniter 4 dan mengikuti prinsip DRY (Don't Repeat Yourself).
- Halaman bersifat responsif dan menyesuaikan dengan tampilan desain pada Figma.
- File JSON digunakan sebagai jembatan utama antara frontend dan backend dalam proses integrasi data.

## Jawaban Soal Nomor 3

Query SQL untuk menampilkan nama kota dan jumlah penduduk dari kota-kota di Indonesia (`COUNTRYCODE = 'INA'`) yang memiliki populasi lebih dari 5 juta:

```sql
SELECT NAME, POPULATION
FROM city
WHERE COUNTRYCODE = 'INA'
  AND POPULATION > 5000000
ORDER BY POPULATION DESC;
```
