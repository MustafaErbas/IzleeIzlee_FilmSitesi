<?php

session_start();


include "db.php";
if (!isset($_SESSION['oturum'])) {
    header("Location:login.php");
    exit;
}
$show = $db->prepare("SELECT * FROM usertable WHERE ID = ?");
$show->bind_param("s", $_SESSION['ID']);
$show->execute();
$result = $show->get_result();
$row = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ad = $_POST["ad"];
    $soyad = $_POST["soyad"];
    $mail = $_POST["mail"];
    $numara = $_POST["numara"];
    $adres = $_POST["adres"];
    $password = $_POST["sifre"];
    $hashpassword = md5(sha1($password));
    $user = $_POST["user"];
    $hashusername = md5(sha1($user));
    if ($ad==$row["ad"] && $soyad==$row["soyad"] && $mail==$row["mail"] && $numara==$row["numara"] && $adres==$row["adres"] && $password==$row["password"] && $user==$row["username"]) {
        echo "<script>alert('Girdiğiniz Bütün Veriler Aynı');</script>";
    }
    elseif ($row["username"]!= $user) {
        $query = "SELECT * FROM usertable WHERE username = '$user'";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0){
            echo "<script>alert('Girdiğiniz Kullanıcı Adı Kullanılıyor.');</script>";
            $stmt->close();
        }else {
            $update = $db->prepare("UPDATE usertable SET password=?, hashpassword=? ,ad=?, soyad=?, mail=?, numara=?, adres=? , username=?, hashusername=?   WHERE ID=?");
            $update->bind_param("sssssissss", $password, $hashpassword, $ad, $soyad, $mail, $numara, $adres, $user, $hashusername, $_SESSION['ID']);
            $update->execute();
            $_SESSION['username'] = $user;
            if ($update->execute()) {
                echo "<script>alert('Profil bilgileri başarılı bir şekilde güncellendi.');</script>";
            } else {
                echo "<script>alert('Bir hata oluştu. Profil bilgileri güncellenemedi.');</script>";
            }

        }
    }
    elseif ($row["mail"] != $mail) {
        $query = "SELECT * FROM usertable WHERE mail = '$mail'";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0){
            echo "<script>alert('Bu E-Mail Kullanılıyor.');</script>";
            $stmt->close();
        }else {
            $update = $db->prepare("UPDATE usertable SET password=?, hashpassword=? ,ad=?, soyad=?, mail=?, numara=?, adres=? , username=?, hashusername=?   WHERE ID=?");
            $update->bind_param("sssssissss", $password, $hashpassword, $ad, $soyad, $mail, $numara, $adres, $user, $hashusername, $_SESSION['ID']);
            $update->execute();
            $_SESSION['username'] = $user;

            if ($update->execute()) {
                echo "<script>alert('Profil bilgileri başarılı bir şekilde güncellendi.');</script>";
            } else {
                echo "<script>alert('Bir hata oluştu. Profil bilgileri güncellenemedi.');</script>";
            }
        }
    }
    else {
        $update = $db->prepare("UPDATE usertable SET password=?, hashpassword=? ,ad=?, soyad=?, mail=?, numara=?, adres=? , username=?, hashusername=?   WHERE ID=?");
        $update->bind_param("sssssissss", $password, $hashpassword, $ad, $soyad, $mail, $numara, $adres, $user, $hashusername, $_SESSION['ID']);
        $update->execute();
        $_SESSION['username'] = $user;
        if ($update->execute()) {
            echo "<script>alert('Profil bilgileri başarılı bir şekilde güncellendi.');</script>";
        } else {
            echo "<script>alert('Bir hata oluştu. Profil bilgileri güncellenemedi.');</script>";
        }
    }

}

$show = $db->prepare("SELECT * FROM usertable WHERE ID = ?");
$show->bind_param("s", $_SESSION['ID']);
$show->execute();
$result = $show->get_result();
$row = $result->fetch_assoc();


?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profil</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="film.css">
    <style>
        li{
            list-style-type: none;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg bg-dark border-bottom border-body bg-body-tertiary " data-bs-theme="dark" style="height: 100px">
    <div class="container-fluid" >
        <a href="index.php"><span class="navbar-brand mb-0 h1 fs-2 text-info">İzLeeİzLee <i class="fa-solid fa-clapperboard fa-lg" style="color: #00e1ff;"></i></span></a>
        <div class="container d-flex justify-content-center" style="position: relative;width: 71%">
            <form class="d-flex" style="width: 60%" role="search">
                <input type="text" class="col-12 form-control" id="live_search" autocomplete="off" placeholder="Film Aratınız...">
            </form>
            <div class="position-absolute" id="searchresult" style="top: 100%; left: 0; right: 0; width: 80%; padding-left: 240px; z-index: 999;"></div>
        </div>
        <div class="nav justify-content-end d-inline" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link fs-4" href="favoriler.php"><i class="fa-solid fa-heart fa-lg" style="color: #e60f0f;"></i> Favoriler</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fs-4" href="profil.php"><i class="fa-solid fa-user fa-lg" style="color: #00ff62;"></i> Profil</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

    <ul class="nav nav-pills nav-fill bg-dark text py-1 px-1">
        <li class="nav-item">
            <a class="nav-link fs-5 b text-info" href="genre.php?tur=Dram">Dram</a>
        </li>
        <li class="nav-item">
            <a class="nav-link fs-5 b text-info" href="genre.php?tur=Suç">Suç</a>
        </li>
        <li class="nav-item">
            <a class="nav-link fs-5 b text-info" href="genre.php?tur=Aksiyon">Aksiyon</a>
        </li>
        <li class="nav-item">
            <a class="nav-link fs-5 b text-info" href="genre.php?tur=Gerilim">Gerilim</a>
        </li>
        <li class="nav-item">
            <a class="nav-link fs-5 b text-info" href="genre.php?tur=Macera">Macera</a>
        </li>
        <li class="nav-item">
            <a class="nav-link fs-5 b text-info" href="genre.php?tur=Fantastik">Fantastik</a>
        </li>
        <li class="nav-item">
            <a class="nav-link fs-5 b text-info" href="genre.php?tur=Romantizm">Romantizm</a>
        </li>
        <li class="nav-item">
            <a class="nav-link fs-5 b text-info" href="genre.php?tur=Bilim">Bilim-Kurgu</a>
        </li>
        <li class="nav-item">
            <a class="nav-link fs-5 b text-info" href="genre.php?tur=Savaş">Savaş</a>
        </li>
        <li class="nav-item">
            <a class="nav-link fs-5 b text-info" href="genre.php?tur=Komedi">Komedi</a>
        </li>
        <li class="nav-item">
            <a class="nav-link fs-5 b text-info" href="genre.php?tur=Tarih">Tarih</a>
        </li>
    </ul>

    <div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card text-bg-light overflow-hidden">
                <div class="row card-header text-center ">
                    <h2 style="display: inline-block">Profil Bilgileri</h2>
                </div>
                <div class="card-body">
                    <img src="../profilfotosu.png" class="img-fluid rounded-circle mx-auto d-block mb-3" style="max-width: 150px;">
                    <form method="post">
                        <h2>Kişisel Bilgiler</h2>
                        <p><strong>Ad:</strong> <input required style="width: 80%" type="text" name="ad" value="<?php echo $row["ad"]; ?>"></p>
                        <p><strong>Soyad:</strong> <input required style="width: 80%" type="text" name="soyad" value="<?php echo $row["soyad"]; ?>"></p>
                        <p><strong>E-Mail:</strong> <input required style="width: 80%" type="email" name="mail" value="<?php echo $row["mail"]; ?>"></p>
                        <p><strong>Telefon:</strong> <input required style="width: 80%" type="number" name="numara" value="<?php echo $row["numara"]; ?>"></p>
                        <p><strong>Adres:</strong> <input required style="width: 80%" type="text" name="adres" value="<?php echo $row["adres"]; ?>"></p>
                        <hr>
                        <h2>Kullanıcı Bilgileri</h2>
                        <p><strong>Kullanıcı Ad:</strong> <input required style="width: 80%" type="text" name="user" value="<?php echo $row["username"]?>"></p>
                        <p><strong>Şifre:</strong> <input required style="width: 80%" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).{8,}$" title="Lütfen en az 8 karakter kullanınız!! En az bir sayı, bir küçük harf ve bir büyük harf içermelidir. Boşluk içeremez." type="text" name="sifre" value="<?php echo $row["password"]; ?>"></p>
                        <div align="right">
                            <button type="submit" class="btn btn-primary">Güncelle</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
    <footer class="bg-dark text-light py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h3>İzLeeİzLee</h3>
                    <p>En iyi filmleri değerlendirmek ve yorumlamak için en iyi yer!</p>
                </div>
                <div class="col-md-4">
                    <h3>Hızlı Linkler</h3>
                    <ul class="list-unstyled">
                        <li><a href="index.php">Anasayfa</a></li>
                        <li><a href="profil.php">Profil</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h3>İletişim Bilgileri</h3>
                    <p>Adres: 19 Mayıs, Büyükdere Cd. No:22, 34360 Şişli/İstanbul</p>
                    <p>Email: erbasmustafa10@gmail.com</p>
                    <p>Telefon: (536) 944-5065</p>
                </div>
            </div>
        </div>
    </footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js" integrity="sha384-Rx+T1VzGupg4BHQYs2gCW9It+akI2MM/mndMCy36UVfodzcJcF0GGLxZIzObiEfa" crossorigin="anonymous"></script>
<script type="text/javascript">
    $(document).on("click", function(e) {
        if (!$(e.target).is("#searchresult") && !$(e.target).is("#live_search")) {
            $("#searchresult").css("display", "none");
        }
    });

    $("#live_search").click(function(e) {
        e.stopPropagation();
        $("#searchresult").css("display", "block");
    });

    $("#live_search").keyup(function() {
        var input = $(this).val();

        if (input != "") {
            $.ajax({
                url: "ajax.php",
                method: "POST",
                data: { input: input },
                success: function(data) {
                    $("#searchresult").html(data);
                    $("#searchresult").css("display", "block");
                }
            });
        } else {
            $("#searchresult").html("");
            $("#searchresult").css("display", "none");
        }
    });
</script>
</body>
</html>

