<?php
session_start();
if(!isset( $_SESSION['nick'])){
    header("location: login.php");
}
?>
<!DOCTYPE html>
<html>
<link rel="stylesheet" href="../css/admin.css">
<body>

<h1>Admin home</h1>
<ul class="home">
    <li> <a href="add_product.php" > Editovanie - Jedlo </a> </li>
    <li> <a href="add_kategoria.php" >Editovanie - Kategória jedla  </a> </li>
</ul>
 <h3> prihlaseny - <?php echo $_SESSION['nick']?></h3>
<br>
<li> <a href="add_admin.php" > Editovanie - Admin </a> </li>
<br>
<form method="post">
    <input type="submit"  name="out" value="Odhlásiť sa">
</form>

<?php
if(isset($_POST['out'])){
    session_destroy();
    header("location: login.php");
}
?>
</body>
</html>