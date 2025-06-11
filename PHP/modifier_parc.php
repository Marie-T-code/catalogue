<?php
require_once("db.php");
if ($_POST) {
    if (
        !empty($_POST["nom"])
        && !empty($_POST["geometry"])
    ) {
        $id = filter_var($_POST["id_qgis"], FILTER_VALIDATE_INT); // ou FILTER_SANITIZE_STRING si alphanum
        $nom = htmlspecialchars(strip_tags($_POST["nom"]));
        $address_name = htmlspecialchars(strip_tags($_POST["address_name"]));
        $address_code_postal = htmlspecialchars(strip_tags($_POST["address_code_postal"]));
        $address_locality = htmlspecialchars(strip_tags($_POST["address_locality"]));
        $photo = htmlspecialchars(strip_tags($_POST["photo"]));
        $geometry = $_POST["geometry"];
        // pas de strip_tags pour du GeoJSON =>featurecollection

        $sql = "UPDATE parcs 
                SET nom = :nom, 
                    address_name = :address_name, address_code_postal = :address_code_postal,
                    address_locality = :address_locality, photo = :photo,
                    geom = ST_GeomFromGeoJSON(:geometry)
                WHERE id_qgis = :id_qgis;";

        $query = $pdo->prepare($sql);

        $query->bindValue(":id_qgis", $id, PDO::PARAM_INT); // ou PARAM_STR selon ta BDD
        $query->bindValue(":nom", $nom);
        $query->bindValue(":address_name", $address_name);
        $query->bindValue(":address_code_postal", $address_code_postal);
        $query->bindValue(":address_locality", $address_locality);
        $query->bindValue(":photo", $photo);
        $query->bindValue(":geometry", $geometry, PDO::PARAM_STR);

        $query->execute();

        header("Location: lyon_autrement_admin.php");
    }
}

if (
    isset($_GET["id"])
    && !empty($_GET["id"])
) {
    $id = $_GET["id"];
    $sql = "SELECT *, ST_AsGeoJSON(geom) AS geometry FROM parcs WHERE id_qgis = :id";
    // on reconvertit les données postGIS en geojson 
    $query = $pdo->prepare($sql);
    $query->bindValue(":id", $id, PDO::PARAM_INT);
    $query->execute();
    $parc = $query->fetch();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un parc <?= $parc['id_qgis'] ?> – <?= htmlspecialchars($parc['nom']) ?></title>
    <link rel="stylesheet" href="../CSS/lyon_autrement.css">
    <link rel="stylesheet" href="../CSS/lyon_autrement_admin.css">
    <link rel="stylesheet" href="../CSS/lyon_autrement_responsive.css">
</head>

<body>
    <?php include('header_admin.php'); ?>
    <h1>modifier le parc <?= htmlspecialchars($parc['nom']) ?? 'inconnu' ?></h1>
    <?php if (!empty($parc)): ?>
        <form method="post">

            <label for="nom">Nom</label>
            <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($parc['nom']) ?>" required>

            <label for="address_name">Adresse</label>
            <input type="text" id="address_name" name="address_name" value="<?= htmlspecialchars($parc['address_name']) ?>">

            <label for="address_code_postal">Code postal</label>
            <input type="text" id="address_code_postal" name="address_code_postal" value="<?= htmlspecialchars($parc['address_code_postal']) ?>">

            <label for="address_locality">Commune</label>
            <input type="text" id="address_locality" name="address_locality" value="<?= htmlspecialchars($parc['address_locality']) ?>">

            <label for="photo">URL Photo</label>
            <input type="text" id="photo" name="photo" value="<?= htmlspecialchars($parc['photo']) ?>">

            <label for="geometry">Géométrie (GeoJSON)</label>
            <textarea id="geometry" name="geometry" required><?= htmlspecialchars($parc['geometry']) ?></textarea>
            <small>Exemple : {"type": "Polygon", "coordinates": [[[4.83, 45.76], [4.84, 45.76], [4.84, 45.77], [4.83, 45.77], [4.83, 45.76]]]}</small>

            <input type="hidden" name="id_qgis" value="<?= $parc['id_qgis'] ?>">
            <input aria-label="valider votre modification" type="submit" value="Modifier">
        </form>
        <a href="lyon_autrement_admin.php">Retour à la liste</a>
    <?php else: ?>
        <p>Le parc n’a pas été trouvé.</p>
    <?php endif; ?>
</body>

</html>