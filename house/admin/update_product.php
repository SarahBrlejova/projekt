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

if (isset($_POST['update_product'])){
    $jedlo_nazov = $_POST['nazov'];
    $jedlo_popis = $_POST['popis'];
    $jedlo_cena1 = $_POST['jedlo_cena1'];
    $kategoria_id = $_POST['kategoria_id'];
    $jedlo_photo_tmp_name = $_FILES['jedlo_photo_url']['tmp_name'];
    $jedlo_photo_folder = "uploaded_img/".basename($_FILES['jedlo_photo_url']['name']);
    if(empty($jedlo_nazov) || empty($kategoria_id)  ){
        echo "Zadaj názov produktu a zvol kategoriu ";
    } else {
        if (!is_dir('uploaded_img')) {
            mkdir('uploaded_img');
        }
        // Ak bolo vyplnené pole input file a nahral sa súbor
        if(!empty($jedlo_photo_tmp_name)){
            $jedlo_photo_folder = "uploaded_img/".basename($_FILES['jedlo_photo_url']['name']);
            if (move_uploaded_file($jedlo_photo_tmp_name, $jedlo_photo_folder)) {
                $update = "UPDATE jedlo SET kategoria_id='$kategoria_id', jedlo_nazov='$jedlo_nazov', jedlo_popis='$jedlo_popis', jedlo_cena1='$jedlo_cena1', jedlo_photo_url='$jedlo_photo_folder'  WHERE id='$id'";
                $upload = mysqli_query($conn,$update);
                if ($upload){
                    echo "Produkt bol aktualizovaný";
                } else {
                    echo "Aktualizácia sa nepodarila";
                }
            } else {
               echo "Nepodarilo sa nahrať obrázok";
            }
        } else {
            $update = "UPDATE jedlo SET kategoria_id='$kategoria_id', jedlo_nazov='$jedlo_nazov', jedlo_popis='$jedlo_popis', jedlo_cena1='$jedlo_cena1' WHERE id='$id'";
            $upload = mysqli_query($conn,$update);
            if ($upload){
                echo "Produkt bol aktualizovaný";
            } else {
                echo "Aktualizácia sa nepodarila";
            }
        }
    }

}

?>
<!doctype html>
<html >
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Update stránka</title>
</head>
<body>
<div>
    <?php
    $select = mysqli_query($conn, "SELECT * FROM jedlo WHERE id='$id'");
    if (mysqli_num_rows($select) == 0) {
        echo "Záznam s id = $id neexistuje";
    } else {
        $row = mysqli_fetch_assoc($select);
        ?>
        <form action="<?php $_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
            <h3> edituj produkt</h3>
            <input type="text"  value="<?php echo $row['jedlo_nazov'];?>" name="nazov">
            <br> <br> <br>
            <input type="text"  value="<?php echo $row['jedlo_popis'];?>" name="popis" >
            <br> <br> <br>
            <h3> Zadaj cenu</h3>
            <input type="number"name="jedlo_cena1" value="<?php echo $row['jedlo_cena1'];?>" >
            <br> <br> <br>
            <h3> Nahraj fotku </h3>
            <input type="file" accept="image/png, image/jpeg, image/jpg" name="jedlo_photo_url" >
            <br><br>
            <img src="<?php echo $row['jedlo_photo_url']; ?>" alt="Aktuálny obrázok">
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
            <br> <br>
            <input type="submit"  name="update_product" value="edituj">
            <a href="add_product.php"> Naspäť</a>
            <a href="home.php"> Admin domov</a>
        </form>
        <?php
    }
    ?>

</div>

</body>
</html>
