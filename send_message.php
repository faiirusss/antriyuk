<?php
require 'functions.php';

if (isset($_POST["id"])) {
    $id = $_POST["id"];
    $datas = query("SELECT * FROM data_user WHERE id=$id");
    $token = "19pc@aTnG_h+dHdhd-!-";
    date_default_timezone_set('Asia/Jakarta');

    foreach ($datas as $data) {
        $target = $data['nomor'];
        $no_antri = $data['no_antri'];
        $nama = $data['nama'];
        $keperluan = $data['keperluan'];
        $tanggal = date("Y-m-d H:i:s");
        $waktu_antrian = $data['waktu_antrian'];

        $antrian = strtotime($waktu_antrian);
        $antri = strtotime($tanggal);
        $waktu_difference = $antrian - $antri;

        // Calculate hours, minutes, and seconds from the time difference
        $hours = floor($waktu_difference / 3600); // 1 hour = 3600 seconds
        $minutes = floor(($waktu_difference % 3600) / 60); // 1 minute = 60 seconds
        $seconds = $waktu_difference % 60;

        // Format the time difference
        $sisa = sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);
    }

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.fonnte.com/send',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array(
            'target' => $target,
            'message' => "Nomor antrian $no_antri atas nama $nama dengan keperluan $keperluan. Waktu antrian anda di jam $waktu_antrian, tersisa $sisa menit. Harap segera menuju ke tempat",
            'schedule' => '1702957922'
        ),
        CURLOPT_HTTPHEADER => array(
            "Authorization: $token"
        ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);

    // Anda dapat mengirim respons kembali ke permintaan AJAX jika diperlukan
    echo $response;
} else {
    // Handle kasus ketika parameter "id" tidak diatur
    echo "Error: Parameter ID tidak diatur.";
}
