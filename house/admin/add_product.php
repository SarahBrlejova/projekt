<?php
include_once "db.php";

if (empty($conn)){
    $conn=new stdClass();
}

session_start();
if(!isset( $_SESSION['nick'])){
    header("location: login.php");
}

if (isset($_POST['add_product'])){
    $jedlo_nazov = $_POST['nazov'];
    $jedlo_popis = $_POST['popis'];
    $kategoria_id = $_POST['kategoria_id'];
   // echo $kategoria_id;
    $jedlo_cena1 = $_POST['jedlo_cena1'];
    //$_FILES['file']['tmp_name'] - The temporary filename of the file in which the uploaded file was stored on the server.
    //jedlo_photo_url - info o obrazku, tmp_name obsahuje docasnu cestu, povinny nazov
    $jedlo_photo_tmp_name  = $_FILES['jedlo_photo_url']['tmp_name'];
    //$_FILES['file']['name'] - The original name of the file to be uploaded
    //basename mi dá názov súboru aj s príponou, odstráni jeho pôvodnú cestu, name je povinné
    $jedlo_photo_folder = "uploaded_img/".basename($_FILES['jedlo_photo_url']['name']);

    if(empty($jedlo_nazov) || empty($kategoria_id)  ){
        echo "Zadaj názov produktu a zvol kategoriu ";
    }else {
        if (!is_dir('uploaded_img')) {
            mkdir('uploaded_img');
        }
        //z dočas na ciel
        if (move_uploaded_file($jedlo_photo_tmp_name , $jedlo_photo_folder)) {
            $insert = "INSERT INTO jedlo(jedlo_nazov,jedlo_popis,kategoria_id,jedlo_cena1,jedlo_photo_url) VALUES ('$jedlo_nazov','$jedlo_popis','$kategoria_id','$jedlo_cena1','$jedlo_photo_folder')";
            $upload = mysqli_query($conn,$insert);
            if ($upload){
                echo "Nový produkt nahraný";
            }else{
                echo "Nepodarilo sa nahrať nový produkt";
            }
        } else {
            echo "Nepodarilo sa nahrať obrázok";
        }
    }
}

if (isset($_GET['delete'])){
    $id = $_GET['delete'];
    $delete = mysqli_query($conn, "DELETE FROM jedlo WHERE id=$id");
    if ($delete) {
        echo "Produkt s ID $id bol úspešne odstránený.";
    } else {
        echo "Chyba pri odstraňovaní produktu: " ;
    }
}
?>


<!DOCTYPE html>
<html>

<link rel="stylesheet" href="../css/admin.css">
  <body>
    <main>
        <a href="home.php"> <- Admin domov</a>
        <h1>Admin Strańka produktov</h1>

<div>
    <div>
        <form action="<?php $_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
            <h3> Pridaj nový produkt</h3>
            <input type="text" placeholder="zadaj nazov produktu" name="nazov">
            <br> <br> <br>
            <input type="text" placeholder="zadaj popis produktu" name="popis" >
            <br> <br> <br>
            <label for="kategoria">Kategória:</label>
            <select id="kategoria" name="kategoria" onchange="document.getElementById('kategoria_id').value=this.value">
                <option value="" disabled selected>Vyber Kategoriu</option>
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


    <div>
        <table>
            <thead>
            <tr>
                <th> Fotka jedla</th>
                <th> Názov jedla</th>
                <th> Popis jedla</th>
                <th> Cena jedla</th>
                <th> Kategória jedla</th>
                <th> Akcia </th>
            </tr>
            </thead>
            <?php
            $select = mysqli_query($conn, "SELECT j.*, k.kategoria_nazov FROM jedlo j JOIN kategoria k ON j.kategoria_id = k.id");
            while ($row=mysqli_fetch_assoc($select)){
                ?>
            <tr>
                <td> <img src="<?php echo $row['jedlo_photo_url'];?>" height="100"></td>
                <td> <?php echo $row['jedlo_nazov']; ?></td>
                <td> <?php echo $row['jedlo_popis']; ?></td>
                <td> <?php echo $row['jedlo_cena1']; ?></td>
                <td><?php echo $row['kategoria_nazov']; ?></td></td>
                <td> <a href="update_product.php?edit=<?php echo $row['id'];?>" > Edit / </a>
                    <a href="add_product.php?delete=<?php echo $row['id'];?>" > Delete</a>
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