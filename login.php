<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Sayfası</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" >
    <link rel="stylesheet" type="text/css" href="film.css">
    <style>
        a:hover {
            text-decoration: none;
        }
        #degistir{position:absolute;bottom:0px;right:0px;top:32px;width:40px;display:flex;justify-content:center;align-items:center;border-top-right-radius:.25rem;border-bottom-right-radius:.25rem}
        .form-group{position:relative}
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4>Login</h4>
                </div>
                <div class="card-body">
                    <form method="post">
                        <div class="form-group">
                            <label for="username">Kullanıcı Adı:</label>
                            <input type="text" class="form-control" name="username" placeholder="Kullanıcı adınızı girin" required>
                        </div>
                        <div class="form-group">
                            <label for="sifre">Şifre:</label>
                            <input type="password" name="sifre" class="form-control sifre" placeholder="Şifrenizi girin" required>
                            <i id="degistir" class="fa fa-eye text-white bg-primary"></i>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Giriş Yap</button>
                        <a href="kayıt.php"> <button type="button" class="btn btn-warning btn-block mt-4">Kayıt olmak için tıklayın</button> </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-lg" align="center">
    <?php
    session_start();

    include "db.php";
    if ($_POST) {
        $username = $_POST['username'];
        $password = $_POST['sifre'];
        $hashpassword = md5(sha1($password));
        $hashuser = md5(sha1($username));

        $giris = $db->prepare("SELECT * FROM usertable WHERE hashusername='$hashuser' AND hashpassword='$hashpassword'");
        $giris->execute();
        $sonuc = $giris->get_result();

        if ($sonuc->num_rows == 1) {
            $row = $sonuc->fetch_assoc();
            $_SESSION['oturum'] = true;
            $_SESSION['username'] = $row['username'];
            $_SESSION['ID'] = $row['ID'];
            header('Location: profil.php');
            exit;
        } else {
            echo "<div class='text-white'>Kullanıcı adı veya şifre hatalı</div>";
        }
    }
    ?>

</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function () {
        $("#degistir").click(function () {
            if ($(".sifre").attr("type") == "password") {
                $(".sifre").attr("type", "text");
            }
            else {
                $(".sifre").attr("type", "password");
            }
        });
    });
</script>

</body>
</html>

