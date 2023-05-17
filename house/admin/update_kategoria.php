<?php
include_once "db.php";

if (empty($conn)){
    $conn=new stdClass();
}
session_start();
if(!isset( $_SESSION['nick'])){
    header("location: login.php");
}
$id =$_GET['edit'];
//echo $id;
if (isset($_POST['update_category'])){
    $kategoria_nazov = $_POST['kategoria_nazov'];
    $kategoria_id = $_POST['id'];
    if(empty($kategoria_nazov) || empty($kategoria_id) ){
        $message[]='napln polia';
    }else {
        $select = mysqli_query($conn, "SELECT * FROM kategoria WHERE id='$id'");
        $row = mysqli_fetch_assoc($select);
        $stare_id = $row['id'];  // nacitam si stare id
        // echo $old_category_id;
        $update = "UPDATE kategoria SET id='$kategoria_id',kategoria_nazov='$kategoria_nazov' WHERE id='$id'";
        $upload = mysqli_query($conn,$update);
        // Aktualizácia produktov
        $update_produkty = "UPDATE jedlo SET kategoria_id='$kategoria_id' WHERE kategoria_id='$stare_id'";
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
<link rel="stylesheet" href="../css/admin.css">
<body>
<main>
    <?php

    if(isset($message)){
        foreach ($message as $message){
            echo '<span class="message">'.$message.'</span>';
        }
    }
    ?>
    <div>
        <?php
        $select = mysqli_query($conn, "SELECT * FROM kategoria WHERE id='$id'");
        $row = mysqli_fetch_assoc($select);
        ?>
        <form method="post" >
            <h3> Edituj kategoriu</h3>
            <input type="text"  name="kategoria_nazov" value="<?php echo $row['kategoria_nazov'];?>">
            <h3> zadaj cislo kategorie</h3>
            <input type="number" name="id" value="<?php echo $row['id'];?>">
            <br><br>
            <input type="submit"  name="update_category" value="edituj kategóriu">
            <br>
            <a href="add_kategoria.php"> Naspäť</a> <br>
            <a href="home.php"> Admin domov</a>
        </form>
    </div>
</main>
<script src="js/jquery.min.js"></script>
<script src="js/parallax.min.js"></script>
</body>
</html>