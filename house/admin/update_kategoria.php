<?php
//nefunguje mi include 'admin/config.php' a premennu $conn to stale vidi ako keby neexistovala
include 'admin/config.php';
$servername = "localhost";

$username = "root";

$password = "root";


$dbname = "simple_house";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {

    die("Napojenie zlyhalo: " . $conn->connect_error);

}
$id =$_GET['edit'];
//echo $id;

if (isset($_POST['update_category'])){
    $kategoria_nazov = $_POST['kategoria_nazov'];
    $kategoria_id = $_POST['id'];
    if(empty($kategoria_nazov) || empty($kategoria_id) ){
        $message[]='napln polia';
    }else {

        // nacitam si stare id
        $select = mysqli_query($conn, "SELECT * FROM kategoria WHERE id='$id'");
        $row = mysqli_fetch_assoc($select);
        $old_category_id = $row['id'];
        // echo $old_category_id;
        // Aktualizácia kategórie
        $update = "UPDATE kategoria SET id='$kategoria_id',kategoria_nazov='$kategoria_nazov' WHERE id='$id'";
        $upload = mysqli_query($conn,$update);

        // Aktualizácia produktov
        $update_produkty = "UPDATE jedlo SET kategoria_id='$kategoria_id' WHERE kategoria_id='$old_category_id'";
        mysqli_query($conn, $update_produkty);
        if ($upload){
            $message[] ='Kategória bola editovaná';

        }else{
            $message[] ='Nepodarilo sa editovať  kategóriu';
        }
    }
}

?>


<!DOCTYPE html>
<html>

<body>
<main>


    <?php
    //echo '<span class="message">'.$message.'</span>';
    if(isset($message)){
        foreach ($message as $message){
            echo '<span class="message">'.$message.'</span>';
        }
    }
    ?>

    <div>
        <?php
        // Vyber konkrétneho záznamu s daným id
        $select = mysqli_query($conn, "SELECT * FROM kategoria WHERE id='$id'");
        $row = mysqli_fetch_assoc($select);

        ?>
        <form action="<?php $_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
            <h3> Edituj kategoriu</h3>
            <input type="text" placeholder="zadaj nazov kategorie" name="kategoria_nazov" value="<?php echo $row['kategoria_nazov'];?>">

            <h3> zadaj cislo kategorie</h3>
            <input type="number" placeholder="zadaj cislo kategorie" name="id" value="<?php echo $row['id'];?>">
            <br><br>
            <input type="submit"  name="update_category" value="edituj kategóriu">
            <a href="add_kategoria.php"> Naspäť</a>

        </form>
        <?php

        ?>
    </div>





</main>
<script src="js/jquery.min.js"></script>
<script src="js/parallax.min.js"></script>
</body>
</html>