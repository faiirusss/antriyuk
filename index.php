<?php
session_start();
if (!isset($_SESSION['logged_in'])) {
    header('Location: login.php');
}

require 'functions.php';

$jumlahDataPerHalaman = 8;
$jumlahData = count(query("SELECT * FROM data_user"));
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);

if (isset($_GET["halaman"])) {
    $halamanAktif = $_GET["halaman"];
} else {
    $halamanAktif = 1;
}

$awal_data = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;
$artikel = query("SELECT * FROM data_user LIMIT $awal_data, $jumlahDataPerHalaman");

$jumlahLink =  2;
if ($halamanAktif > $jumlahLink) {
    $startNumber = $halamanAktif - $jumlahLink;
} else {
    $startNumber = 1;
}

if ($halamanAktif < ($jumlahHalaman - $jumlahLink)) {
    $endNumber  = $halamanAktif + $jumlahLink;
} else {
    $endNumber  = $jumlahHalaman;
}

$awal_data = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;
$data = query("SELECT * FROM data_user ORDER BY id DESC LIMIT $awal_data, $jumlahDataPerHalaman");
$total_data = query("SELECT COUNT(*) AS total_data FROM data_user;");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ANTRIYUK</title>
    <link rel="stylesheet" href="css/style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="components/jquery-3.7.1.min.js"></script>
</head>

<bod>
    <header>
        <nav class="navbar">
            <div class="container">
                <h2 class="navbar-text">AntriYUK</h2>
                <!-- Example single danger button -->
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
        <div class="box-primary row gx-5 text-center mx-5 my-5 container-fluid">
            <div class="container text-center btn-table">
                <div class="row row-cols-auto mb-4 button-all d-flex">
                    <div class="delete mt-3 ms-3">
                        <a onMouseOver="this.style.color='#1F2937'" onMouseOut="this.style.color='#1F2937'" style="text-decoration: none; color: #1F2937;" ; href="javascript:void(0)" class="link_delete btn-delete" onclick="delete_all()">
                            <div class="col me-2 text-button">Hapus</div>
                        </a>
                    </div>
                    <div class="delete mt-3 mx-3">
                        <a onMouseOver="this.style.color='#1F2937'" onMouseOut="this.style.color='#1F2937'" style="text-decoration: none; color: #1F2937;" ; href="tambahdata.php" class="link_delete btn-delete">
                            <div class="col me-2 text-button">Tambah Data</div>
                        </a>
                    </div>

                    <div class="right mt-3 d-flex align-items-center">
                        <div class="search-box">
                            <form action="" method="POST">
                                <input type="search" placeholder="Type to search.." name="keyword" id="keyword" autocomplete="off">
                            </form>
                            <div class="search-icon">
                                <i class="fas fa-search"></i>
                            </div>
                            <div class="cancel-icon">
                                <i class="fas fa-times"></i>
                            </div>
                            <div class="search-data">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-11 ms-4 text-start shadow-sm mb-5 rounded-2 box">
                    <!--=====TABLE=====-->
                    <div id="container">
                        <form method="POST" id="frm">
                            <table class=" table table-hover">
                                <thead class="table table-sm" valign="middle">
                                    <tr class="">
                                        <th>
                                            <input class="ms-2" type="checkbox" onclick="select_all()" id="delete">
                                        </th>
                                        <th>NO STNK</th>
                                        <th>NAMA</th>
                                        <th>KEPERLUAN</th>
                                        <th>DATA MASUK</th>
                                        <th>WAKTU ANTRIAN</th>
                                        <th>WAKTU</th>
                                        <th>NO WHATSAPP</th>
                                        <th>AKSI</th>

                                    </tr>
                                </thead>

                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($data as $row) : ?>

                                        <tr valign="middle" id="box<?php echo $row['id'] ?>">
                                            <td style="display: none;" class="user_id"><?php echo $row["id"]; ?></td>
                                            <td>
                                                <input class="ms-2" type="checkbox" id="<?php echo $row['id'] ?>" name="checkbox[]" value="<?php echo $row['id'] ?>" />
                                            </td>
                                            <td><?php echo $row["no_stnk"] ?></td>
                                            <td><?php echo $row["nama"] ?></td>
                                            <td><?php echo $row["keperluan"] ?></td>
                                            <td><?php echo $row["tanggal"]; ?></td>
                                            <td><?php echo $row["waktu_antrian"] ?></td>

                                            <td>
                                                <script type="text/javascript">
                                                    var count_id_<?php echo $row['id']; ?> = "<?php echo $row["waktu_antrian"] ?>"
                                                    var countDownDate_<?php echo $row['id']; ?> = new Date(count_id_<?php echo $row['id']; ?>).getTime();
                                                    var x_<?php echo $row['id']; ?> = setInterval(function() {
                                                        var now = new Date().getTime();
                                                        var distance = countDownDate_<?php echo $row['id']; ?> - now;

                                                        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                                        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                                        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                                                        document.getElementById("demo_<?php echo $row['id']; ?>").innerHTML = hours + ":" + minutes + ":" + seconds;
                                                        var userId = <?php echo $row['id']; ?>;

                                                        if ((minutes == 14) && (seconds == 59)) {
                                                            kirimPesan(userId);
                                                        }

                                                        if (distance < 0) {
                                                            clearInterval(x_<?php echo $row['id']; ?>);
                                                            document.getElementById("demo_<?php echo $row['id']; ?>").innerHTML = "timeout";

                                                            // Make an AJAX request to update the database
                                                            updateDatabase(userId);
                                                        }
                                                    }, 1000);

                                                    function updateDatabase(userId) {
                                                        // Make an AJAX request to update the database
                                                        var xhr = new XMLHttpRequest();
                                                        xhr.open("POST", "response.php", true);
                                                        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                                                        xhr.onreadystatechange = function() {
                                                            if (xhr.readyState == 4 && xhr.status == 200) {
                                                                console.log(xhr.responseText);
                                                            }
                                                        };
                                                        xhr.send("userId=" + userId);
                                                    }
                                                </script>
                                                <span id="demo_<?php echo $row['id']; ?>"></span>
                                            </td>
                                            <td><?php echo $row["nomor"] ?></td>
                                            <td>
                                                <button class="button-kirim" type="button" onclick="kirimPesan(<?= $row['id']; ?>)">Kirim</button>
                                            </td>
                                        </tr>
                                        <?php $i++; ?>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </form>
                    </div>
                    <div class="mt-5 pb-2">
                        <!-- pagination -->
                        <?php if ($halamanAktif > 1) : ?>
                            <a href=" ?halaman=<?php echo 1 ?>" style="text-decoration: none; margin-right: 12px;">
                                &laquo;
                            </a>
                            <a href=" ?halaman=<?php echo $halamanAktif - 1 ?>" style="text-decoration: none;">
                                &lsaquo;
                            </a>
                        <?php endif; ?>

                        <?php for ($i = $startNumber; $i <= $endNumber; $i++) : ?>
                            <?php if ($halamanAktif == $i) : ?>
                                <a href="?halaman=<?php echo $i; ?>" style="background-color: #FF6600; color: #fff; text-decoration: none; border-radius: 3px; padding: 5px; margin:5px;">
                                    <?php echo $i; ?>
                                </a>
                            <?php else : ?>
                                <a href="?halaman=<?php echo $i; ?>" style="text-decoration: none; padding: 5px; margin:5px;">
                                    <?php echo $i; ?>
                                </a>
                            <?php endif; ?>
                        <?php endfor; ?>

                        <?php if ($halamanAktif < $jumlahHalaman) : ?>
                            <a href="?halaman=<?php echo $halamanAktif + 1 ?>" style="text-decoration: none;">
                                &rsaquo;
                            </a>
                            <a href="?halaman=<?php echo $jumlahHalaman ?>" style="text-decoration: none; margin-left: 12px;">
                                &raquo;
                            </a>
                        <?php endif; ?>
                        <!-- end pagination -->
                    </div>
                </div>

            </div>
        </div>
    </main>

    <script src="components/ajax.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script>
        function kirimPesan(id) {
            $.ajax({
                type: "POST",
                url: "send_message.php",
                data: {
                    id: id
                },
                success: function(response) {
                    // Handle respons jika diperlukan
                    console.log(response);

                    // Anda dapat menampilkan pesan sukses menggunakan library seperti SweetAlert
                    Swal.fire(
                        'Berhasil',
                        'Pesan berhasil dikirim',
                        'success'
                    );
                },
                error: function(error) {
                    // Handle error jika diperlukan
                    console.error(error);

                    // Anda dapat menampilkan pesan error menggunakan library seperti SweetAlert
                    Swal.fire(
                        'Gagal',
                        'Terjadi kesalahan saat mengirim pesan',
                        'error'
                    );
                }
            });
        }
    </script>

    </body>

</html>