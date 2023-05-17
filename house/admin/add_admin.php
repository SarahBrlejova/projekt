<?php
include_once "db.php";

if (empty($conn)){
    $conn=new stdClass();
}
session_start();
if(!isset( $_SESSION['nick'])){
    header("location: login.php");
}

if (isset($_POST['add_admin'])){
    $nick = $_POST['nick'];
    $heslo = $_POST['heslo'];
    if(empty($nick) || empty($heslo) ){
        echo "Vyplň všetky polia";
    }else {
        $insert = "INSERT INTO login (meno,heslo) VALUES ('$nick','$heslo');";
        $upload = mysqli_query($conn,$insert);
        if ($upload){
            echo "Nový používateľ bol vytvorený";
        }else{
            echo "Nepodarilo sa vytvoriť nového používateľa";
        }
    }
}

if (isset($_GET['delete'])){
    $id = $_GET['delete'];
    $delete="DELETE FROM login WHERE id=$id";
    $upload = mysqli_query($conn,$delete);
    if ($upload) {
        echo "Používateľ s ID $id bol úspešne odstránený.";
    } else {
        echo "Chyba pri odstraňovaní používateľa: ";
    }
}
?>


<!DOCTYPE html>
<html>
<link rel="stylesheet" href="../css/admin.css">
<body >
<main>

    <a href="home.php" class="domov" > <- Admin domov</a>
    <div>
        <form method="post" >
            <h3> Pridaj nového Admina </h3>
            <input type="text" placeholder="Používateľské meno" name="nick" >
            <h3> zadaj heslo </h3>
            <input type="password" placeholder="zadaj heslo " name="heslo" >
            <br><br>
            <input type="submit"  name="add_admin" value="pridaj">
        </form>
    </div>
    <br><br>

    <table>
        <tr>
            <th> Nick</th>
            <th> Zmazanie používatela </th>
            <th> Zmena mena používateľa </th>
            <th> Zmena hesla používateľa </th>
        </tr>
        <?php
        $select =mysqli_query($conn,"SELECT * FROM login");
        while ($row=mysqli_fetch_assoc($select)){ ?>
            <tr>
                <td> <?php echo $row['meno']; ?></td>
                <td>
                    <a href="add_admin.php?delete=<?php echo $row['id'];?>" > Zmazať </a> <!--toto ?delete si nahravam hore do if  -->
                </td>
                <td>
                    <a href="update_admin_meno.php?edit=<?php echo $row['id'];?>" > Zmena mena</a>
                </td>
                <td>
                    <a href="update_admin_heslo.php?edit=<?php echo $row['id'];?>" > Zmena hesla</a>
                </td>
            </tr>
        <?php }; ?>
    </table>


</main>
<script src="js/jquery.min.js"></script>
<script src="js/parallax.min.js"></script>
</body>
</html>