<!DOCTYPE html>
<html>

<?php  include_once "parts/head.php" ?>

<?php
include_once "admin/db.php";

if (empty($conn)){
    $conn=new stdClass();
}

$kategorie = array();
$sql = "SELECT * FROM kategoria";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    $kategorie[] = $row;
}

if (isset($_GET['kategoria'])){
    // získa ID kategórie z URL parametra
    $kategoria_jedlo = htmlspecialchars($_GET["kategoria"], ENT_QUOTES, "UTF-8");
    $sql = "SELECT * FROM `jedlo` WHERE kategoria_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $kategoria_jedlo);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $kategoria_jedlo = 0;
    $sql = "SELECT * FROM jedlo";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
}
$jedla = array();
while ($row = $result->fetch_assoc()) {
    array_push($jedla, $row);
}

?>

<!--

Simple House

https://templatemo.com/tm-539-simple-house

-->
<body>

<div class="container">
    <?php
    include_once "parts/menu.php"
    ?>
    <main>
        <?php
        include_once "parts/header.php"
        ?>
        <div id="id_nav_section" class="tm-paging-links">
            <nav>
                <ul>
                    <?php foreach ($kategorie as $kat) { ?>
                        <li class="tm-paging-item">
                            <?php
                            $isActiveClass = '';
                            if ($kat['id'] == $kategoria_jedlo ){
                                $isActiveClass = ' active ';
                            }
                            ?>
                            <a href="?kategoria=<?php echo $kat['id']; ?>" class="tm-paging-link <?php echo $isActiveClass; ?>"><?php echo $kat['kategoria_nazov']; ?></a>
                        </li>
                    <?php } ?>
                </ul>
            </nav>
        </div>

        <!-- Gallery -->
        <div class="row tm-gallery">
            <!-- gallery page 1 -->
            <div id="tm-gallery-page-pizza" class="tm-gallery-page">


                <?php
                // tu vykreslujem v cykle jednotlive data zo sablony
                foreach ($jedla as $item) {
                    ?>
                    <article class="col-lg-3 col-md-4 col-sm-6 col-12 tm-gallery-item">
                        <figure>
                            <img src="admin/<?php echo $item['jedlo_photo_url']; ?>" alt="Image" class="img-fluid tm-gallery-img" />
                            <figcaption>
                                <h4 class="tm-gallery-title"><?php echo $item['jedlo_nazov']; ?></h4>
                                <p class="tm-gallery-description"><?php echo $item['jedlo_popis']; ?></p>
                                <p class="tm-gallery-price"><?php echo $item['jedlo_cena1']; //echo $item['jedlo_cena2']; ?> </p>
                            </figcaption>
                        </figure>
                    </article>
                <?php } ?>

            </div>



        </div>
        <div class="tm-section tm-container-inner">
            <div class="row">
                <div class="col-md-6">
                    <figure class="tm-description-figure">
                        <img src="img/img-01.jpg" alt="Image" class="img-fluid" />
                    </figure>
                </div>
                <div class="col-md-6">
                    <div class="tm-description-box">
                        <h4 class="tm-gallery-title">Maecenas nulla neque</h4>
                        <p class="tm-mb-45">Redistributing this template as a downloadable ZIP file on any template collection site is strictly prohibited. You will need to <a rel="nofollow" href="https://templatemo.com/contact">talk to us</a> for additional permissions about our templates. Thank you.</p>
                        <a href="about.php" class="tm-btn tm-btn-default tm-right">Read More</a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php
    include_once "parts/footer.php"
    ?>
</div>
<?php
include_once "parts/spolocny_script.php"
?>


</body>
</html>