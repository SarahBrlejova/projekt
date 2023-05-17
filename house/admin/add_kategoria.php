<?php
include_once "db.php";

if (empty($conn)){
    $conn=new stdClass();
}
session_start();
if(!isset( $_SESSION['nick'])){
    header("location: login.php");
}

if (isset($_POST['add_kategoria'])){
    $kategoria_nazov = $_POST['kategoria_nazov'];
    $kategoria_id = $_POST['id'];
    if(empty($kategoria_nazov) || empty($kategoria_id) ){
        echo "naplň polia";
    }else {
        $insert = "INSERT INTO kategoria (id,kategoria_nazov) VALUES ('$kategoria_id','$kategoria_nazov');";
        $upload = mysqli_query($conn,$insert);
        if ($upload){
            echo "Nová kategória bola vytvorená";
        }else{
            echo "Nepodarilo sa vytvoriť novú kategóriu";
        }
    }
}

if (isset($_GET['delete'])){
    $id = $_GET['delete'];
    $delete="DELETE FROM kategoria WHERE id=$id";
    $upload = mysqli_query($conn,$delete);
    if ($upload) {
        echo "Kategoria s ID $id bola úspešne odstránená.";
    } else {
        echo "Chyba pri odstraňovaní kategórie: ";
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
                <h3> Pridaj novu kategoriu</h3>
                <input type="text" placeholder="zadaj nazov kategorie" name="kategoria_nazov" class="box">

                <h3> zadaj cislo kategorie</h3>
                <input type="number" placeholder="zadaj cislo kategorie" name="id" class="box">
                <br><br>
                <input type="submit"  name="add_kategoria" value="pridaj">

            </form>
        </div>
    <br><br>

    <table>
        <tr>
            <th> ID Kategorie</th>
            <th> Nazov Kategorie</th>
            <th> Procedura </th>
        </tr>
        <?php
        $select =mysqli_query($conn,"SELECT * FROM kategoria");
        while ($row=mysqli_fetch_assoc($select)){ ?>
            <tr>
                <td> <?php echo $row['id']; ?></td>
                <td> <?php echo $row['kategoria_nazov']; ?></td>
                <td> <a href="update_kategoria.php?edit=<?php echo $row['id'];?>" > Edit /</a>
                    <a href="add_kategoria.php?delete=<?php echo $row['id'];?>" > Delete</a>
                </td>
            </tr>
        <?php }; ?>
    </table>


</main>
<script src="js/jquery.min.js"></script>
<script src="js/parallax.min.js"></script>
</body>
</html>