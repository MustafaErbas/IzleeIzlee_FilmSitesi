<?php
include "db.php";

if (isset($_POST['input'])) {
    $input = $_POST['input'];
    $query = "SELECT * FROM filmler WHERE film_adi LIKE '%{$input}%'ORDER BY film_yil DESC";
    $result = mysqli_query($db, $query);

    if (mysqli_num_rows($result) > 0) {
        ?>
        <table class="table" style="width:100%">
            <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
                $adi = $row['film_adi'];
                $yil = $row['film_yil'];
                $yildiz = $row['film_yildizi'];
                $ort = $row['ortpuan'];
                ?>
                <tr style="height: 60px">

                    <td><a class="text-white" href="film.php?film=<?php echo $adi?>"><?php echo $adi; ?></a></td>
                    <td><a class="text-white" href="film.php?film=<?php echo $adi?>"><?php echo $yildiz; ?></a></td>
                    <td><a class="text-white" href="film.php?film=<?php echo $adi?>"><?php echo $yil; ?></a></td>
                    <td style="width: 12%" align="center"><?php echo $ort; ?>/5<i class="fa-solid fa-star" style="color: #e6e916;"></i></td>


                </tr>

                <?php
            }
            ?>
            </tbody>
        </table>
        <?php
    }
}
?>


