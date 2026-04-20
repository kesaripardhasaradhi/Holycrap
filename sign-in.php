<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        body, html { background: rgb(24, 24, 28) !important; }
    </style>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log-In</title>
    <link href="css/imports.css" rel="stylesheet">
    <link href="css/config.css" rel="stylesheet">
    <link rel="stylesheet" href="css/snackbar.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@5/dark.css" />
    <script src="js/snackbar.js"></script>
    <style>
        .swal2-container { z-index: 20000 !important; }
    </style>
</head>

<body>
    <section id="login" name="regular" class="form">
        <div class="container h-100">
            <div class="row justify-content-center align-items-center h-100">
                <div class="col-md-10 col-lg-5">
                    <div class="login-box" data-aos="fade-up" data-aos-duration="1500">
                        <center><h2>Log-In</h2></center>
                        <form method="post" id="login-form">
                            <div class="form-input-icon mb-3 mt-4">
                                <i class="fas fa-key"></i>
                                <input class="auth-input" type="password" placeholder="Token" id="token">
                            </div>
                            <button type="button" class="button primary d-block mt-3 w-100" onclick="login(this);" style="color:black">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="overlay-top-right"></div>
        <div class="overlay-bottom-right"></div>
        <div class="overlay-bottom-left"></div>
        <audio id="player" preload="auto">
            <source src="file/song.mp3" type="audio/mp3">
        </audio>
    </section>

    <script src="js/main.js"></script>
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <script src="https://kit.fontawesome.com/44623006da.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="js/bootstrap.js"></script>
    <script src="js/core.js"></script>
    <script src="js/player.js"></script>

</body>
</html>