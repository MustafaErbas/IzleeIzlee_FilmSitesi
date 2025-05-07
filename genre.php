<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="film.css">
    <title>Genres</title>
</head>
<body>
<?php

?>
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
    $tur = '';
    include "db.php";
    if(isset($_GET['tur'])) {
        $tur = $_GET['tur'];
    }
    $show = $db->prepare("SELECT * FROM `filmler` WHERE film_turu LIKE '%$tur%'");
    $show->execute();
    $result = $show->get_result();
    ?>
<div class="container mt-3">
    <h1 class="text-center mor text-info mb-3"> <?php echo $tur?> Filmleri</h1>
    <table align="center" class="table table-striped table-hover table-secondary">
        <thead>
        <tr>
            <th>Film</th>
            <th>Türü</th>
            <th>Yönetmeni</th>
            <th>Yıldızları</th>
            <th>Çıkış yılı</th>
            <th>Ortalama Puanı</th>
        </tr>
        </thead>
    <tbody>
    <?php

    while($row = mysqli_fetch_assoc($result)) {
        $ID = $row['film_ID'];
        $adi = $row['film_adi'];
        $tur = $row['film_turu'];
        $yonetmen = $row['film_yonetmeni'];
        $yildiz = $row['film_yildizi'];
        $yil = $row['film_yil'];
        $ort = $row['ortpuan'];

    ?>
         <tr style="height: 100px">
            <td><a class="nav-link fs-5" href="film.php?film=<?php echo $adi?>"><?php echo $adi;?></a></td>
             <td><?php echo $tur;?></td>
            <td><?php echo $yonetmen;?></td>
            <td><?php echo $yildiz;?></td>
             <td><?php echo $yil;?></td>
             <td><?php echo $ort;?>/5<i class="fa-solid fa-star" style="color: #e6e916;"></i></td>
        </tr>

    <?php } ?>
    </tbody>
</table>
</div>

</div>
<br>
<br>
<br>
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
                <p>Email: erbasmustafa10qgmail.com</p>
                <p>Telefon: (536) 944-5065</p>
            </div>
        </div>
    </div>
</footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js" integrity="sha384-Rx+T1VzGupg4BHQYs2gCW9It+akI2MM/mndMCy36UVfodzcJcF0GGLxZIzObiEfa" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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