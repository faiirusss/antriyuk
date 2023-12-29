<?php

require 'functions.php';

$id = $_GET["id"];

if (isset($_POST['checkbox'][0])) {

    foreach ($_POST['checkbox'] as $list) {
        $id = mysqli_real_escape_string($conn, $list);
        mysqli_query($conn, "DELETE FROM data_user WHERE id=$id");
    }
}

if (hapus($id) > 0) {
    echo "
            <script>
                alert('data berhasil dihapus');
                document.location.href = 'index.php';
            </script>
        ";
} else {
    echo "
            <script>
                alert('data gagal dihapus');
                document.location.href = 'index.php';
            </script>
        ";
}
