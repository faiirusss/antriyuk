<?php

$conn = mysqli_connect("localhost", "root", "", "antriyuk");

function query($query)
{
    global $conn;
    $rows = array();

    $result = mysqli_query($conn, $query);
    $row = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    return $rows;
}

function tambah_data($data)
{
    global $conn;
    date_default_timezone_set('Asia/Jakarta');

    $no_stnk = $data["no_stnk"];
    $nama = $data["nama"];
    $keperluan = mysqli_escape_string($conn, $data["keperluan"]);
    if ($keperluan == "lainnya") {
        // Jika pengguna memilih kategori lainnya, ambil nilai dari input teks
        $keperluanBaru = $data["keperluan_lainnya"];
        $keperluan = $keperluanBaru;
    }
    $tanggal = $data["tanggal"];
    $waktu_antri = "";
    $nomor = $data["nomor"];
    $no_antri = 0;

    $result = mysqli_query($conn, "SELECT * FROM data_user ORDER BY ID DESC");
    $count = mysqli_num_rows($result);

    if ($count == 0) {
        // If result is 0, set $waktu_antri to the current time plus 30 minutes
        $waktu_antri = date("Y-m-d H:i:s", time() + 60 * 30);
        $no_antri = 1;
    } else {
        // If result is 1 or more, fetch the last row
        $lastRow = mysqli_fetch_assoc($result);
        // Now you can use the data from the last row as needed
        $waktu_antri = date("Y-m-d H:i:s", strtotime($lastRow['waktu_antrian']) + 60 * 30);
        $no_antri = $lastRow['no_antri'] + 1;
    }

    $tgl = strtotime($tanggal);
    $antri = strtotime($waktu_antri);
    $sisa_waktu = $antri - $tgl;
    $antrian = gmdate("H:i:s", $sisa_waktu);


    mysqli_query(
        $conn,
        "INSERT INTO data_user 
        VALUES
            ('NULL', 
            '$no_antri',
            '$no_stnk',
            '$nama',
            '$keperluan',
            '$tanggal',
            '$waktu_antri',
            '$antrian',
            '$nomor'
            )"
    );

    return mysqli_affected_rows($conn);
}

function hapus($id)
{
    global $conn;

    mysqli_query($conn, "DELETE FROM data_user WHERE id = $id");

    return mysqli_affected_rows($conn);
}
