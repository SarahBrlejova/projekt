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
if (isset($_POST['add_product'])){
    $jedlo_nazov = $_POST['nazov'];
    $jedlo_popis = $_POST['popis'];
    $kategoria_id = $_POST['kategoria_id'];
    echo $kategoria_id;
    $jedlo_cena1 = $_POST['jedlo_cena1'];
    $jedlo_photo_tmp_name = $_FILES['jedlo_photo_url']['tmp_name'];
    $jedlo_photo_folder = "uploaded_img/".basename($_FILES['jedlo_photo_url']['name']);

    if(empty($jedlo_nazov) || empty($jedlo_cena1)  ){
        $message[]='napln vsetky';
    }else {
        if (!is_dir('uploaded_img')) {
            mkdir('uploaded_img');
        }

        if (move_uploaded_file($jedlo_photo_tmp_name, $jedlo_photo_folder)) {
            $insert = "INSERT INTO jedlo(jedlo_nazov,jedlo_popis,kategoria_id,jedlo_cena1,jedlo_photo_url) VALUES ('$jedlo_nazov','$jedlo_popis','$kategoria_id','$jedlo_cena1','$jedlo_photo_folder')";
            $upload = mysqli_query($conn,$insert);
            if ($upload){
                $message[] ='Nový produkt nahraný';
            }else{
                $message[] ='nepodarilo sa';
            }
        } else {
            $message[] = 'Nepodarilo sa nahrať obrázok.';
        }
    }
}
if (isset($_GET['delete'])){
    $id = $_GET['delete'];
    $delete = mysqli_query($conn, "DELETE FROM jedlo WHERE id=$id");
    if ($delete) {
        echo "Produkt s ID $id bol úspešne odstránený.";
    } else {
        echo "Chyba pri odstraňovaní produktu: " . mysqli_error($conn);
    }
    header('location:add_product.php');
    exit;
}






?>


<!DOCTYPE html>
<html>

  <body>
    <main>
        <h1>Admin Strańka produktov</h1>

        <?php

        if(isset($message)){
            foreach ($message as $message){
                echo '<span class="message">'.$message.'</span>';
            }
        }

        ?>
<div>
    <div>
        <form action="<?php $_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
            <h3> add new product</h3>
            <input type="text" placeholder="zadaj nazov produktu" name="nazov">
            <br> <br> <br>
            <input type="text" placeholder="zadaj popis produktu" name="popis" >
            <br> <br> <br>
            <label for="kategoria">Kategória:</label>
            <select id="kategoria" name="kategoria" onchange="document.getElementById('kategoria_id').value=this.value">
                <option value="" disabled selected>Vyber Kategoriu</option> //toto som vytvarala preto lebo mi blbo aktualizovanie databazy

                <?php
                $sql = "SELECT id, kategoria_nazov FROM kategoria";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<option value="' . $row['id'] . '">' . $row['kategoria_nazov'] . '</option>';
                }
                ?>
            </select>
            <input type="hidden" id="kategoria_id" name="kategoria_id">
            <br> <br> <br>
            <h3> Zadaj cenu</h3>
            <input type="number" placeholder="zadaj cenu produktu" name="jedlo_cena1" >
            <br> <br> <br>
            <h3> Nahraj fotku </h3>
            <input type="file" accept="image/png, image/jpeg, image/jpg" name="jedlo_photo_url" >
            <br> <br> <br>
            <input type="submit"  name="add_product" value="pridaj">
        </form>
</div>
    <?php
    $select = mysqli_query($conn, "SELECT j.*, k.kategoria_nazov FROM jedlo j JOIN kategoria k ON j.kategoria_id = k.id");
    ?>

    <div>
        <table>
            <thead>
            <tr>
                <td> produkt fotka</td>
                <td> produkt meno</td>
                <td> produkt popis</td>
                <td> produkt cena</td>
                <td> produkt kategoria</td>
                <th colspan="2 "> procedura </th>
            </tr>
            </thead>
            <?php
            while ($row=mysqli_fetch_assoc($select)){
                $kat =mysqli_query($conn,"SELECT * FROM kategoria");
                ?>
            <tr>
                <td> <img src="<?php echo $row['jedlo_photo_url'];?>" height="100"></td>
                <td> <?php echo $row['jedlo_nazov']; ?></td>
                <td> <?php echo $row['jedlo_popis']; ?></td>
                <td> <?php echo $row['jedlo_cena1']; ?></td>
                <td><?php echo $row['kategoria_nazov']; ?></td></td>
                <td> <a href="update_product.php?edit=<?php echo $row['id'];?>" > Edit</a>
                    <a href="add_product.php?delete=<?php echo $row['id'];?>" > Delete</a> <!--toto ?delete si nahravam hore do if  -->
                </td>
            </tr>
<?php }; ?>
        </table>
    </div>
</div>
    </main>
    <script src="js/jquery.min.js"></script>
    <script src="js/parallax.min.js"></script>
  </body>
</html>