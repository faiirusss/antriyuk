<?php
session_start();
require '../functions.php';

// pagination
// konfigurasi
$jumlahDataPerHalaman = 10;
// jumlah halaman = total data / data per halaman
$jumlahData = count(query("SELECT * FROM data_user"));
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
// ternary 
if (isset($_GET["halaman"])) {
    $halamanAktif = $_GET["halaman"];
} else {
    $halamanAktif = 1;
}

$awal_data = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

$keyword = $_GET["keyword"];
$query = "SELECT * FROM data_user
            WHERE
            no_stnk LIKE '%$keyword%' OR
            nama LIKE '%$keyword%' OR
            keperluan LIKE '%$keyword%' OR
            tanggal LIKE '%$keyword%' OR
            waktu_antrian LIKE '%$keyword%' OR
            nomor LIKE '%$keyword%'
            ORDER BY id DESC
            LIMIT $awal_data, $jumlahDataPerHalaman";

$data_user = query($query);

?>

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
        <?php foreach ($data_user as $row) : ?>
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
                            if (distance < 0) {
                                clearInterval(x_<?php echo $row['id']; ?>);
                                document.getElementById("demo_<?php echo $row['id']; ?>").innerHTML = "timeout";

                                // Make an AJAX request to update the database
                                var userId = <?php echo $row['id']; ?>;
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