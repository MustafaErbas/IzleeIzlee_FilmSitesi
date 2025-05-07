<?php
include "db.php";
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Anasayfa</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="film.css">
    <style>
        img{
            max-width: 100%;
            height: auto;
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

    <div class="container-fluid ">
        <div class="row mx-3">
            <div align="center" class="col-2 mt-3 ml-5">
                <?php
                $sql = "SELECT *
            FROM filmler
            ORDER BY film_yil DESC
            LIMIT 4";
                $result = $db->query($sql);

                $firstFilm = null;
                $secondFilm = null;
                $thirdFilm = null;
                $fourthdFilm = null;
                $fotografDizini = 'kapak/';

                if ($result->num_rows > 0) {
                    $rowNum = 1;
                    while ($row = $result->fetch_assoc()) {
                        switch ($rowNum) {
                            case 1:
                                $firstFilm = $row;
                                $fotoYolu1 = $fotografDizini .$firstFilm["film_ID"]  . '.jpg';
                                break;
                            case 2:
                                $secondFilm = $row;
                                $fotoYolu2 = $fotografDizini .$secondFilm["film_ID"]  . '.jpg';
                                break;
                            case 3:
                                $thirdFilm = $row;
                                $fotoYolu3 = $fotografDizini .$thirdFilm["film_ID"]  . '.jpg';
                                break;
                            case 4:
                                $fourthdFilm = $row;
                                $fotoYolu4 = $fotografDizini .$fourthdFilm["film_ID"]  . '.jpg';
                                break;
                            default:
                                break;
                        }
                        $rowNum++;
                    }
                }

                ?>
                <h5 class=" text-white">En Yeni Çıkanlar </h5>
                <div class="card" style="width: 15rem;">
                    <a href="film.php?film=<?php echo $firstFilm["film_adi"]?>"><img src="<?php echo $fotoYolu1 ?>" class="card-img-top" alt="..."></a>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $firstFilm["film_adi"] ?></h5>
                        <p class="card-text"><?php echo $firstFilm["ortpuan"] ?>/5 <i class="fa-solid fa-star" style="color: #e6e916;"></i></p>
                        <p class="card-text">Yönetmeni:<?php echo $firstFilm["film_yonetmeni"] ?></p>
                        <p class="card-text">Yıldızları:<?php echo $firstFilm["film_yildizi"] ?></p>
                    </div>
                </div>
                <div class="card mt-3 mb-3" style="width: 15rem;">
                    <a href="film.php?film=<?php echo $secondFilm["film_adi"]?>"><img src="<?php echo $fotoYolu2 ?>" class="card-img-top" alt="..."></a>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $secondFilm["film_adi"] ?></h5>
                        <p class="card-text"><?php echo $secondFilm["ortpuan"] ?>/5 <i class="fa-solid fa-star" style="color: #e6e916;"></i></p>
                        <p class="card-text">Yönetmeni:<?php echo $secondFilm["film_yonetmeni"] ?></p>
                        <p class="card-text">Yıldızları:<?php echo $secondFilm["film_yildizi"] ?></p>
                    </div>
                </div>
                <div class="card mb-3" style="width: 15rem;">
                    <a href="film.php?film=<?php echo $thirdFilm["film_adi"]?>"><img src="<?php echo $fotoYolu3 ?>" class="card-img-top" alt="..."></a>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $thirdFilm["film_adi"] ?> </h5>
                        <p class="card-text"><?php echo $thirdFilm["ortpuan"] ?>/5 <i class="fa-solid fa-star" style="color: #e6e916;"></i></p>
                        <p class="card-text">Yönetmeni:<?php echo $thirdFilm["film_yonetmeni"] ?></p>
                        <p class="card-text">Yıldızları:<?php echo $thirdFilm["film_yildizi"] ?></p>
                    </div>
                </div>
                <div class="card mb-3" style="width: 15rem;">
                    <a href="film.php?film=<?php echo $fourthdFilm["film_adi"]?>"><img src="<?php echo $fotoYolu4 ?>" class="card-img-top" alt="..."></a>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $fourthdFilm["film_adi"] ?> </h5>
                        <p class="card-text"><?php echo $fourthdFilm["ortpuan"] ?>/5 <i class="fa-solid fa-star" style="color: #e6e916;"></i></p>
                        <p class="card-text">Yönetmeni:<?php echo $fourthdFilm["film_yonetmeni"] ?></p>
                        <p class="card-text">Yıldızları:<?php echo $fourthdFilm["film_yildizi"] ?></p>
                    </div>
                </div>
            </div>
            <div align="center" class="col-10 mt-5 mb-5" >
                <?php
                $sqla = "SELECT *
                FROM filmler
                ORDER BY ortpuan DESC
                LIMIT 3";
                $resulta = $db->query($sqla);

                $firstFilma = null;
                $secondFilma = null;
                $thirdFilma = null;
                $fotografDizinia = 'kapak/';

                if ($resulta->num_rows > 0) {
                    $rowNum = 1;
                    while ($row = $resulta->fetch_assoc()) {
                        switch ($rowNum) {
                            case 1:
                                $firstFilma = $row;
                                $fotoYolua1 = $fotografDizinia .$firstFilma["film_ID"]  . '.jpg';
                                break;
                            case 2:
                                $secondFilma = $row;
                                $fotoYolua2 = $fotografDizinia .$secondFilma["film_ID"]  . '.jpg';
                                break;
                            case 3:
                                $thirdFilma = $row;
                                $fotoYolua3 = $fotografDizinia .$thirdFilma["film_ID"]  . '.jpg';
                                break;
                            default:
                                break;
                        }
                        $rowNum++;
                    }
                }

                ?>
                <div style="height: 1000px">
                <div id="carouselExampleCaptions" class="carousel slide mb-5" style="width: 40%">
                    <h4 class="text-white">En İyi Puanlı Filmler</h4>
                    <hr class="text-white mb-3">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    </div>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <h2 class="text-white"><?php echo $firstFilma["film_adi"] ?></h2>
                            <h4 class="text-white"><?php echo $firstFilma["ortpuan"] ?>/5<i class="fa-solid fa-star" style="color: #e6e916;"></i></h4>
                            <a href="film.php?film=<?php echo $firstFilma["film_adi"]?>"><img src="<?php echo $fotoYolua1 ?>" class="d-block w-100 " alt="..."></a>
                        </div>
                        <div class="carousel-item">
                            <h2 class="text-white"><?php echo $secondFilma["film_adi"] ?></h2>
                            <h4 class="text-white"><?php echo $secondFilma["ortpuan"] ?>/5<i class="fa-solid fa-star" style="color: #e6e916;"></i></h4>
                            <a href="film.php?film=<?php echo $secondFilma["film_adi"]?>"><img src="<?php echo $fotoYolua2 ?>" class="d-block w-100" alt="..."></a>
                        </div>
                        <div class="carousel-item">
                            <h2 class="text-white"><?php echo $thirdFilma["film_adi"] ?></h2>
                            <h4 class="text-white"><?php echo $thirdFilma["ortpuan"] ?>/5<i class="fa-solid fa-star" style="color: #e6e916;"></i></h4>
                            <a href="film.php?film=<?php echo $thirdFilma["film_adi"]?>"><img src="<?php echo $fotoYolua3 ?>" class="d-block w-100" alt="..."></a>
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
                </div>
                <div class="row border p-3 ">
                    <?php
                    $sqlb = "SELECT * FROM filmler ORDER BY RAND() LIMIT 8";

                    $resultb = $db->query($sqlb);
                    $f1 = null;
                    $f2 = null;
                    $f3 = null;
                    $f4 = null;
                    $f5 = null;
                    $f6 = null;
                    $f7 = null;
                    $f8 = null;
                    $fotografDizinib = 'kapak/';

                    if ($resultb->num_rows > 0) {
                        $rowNum = 1;
                        while ($row = $resultb->fetch_assoc()) {
                            switch ($rowNum) {
                                case 1:
                                    $f1 = $row;
                                    $fotoYolub1 = $fotografDizinib .$f1["film_ID"]  . '.jpg';
                                    break;
                                case 2:
                                    $f2 = $row;
                                    $fotoYolub2 = $fotografDizinib .$f2["film_ID"]  . '.jpg';
                                    break;
                                case 3:
                                    $f3 = $row;
                                    $fotoYolub3 = $fotografDizinib .$f3["film_ID"]  . '.jpg';
                                    break;
                                case 4:
                                    $f4 = $row;
                                    $fotoYolub4 = $fotografDizinib .$f4["film_ID"]  . '.jpg';
                                    break;
                                case 5:
                                    $f5 = $row;
                                    $fotoYolub5 = $fotografDizinib .$f5["film_ID"]  . '.jpg';
                                    break;
                                case 6:
                                    $f6 = $row;
                                    $fotoYolub6 = $fotografDizinib .$f6["film_ID"]  . '.jpg';
                                    break;
                                case 7:
                                    $f7 = $row;
                                    $fotoYolub7 = $fotografDizinib .$f7["film_ID"]  . '.jpg';
                                    break;
                                case 8:
                                    $f8 = $row;
                                    $fotoYolub8 = $fotografDizinib .$f8["film_ID"]  . '.jpg';
                                    break;
                                default:
                                    break;
                            }
                            $rowNum++;
                        }
                    }
                    ?>
                    <h4 class="text-white mb-5">Sizin İçin Seçtiklerimiz</h4>
                    <div class="col-3">
                        <h5 class="text-white"><?php echo $f1["film_adi"] ?></h5>
                        <hr class="text-white">
                        <a href="film.php?film=<?php echo $f1["film_adi"]?>"><img src="<?php echo $fotoYolub1?>" alt=""></a>
                    </div>
                    <div class="col-3">
                        <h5 class="text-white"><?php echo $f2["film_adi"] ?></h5>
                        <hr class="text-white">
                        <a href="film.php?film=<?php echo $f2["film_adi"]?>""><img src="<?php echo $fotoYolub2?>" alt=""></a>
                    </div>
                    <div class="col-3">
                        <h5 class="text-white"><?php echo $f3["film_adi"] ?></h5>
                        <hr class="text-white">
                        <a href="film.php?film=<?php echo $f3["film_adi"]?>""><img src="<?php echo $fotoYolub3?>" alt=""></a>
                    </div>
                    <div class="col-3">
                        <h5 class="text-white"><?php echo $f4["film_adi"] ?></h5>
                        <hr class="text-white">
                        <a href="film.php?film=<?php echo $f4["film_adi"]?>""><img src="<?php echo $fotoYolub4?>" alt=""></a>
                    </div>
                    <div class="col-3 mt-4">
                        <h5 class="text-white"><?php echo $f5["film_adi"] ?></h5>
                        <hr class="text-white">
                        <a href="film.php?film=<?php echo $f5["film_adi"]?>""><img src="<?php echo $fotoYolub5?>" alt=""></a>
                    </div>
                    <div class="col-3 mt-4">
                        <h5 class="text-white"><?php echo $f6["film_adi"] ?></h5>
                        <hr class="text-white">
                        <a href="film.php?film=<?php echo $f6["film_adi"]?>""><img src="<?php echo $fotoYolub6?>" alt=""></a>
                    </div>
                    <div class="col-3 mt-4">
                        <h5 class="text-white"><?php echo $f7["film_adi"] ?></h5>
                        <hr class="text-white">
                        <a href="film.php?film=<?php echo $f7["film_adi"]?>""><img src="<?php echo $fotoYolub7?>" alt=""></a>
                    </div>
                    <div class="col-3 mt-4">
                        <h5 class="text-white"><?php echo $f8["film_adi"] ?></h5>
                        <hr class="text-white">
                        <a href="film.php?film=<?php echo $f8["film_adi"]?>""><img src="<?php echo $fotoYolub8?>" alt=""></a>
                    </div>
                </div>

            </div>
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
