<?php
session_start();
if (!isset($_SESSION['logged_in'])) {
    header('Location: login.php');
}

require 'functions.php';

if (isset($_POST["submit"])) {
    if (tambah_data($_POST) > 0) {
        echo "
            <script>
                alert('Data berhasil ditambahkan');
                document.location.href = 'index.php';
            </script>
        ";
    } else {
        echo "
            <script>
                alert('data gagal ditambahkan');
                document.location.href = 'index.php';
            </script>
        ";
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ANTRIYUK</title>
    <link rel="stylesheet" href="css/tambahdata.css">
    <link rel="stylesheet" href="css/style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">


</head>

<body class="overflow-y-auto">
    <header>
        <nav class="navbar">
            <div class="container">
                <h2 class="navbar-text">AntriYUK</h2>
                <div class="btn-group dropstart">
                    <button type="button" style="border: none; outline: none; border-radius: 50%; background-color: transparent;" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="<?php echo $_SESSION['picture']; ?>" alt="profile" style="border-radius: 50%;" width="50%">
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#"><?php echo $_SESSION['name'] ?></a></li>
                        <li><a class="dropdown-item" href="#"><?php echo $_SESSION['email'] ?></a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="home overflow-x-hidden">
        <div class="row gx-5 text-center mx-5 my-5 container-fluid">

            <div class="container text-center btn-table">
                <form method="POST">
                    <div class="col-sm-6 col-md-11 me-3 text-start shadow mb-5 rounded-2 box">
                        <div id="containers">
                            <!--=====TABLE=====-->
                            <div class="text-judul py-4">Informasi Pemohon</div>
                            <div class="py-2">
                                <label class="label-tambah" for="nama">Nama Pemohon<button type="button" class="text-wajib" disabled data-bs-toggle="button">Wajib</button></label>
                                <input class="input-tambah" type="text" id="nama" placeholder="Masukkan Nama Pemohon" name="nama" required autocomplete="off">
                            </div>
                            <div class="py-5 my-2">
                                <label class="label-tambah" for="no_stnk">Nomor STNK<button type="button" class="text-wajib" disabled data-bs-toggle="button">Wajib</button></label>
                                <input class="input-tambah" type="text" placeholder="Masukkan Nomor STNK" title="Masukkan nomor STNK dengan benar *16 Digit" id="no_stnk" name="no_stnk" required autocomplete="off" pattern="[0-9]{16}" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                            </div>
                            <div class="py-5 my-2">
                                <label class="label-tambah" for="keperluan">Keperluan<button type="button" class="text-wajib" disabled data-bs-toggle="button">Wajib</button></label>
                                <select class="input-tambah" id="keperluan" name="keperluan" required>
                                    <option value="">Pilih Keperluan</option>
                                    <option value="Mutasi Masuk">Mutasi Masuk</option>
                                    <option value="Perpanjang STNK">Perpanjang STNK</option>
                                    <option value="Perpanjang SIM">Perpanjang SIM</option>
                                    <option value="Perpanjang BPKB">Perpanjang BPKB</option>
                                    <option value="Buat SIM">Buat SIM</option>
                                    <option value="lainnya">Keperluan Lainnya</option>
                                </select>
                                <div id="inputKeperluanLainnya" style="display: none;">
                                    <label class="label-tambah" for="keperluan_lainnya">Warna Lainnya</label>
                                    <input class="input-tambah" type="text" id="keperluan_lainnya" name="keperluan_lainnya" placeholder="Masukkan Keperluan Baru">
                                </div>
                            </div>
                            <div class="py-5 my-2">
                                <label class="label-tambah" for="tanggal">Tanggal<button type="button" class="text-wajib" disabled data-bs-toggle="button">Wajib</button></label>
                                <input class="input-tambah" type="datetime-local" placeholder="Pilih Kategori" id="tanggal" name="tanggal" required>
                            </div>
                            <div class="py-5 my-2">
                                <label class="label-tambah" for="nomor">Nomor WhatsApp<button type="button" class="text-wajib" disabled data-bs-toggle="button">Wajib</button></label>
                                <input class="input-tambah" type="text" placeholder="Masukkan Nomor WhatsApp" id="nomor" title="Nomor Whatsapp tidak boleh kosong" name="nomor" required oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                            </div>
                        </div>
                    </div>
                    <div class="row row-cols-auto mb-4 button-all d-flex ms-0">
                        <div class="delete mt-3 ms-0">
                            <a onMouseOver="this.style.color='#1F2937'" onMouseOut="this.style.color='#1F2937'" style="text-decoration: none; color: #1F2937;" ; href="index.php" class="btn-delete" onclick="delete_all()">
                                <div class="col me-2 text-button">CANCEL</div>
                            </a>
                        </div>
                        <div class="delete mt-3 mx-3">
                            <a onMouseOver="this.style.color='#1F2937'" onMouseOut="this.style.color='#1F2937'" style="text-decoration: none; color: #1F2937;" ; href="" class="btn-delete">
                                <button class="btn-data" type="submit" name="submit">
                                    <div class="col me-2 text-button">SIMPAN</div>
                                </button>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="main.js"></script>
</body>

</html>