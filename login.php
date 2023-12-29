<?php
session_start();
if (isset($_SESSION['logged_in'])) {
    header('Location: index.php');
}

require_once 'functions.php';
require_once 'vendor/autoload.php';

$clientID = '385249503599-e1n58iarn1v9c61g59ai68suaocmig0d.apps.googleusercontent.com';
$clientSecret = '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';
$redirectURI = 'http://localhost/antriyuk/login.php';

$client = new  Google_Client();

$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectURI);

$client->addScope('profile');
$client->addScope('email');

if (isset($_GET['code'])) {

    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);

    if (!isset($token['error'])) {
        $client->setAccessToken($token['access_token']);

        $service = new Google_Service_Oauth2($client);
        $profile = $service->userinfo->get();

        // tampung data
        $g_name = $profile['name'];
        $g_email = $profile['email'];
        $g_id = $profile['id'];
        $g_picture = $profile['picture'];

        // session
        $_SESSION['logged_in'] = true;
        $_SESSION['access_token'] = $token['access_token'];
        $_SESSION['name'] = $g_name;
        $_SESSION['email'] = $g_email;
        $_SESSION['picture'] = $g_picture;

        header('Location: index.php');
    } else {

        echo "Login gagal";
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

</head>

<body>

    <div class="split-screen">
        <div class="left">
            <section class="copy">
            </section>
        </div>
        <div class="right">
            <section class="copy">
                <h1>ANTRIYUK</h1>
                <h2>Login</h2>
                <a href="<?php echo $client->createAuthUrl(); ?>">
                    <img src="img/btn_google.png">
                </a>
            </section>
        </div>
    </div>
    </div>

</body>

</html>