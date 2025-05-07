<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kayıt Sayfası Sayfası</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="film.css">
    <style>
        a:hover {
            text-decoration: none;
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

<div class="container mt-3">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4>Kayıt Formu</h4>
                </div>
                <div class="card-body">
                    <form method="post">
                        <div class="form-group">
                            <label for="username">Kullanıcı Adı:</label>
                            <input type="text" class="form-control" name="username" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Şifre:</label>
                            <input type="password" class="form-control" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).{8,}$" title="En az bir sayı, bir küçük harf ve bir büyük harf içermelidir. Boşluk içeremez." name="password" required>
                            <!-- işaret istenildiğinde böyle (?=.*[!@$%&*]) -->
                            <!-- şifrede boşluk koymayı engeller (?!.*\s) -->
                            <small>Lütfen en az 8 karakter kullanınız!!</small>
                        </div>
                        <div class="form-group">
                            <label for="username">Ad:</label>
                            <input type="text" class="form-control" name="ad" required>
                        </div>
                        <div class="form-group">
                            <label for="username">Soyad:</label>
                            <input type="text" class="form-control" name="soyad" required>
                        </div>
                        <div class="form-group">
                            <label for="username">Mail:</label>
                            <input type="email" class="form-control" name="mail" required>
                        </div>
                        <div class="form-group">
                            <label for="username">Telefon Numarası:</label>
                            <input type="number" class="form-control" name="numara" required>
                        </div>
                        <div class="form-group">
                            <label for="username">Adres:</label>
                            <input type="text" class="form-control" name="adres" required>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <button type="submit" class="btn btn-primary ">Kayıt Ol</button>
                            <a href="login.php"> <button type="button" class="btn btn-success btn-md mr-4">Login Sayfasına Dön</button> </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="container-lg " align="center">
    <?php
    include "db.php";
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $ad       = $_POST['ad'];
        $soyad    = $_POST['soyad'];
        $mail     = $_POST['mail'];
        $numara   = $_POST['numara'];
        $adres    = $_POST['adres'];
        $hashpassword = md5(sha1($password));
        $hashuser = md5(sha1($username));


        if (!empty($username) && !empty($password) && !empty($mail)) {
            if (!empty($username)){
                $query = "SELECT * FROM usertable WHERE username = '$username'";
                $stmt = $db->prepare($query);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0){
                    echo "<script>alert('Bu Kullanıcı Adı Kullanılıyor.');</script>";
                    $stmt->close();
                    $db->close();
                    exit;
                }
            }
            if(!empty($mail)){
                $query = "SELECT * FROM usertable WHERE mail = '$mail'";
                $stmt = $db->prepare($query);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0){
                    echo "<script>alert('Bu E-Mail Kullanılıyor.');</script>";
                    $stmt->close();
                    $db->close();
                    exit;
                }
            }
            $stmt = $db->prepare("INSERT INTO usertable (username,password,hashusername,hashpassword,ad,soyad,mail,numara,adres) VALUES (?,?,?,?,?,?,?,?,?)");
            $stmt->bind_param("sssssssis", $username, $password, $hashuser, $hashpassword, $ad, $soyad, $mail, $numara, $adres);

            if ($stmt->execute()) {
                echo "<h4 class='text-success'>Kayıt Başarılı Bir Şekilde Oluşturuldu.</h4>";
            } else {
                echo "<h4 class='text-danger'>Kayıt Sırasında Hata Oluştu!! </h4>" . $stmt->error;
            }
            $stmt->close();
            $db->close();
        }
    }




    ?>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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
