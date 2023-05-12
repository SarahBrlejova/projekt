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

$id =$_GET['edit'];
//echo $id;
if (isset($_POST['update_product'])){
    $jedlo_nazov = $_POST['nazov'];
    $jedlo_popis = $_POST['popis'];
    $jedlo_cena1 = $_POST['jedlo_cena1'];
    $kategoria_id = $_POST['kategoria_id'];
    $jedlo_photo_tmp_name = $_FILES['jedlo_photo_url']['tmp_name'];
    $jedlo_photo_folder = "uploaded_img/".basename($_FILES['jedlo_photo_url']['name']);
    if(empty($jedlo_nazov) || empty($jedlo_cena1)){
        $message[] = 'Vyplňte všetky polia.';
    } else {
        if (!is_dir('uploaded_img')) {
            mkdir('uploaded_img');
        }
        // Ak bolo vyplnené pole input file a nahral sa súbor
        if(!empty($jedlo_photo_tmp_name)){
            $jedlo_photo_folder = "uploaded_img/".basename($_FILES['jedlo_photo_url']['name']);
            echo $jedlo_photo_tmp_name;
            if (move_uploaded_file($jedlo_photo_tmp_name, $jedlo_photo_folder)) {
                // Aktualizácia databázy s novým obrázkom
                $update = "UPDATE jedlo SET kategoria_id='$kategoria_id', jedlo_nazov='$jedlo_nazov', jedlo_popis='$jedlo_popis', jedlo_cena1='$jedlo_cena1', jedlo_photo_url='$jedlo_photo_folder'  WHERE id='$id'";
                $upload = mysqli_query($conn,$update);
                if ($upload){
                    $message[] ='Produkt bol aktualizovaný.';
                } else {
                    $message[] ='Aktualizácia sa nepodarila.';
                }
            } else {
                $message[] = 'Nepodarilo sa nahrať obrázok.';
            }
        } else {
            // Aktualizácia databázy bez nového obrázku
            $update = "UPDATE jedlo SET kategoria_id='$kategoria_id', jedlo_nazov='$jedlo_nazov', jedlo_popis='$jedlo_popis', jedlo_cena1='$jedlo_cena1' WHERE id='$id'";
            $upload = mysqli_query($conn,$update);
            if ($upload){
                $message[] ='Produkt bol aktualizovaný.';
            } else {
                $message[] ='Aktualizácia sa nepodarila.';
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
<?php

if(isset($message)){
    foreach ($message as $message){
        echo '<span class="message">'.$message.'</span>';
    }
}
?>

<div>
    <?php
    // Vyber konkrétneho záznamu s daným id
    $select = mysqli_query($conn, "SELECT * FROM jedlo WHERE id='$id'");

    // Ak záznam neexistuje, vypíš chybovú správu
    if (mysqli_num_rows($select) == 0) {
        echo "Záznam s id = $id neexistuje";
    } else {
        // Vypíš formulár na editáciu konkrétneho záznamu
        $row = mysqli_fetch_assoc($select);
        ?>
        <form action="<?php $_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
            <h3> edituj produkt</h3>
            <input type="text" placeholder="zadaj nazov produktu" value="<?php echo $row['jedlo_nazov'];?>" name="nazov">
            <br> <br> <br>
            <input type="text" placeholder="zadaj popis produktu" value="<?php echo $row['jedlo_popis'];?>" name="popis" >
            <br> <br> <br>
            <h3> Zadaj cenu</h3>
            <input type="number" placeholder="zadaj cenu produktu" name="jedlo_cena1" value="<?php echo $row['jedlo_cena1'];?>" >
            <br> <br> <br>
            <h3> Nahraj fotku </h3>
            <input type="file" accept="image/png, image/jpeg, image/jpg" name="jedlo_photo_url" >
            <br><br>
            <img src="<?php echo $row['jedlo_photo_url']; ?>" alt="Aktuálny obrázok">

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
            <br> <br>
            <input type="submit"  name="update_product" value="edituj">
            <a href="add_product.php"> Naspäť</a>
        </form>
        <?php
    }
    ?>

</div>

</body>
</html>
