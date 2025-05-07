<?php
session_start();
include "db.php";
$film = '';
if(isset($_GET['film'])) {
    $film = $_GET['film'];
}
$oturum = isset($_SESSION['oturum']) && $_SESSION['oturum'] === true;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Film <?php echo $film?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="film.css">
    <style>
        img{
            width: 30%;
            height: auto;
        }
        li{
            list-style-type: none;
        }
    </style>
</head>
<body>
<div>
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

    <?php
    $show = $db->prepare("SELECT * FROM `filmler` WHERE film_adi like '%$film%'");
    $show->execute();
    $result = $show->get_result();
    ?>
    <div class="container" style="width: 50%">
    <?php
    $row = mysqli_fetch_assoc($result) ;
        $FID = $row['film_ID'];
        $adi = $row['film_adi'];
        $yonetmen = $row['film_yonetmeni'];
        $turu = $row['film_turu'];
        $yildizi = $row['film_yildizi'];
        $oyuncuları = $row['film_oyuncilari'];
        $yazar = $row['film_yazari'];
        $text = $row['film_aciklamasi'];

    $fotografDizini = 'kapak/';
    $fotoYolu = $fotografDizini . $FID . '.jpg';

    if ($_SERVER["REQUEST_METHOD"] == "POST" && $oturum) {
        if (isset($_POST['ilkform'])){
        $kullanici_adi = $_SESSION['username'];
        $yorum = $_POST["yorum"];
        $puan = $_POST["puan"];

        $sql = "INSERT INTO flim_yorumları (film_ID, film_adi,username, yorum,puan) VALUES ('$FID', '$adi','$kullanici_adi', '$yorum','$puan')";

        if ($db->query($sql) === TRUE) {
            echo "<script>alert('Yorumunuz başarılı bir şekilde eklenmiştir');</script>";
        }
        else {
            echo "Hata: " . $sql . "<br>" . $db->error;
        }
    }
    }
    elseif ($_SERVER["REQUEST_METHOD"] == "POST" && !$oturum) {
        if (isset($_POST['ilkform'])){
        echo "<script>alert('Log in olmadan yorum yapamazsınız. Lütfen log in olun ') ;</script>";
    }
    }

    $sql = "SELECT puan FROM flim_yorumları WHERE film_id = '$FID'";
    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        $toplam_puan = 0;
        $puan_sayisi = 0;

        while ($row = $result->fetch_assoc()) {
            $puan = $row["puan"];
            $toplam_puan += $puan;
            $puan_sayisi++;
        }

        if ($puan_sayisi > 0) {
            $ortalama_puan = $toplam_puan / $puan_sayisi;
            $ortalama_puan=number_format($ortalama_puan, 2);
        } else {
            $ortalama_puan = 0;
        }
        $sqlp = "UPDATE filmler SET ortpuan = $ortalama_puan WHERE film_ID = $FID";
        $db->query($sqlp);

    }
    ?>
        <div align="center" class="container mt-3">
            <img align="center" src="<?php echo $fotoYolu; ?>">
        </div>

        <h1 class="text-secondary text-center mt-3 text-uppercase fw-bold"><?php echo $adi?></h1>
        <p class="text-secondary text-center fs-4 fw-semibold"> Ort Puan: <?php echo $ortalama_puan ?>/5 <i class="fa-solid fa-star" style="color: #e6e916;"></i> </p>
        <hr style="color: white">
        <p class="text-secondary fs-4 d-inline-block fw-semibold">Filmin Türü:  </p> <p class="text-white fs-5 d-inline-block Normal weight text">  <?php echo $turu ?> </p>
        <hr style="color: white">
        <p class="text-secondary fs-4 d-inline-block fw-semibold">Yönetmen:  </p> <p class="text-white fs-5 d-inline-block Normal weight text">  <?php echo $yonetmen ?> </p>
        <hr style="color: white">
        <p class="text-secondary fs-4 d-inline-block fw-semibold">Yazar:  </p> <p class="text-white fs-5 d-inline-block Normal weight text">  <?php echo $yazar ?> </p>
        <hr style="color: white">
        <p class="text-secondary fs-4 d-inline-block fw-semibold">Yıldızları:  </p> <p class="text-white fs-5 d-inline-block Normal weight text">  <?php echo $yildizi ?> </p>
        <hr style="color: white">
        <p class="text-secondary fs-4 fw-semibold">Oyuncuları:  </p> <p class="text-white fs-5 Normal weight text">  <?php echo $oyuncuları ?> </p>
        <hr style="color: white">
        <h3 class="text-secondary text-center">Filmin Konusu</h3>
        <p class="text-white fs-5 Normal weight text"> <?php echo $text ?></p>
        <hr style="color: white">
        <h3 class="text-secondary text-center">Filmin Yorumları</h3>

        <?php

        ?>
<?php
        $sql = "SELECT * FROM flim_yorumları WHERE film_ID = '$FID'";
        $result = $db->query($sql);
        ?>

        <?php if ($result->num_rows > 0): ?>
            <ul class="text-light list-group">
                <?php while ($row = $result->fetch_assoc()): ?>
                    <li>Kullanıcı: <?php echo $row["username"]; ?></li>
                    <li>Puanı: <?php echo $row["puan"]; ?>/5 <i class="fa-solid fa-star" style="color: #e6e916;"></i></li>
                    <li class="list-group-item"><?php echo $row["yorum"]; ?></li>
                    <br>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p align="center" class="text-light fw-bold">Henüz yorum yapılmamış.</p>
        <?php endif; ?>

        <div class="d-flex justify-content-center">
        <button type="button" class="btn btn-primary btn-lg mb-3" style="width: 80%" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Yorum Yap
        </button>

        <div class="modal fade " id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Film hakkında düşüncelerini yaz</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" id="myForm" name="ilkform">
                            <input type="hidden" name="username" value="<?php if($oturum){$_SESSION['username'];}?>">
                            <div class="form-group">
                                <label for="yorum">Yorum:</label>
                                <textarea class="form-control" id="yorum" name="yorum" style="height: 300px" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="puan">Puan (0-5 arası)</label>
                                <input type="number" class="form-control" id="puan" name="puan" min="0" max="5" required>
                            </div>
                            <div class="d-flex justify-content-between mt-3">
                                <button type="submit" class="btn btn-primary" name="ilkform">Yorum Ekle</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <div class="d-flex justify-content-center">

            <form method="post" id="favoriForm" name="favori_ekle">
                <input type="hidden" name="film_id" value="<?php $FID?>">
                <input type="hidden" name="film_adi" value="<?php $adi?>">
                <input type="hidden" name="user_id" value="<?php if($oturum){$_SESSION['ID'];}?>">
                <input type="hidden" name="username" value="<?php if($oturum){$_SESSION['username'];}?>">
                <input class="btn btn-success btn-lg mb-3" type="submit" name="favori_ekle" value="Favorilere Ekle">
            </form>
            <?php
            if(isset($_POST['favori_ekle'])&& $oturum) {
                $user_id = $_SESSION['ID'];
                $username = $_SESSION['username'];

                $kontrol ="SELECT * From favoriler WHERE film_ID = '$FID' AND user_ID = '$user_id'";
                $kontrol_result = $db->query($kontrol);
                if ($kontrol_result->num_rows > 0){
                     echo "<script>alert('Bu film zaten favorilerinizde bulunuyor!');</script>";

                }else {

                    $sql = "INSERT INTO favoriler (film_ID, film_adi, user_ID, username) VALUES ('$FID', '$adi', '$user_id', '$username')";

                    if ($db->query($sql) === TRUE) {
                        echo "<script>alert('Film favorilere eklendi!') ;</script>";

                    } else {
                        echo "<script>alert('Film favorilere eklenirken bir hata oluştu!') ;</script>";
                    }
                }
            }elseif(isset($_POST['film_id'])&& !$oturum){
                echo "<script>alert('Log in bu işlemi yapamazsınız. Lütfen log in olun ') ;</script>";
            }
            ?>
        </div>
 </div>
</div>
    <footer class="bg-dark text-light py-4">
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

