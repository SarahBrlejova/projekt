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

?>
<!DOCTYPE html>
<html>
<link rel="stylesheet" href="../css/admin.css">
<body>
<main>
    <div>
        <form  method="post" >
            <label>Staré používateľské meno</label>
            <input type="text" name="stare" placeholder="Staré meno"><br>
            <label>Nové používateľské meno</label>
            <input type="text" name="nove" placeholder="Nové meno"><br>
            <br><br>
            <input type="submit"  name="sub" value="zmeň meno">
            <br>
            <a href="add_admin.php"> Naspäť</a> <br>
            <a href="home.php"> Admin domov</a>
        </form>
    </div>
    <?php
    if (isset($_POST['sub'])){
        //echo "stlaceny";
        $nove=$_POST['nove'];
        $sql="SELECT * FROM `login` WHERE meno='$_POST[stare]'";
        $upload = mysqli_query($conn,$sql);
        if (mysqli_num_rows($upload)==1){
            $update = "UPDATE `login` SET `meno` = '$nove' WHERE `login`.`id` = '$id'";
            $upload = mysqli_query($conn,$update);
            echo "meno zmenené";
        }
        else{
            echo "chyba mena";
        }
    }
    ?>
</main>
<script src="js/jquery.min.js"></script>
<script src="js/parallax.min.js"></script>
</body>
</html>