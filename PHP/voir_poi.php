<?php
if (
    isset($_GET["id"])
    && !empty($_GET["id"])
) {
   require_once("db.php");
   $id = $_GET["id"];
    // $_GET permet de récupérer des données de l'URL

       $sql_voir_poi = "SELECT * FROM poi WHERE id_qgis = :id";

       $query_voir_points = $pdo->prepare($sql_voir_poi);
       $query_voir_points->bindValue(':id', $id, PDO::PARAM_INT); 
       $query_voir_points->execute(); 
       $poi = $query_voir_points->fetch();
       require("disconnect.php"); 
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    if (isset($poi)
    && !empty($poi)):
        // isset vérifie seulement que la variable existe. !empty s’assure en plus qu’elle n’est pas vide — donc préférable ici *
        // print_r($stagiaire);
    ?>
        <!-- si la condition est remplie afficher le HTML ci dessous -->
        <title> Page du POI "<?= $poi['nom'] ?>" </title>
</head>
<body>
    <h1>Page du POI "<?= $poi['nom'] ?>" </h1>
    <p>Nom : <?= $poi['nom'] ?></p>
    <p>Adresse : <?= $poi['address_name'] ?>, <?= $poi['address_locality'] ?>, <?= $poi['address_code_postal'] ?> </p>
    <p>Type : <?= $poi['type'] ?></p>
    <p>Description <?= $poi['description'] ?></p>
<?php if (!empty($poi['photo'])): ?>
    <div class="photo_voir">
        <p>Photo du POI :</p>
        <img src="<?= htmlspecialchars($poi['photo']) ?>" alt="photo du POI <?= htmlspecialchars($poi['nom']) ?>">
    </div>
<?php else: ?>
    <p>Aucune photo disponible.</p>
<?php endif; ?>
    <?php
    else:
?>
    <p>Votre POI n'existe pas.</p>
    <!-- fin de condition, ci dessous, garder le lien de retour -->
<?php
    endif;
?>
<a href="lyon_autrement_admin.php">retour à l'accueil</a>
</body>
</html>