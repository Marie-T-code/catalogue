<?php 
if (
    isset($_GET["id"])
    && !empty($_GET["id"])
) {
   require_once("db.php");
   $id = $_GET["id"];
    // $_GET permet de récupérer des données de l'URL

       $sql_voir_parc = "SELECT * FROM parcs WHERE id_qgis = :id";

       $query_voir_parcs = $pdo->prepare($sql_voir_parc);
       $query_voir_parcs->bindValue(':id', $id, PDO::PARAM_INT); 
       $query_voir_parcs->execute(); 
       $parc = $query_voir_parcs->fetch();
       require("disconnect.php"); 
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    if (isset($parc)
    && !empty($parc)):
        // isset vérifie seulement que la variable existe. !empty s’assure en plus qu’elle n’est pas vide — donc préférable ici *
    ?>
        <title> Page du parc "<?= $parc['nom'] ?>" </title>
</head>
<body>
    <h1>Page du parc "<?= $parc['nom'] ?>" </h1>
    <p>Nom : <?= $parc['nom'] ?></p>
    <p>Adresse : <?= $parc['address_name'] ?>, <?= $parc['address_locality'] ?>, <?= $parc['address_code_postal'] ?> </p>
    <?php if (!empty($parc['photo'])): ?>
    <div class="photo_voir">
        <p>Photo du POI :</p>
        <img src="<?= htmlspecialchars($parc['photo']) ?>" alt="photo du parc <?= htmlspecialchars($parc['nom']) ?>">
    </div>
<?php else: ?>
    <p>Aucune photo disponible.</p>
<?php endif; ?>
    <?php
    else:
?>
    <p>Votre parc n'existe pas.</p>
<?php
    endif;
?>
<a href="lyon_autrement_admin.php">retour à l'accueil</a>
</body>
</html>
