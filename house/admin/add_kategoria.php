<?php

include 'admin/config.php';
$servername = "localhost";

$username = "root";

$password = "root";


$dbname = "simple_house";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {

    die("Napojenie zlyhalo: " . $conn->connect_error);

}
if (isset($_POST['add_kategoria'])){
    $kategoria_nazov = $_POST['kategoria_nazov'];
    $kategoria_id = $_POST['id'];
    if(empty($kategoria_nazov) || empty($kategoria_id) ){
        $message[]='napln pole';
    }else {
        $insert = "INSERT INTO kategoria (id,kategoria_nazov) VALUES ('$kategoria_id','$kategoria_nazov');";
        $upload = mysqli_query($conn,$insert);
        if ($upload){
            $message[] ='Nová kategória bola vytvorená';
        }else{
            $message[] ='Nepodarilo sa vytvoriť novú kategóriu';
        }
    }
}

if (isset($_GET['delete'])){
    $id = $_GET['delete'];
    $delete = mysqli_query($conn, "DELETE FROM kategoria WHERE id=$id");
    if ($delete) {
        echo "Kategoria s ID $id bola úspešne odstránená.";
    } else {
        echo "Chyba pri odstraňovaní kategórie: " . mysqli_error($conn);
    }
    header('location:add_kategoria.php');
    exit;
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
            <form action="<?php $_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
                <h3> Pridaj novu kategoriu</h3>
                <input type="text" placeholder="zadaj nazov kategorie" name="kategoria_nazov" class="box">

                <h3> zadaj cislo kategorie</h3>
                <input type="number" placeholder="zadaj cislo kategorie" name="id" class="box">
                <br><br>
                <input type="submit" class="btn" name="add_kategoria" value="pridaj">
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
                <td> <a href="update_kategoria.php?edit=<?php echo $row['id'];?>" > Edit</a>
                    <a href="add_kategoria.php?delete=<?php echo $row['id'];?>" > Delete</a> <!--toto ?delete si nahravam hore do if  -->
                </td>
            </tr>
        <?php }; ?>
    </table>


</main>
<script src="js/jquery.min.js"></script>
<script src="js/parallax.min.js"></script>
</body>
</html>