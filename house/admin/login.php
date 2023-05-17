<?php
include_once "db.php";

if (empty($conn)){
    $conn=new stdClass();
}
?>
<!DOCTYPE html>
<html>
<link rel="stylesheet" href="../css/admin.css">

<body>
<form method="POST">
    <h2>Prihlásenie</h2>
    <label>Používateľské meno</label>
    <input type="text" name="meno" placeholder="Meno"><br>
    <label>Používateľské heslo</label>
    <input type="password" name="heslo" placeholder="Heslo"><br>
    <input type="submit"  name="sub" value="Prihlásiť sa">
</form>
<a href="../index.php"> Simple house</a>
<?php
if (isset($_POST['sub'])){
    //echo "stlaceny";
    $sql="SELECT * FROM `login` WHERE meno='$_POST[meno]' AND  heslo='$_POST[heslo]'";
    $upload = mysqli_query($conn,$sql);
    if (mysqli_num_rows($upload)==1){
        session_start();
        $_SESSION['nick']=$_POST['meno'];
        header("location: home.php");
    }
    else{
        echo "chyba prihlasenia";
    }
}
?>
</body>
</html>