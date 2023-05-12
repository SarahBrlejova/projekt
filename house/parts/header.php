<?php
 $stranka = basename($_SERVER['SCRIPT_NAME']);
?>
<header class="row tm-welcome-section">
    <h2 class="col-12 text-center tm-section-title">

        <?php  if ($stranka == 'index.php' ) {?> Vitajte v Simple House  <?php }
        elseif ($stranka == 'contact.php' ) { ?> Kontakt  <?php }
        elseif ($stranka == 'about.php' ) { ?> Niečo málo o nás <?php } ?>
    </h2>
    <p class="col-12 text-center">
    <?php  if ($stranka == 'index.php' ) {?> Vitajte na naších stránkach Simple House. Reštaurácia Simple House je spojením škandinávskeho dizajnu a kulinárskeho umenia. Príjemná atmosféra a prostredie predurčujú k tomu, ako si najlepšie vychutnať skvelé jedlo s vašimi rodinami či obchodnými partnermi. <?php }
    elseif ($stranka == 'contact.php' ) { ?> me tu pre vás. Preto nás neváhajte osloviť s akoukoľvek požiadavkou alebo otázkou. Radi vás našou reštauráciou prevedieme, zoznámime vás s našim menu, poradíme čo si vybrať.  <?php }
    elseif ($stranka == 'about.php' ) { ?> Naša reštaurácia je kolektív úžasných ľudí, sme profesionáli, ktorí milujú svoje remeslo. <br>
        Láska k remeslu a odborná zručnosť sú vstupným požiadavkom na každého nášho zamestnanca. A okrem toho samorejme zdvorilý prístup a otvorenosť.<?php } ?>
    </p>
</header>