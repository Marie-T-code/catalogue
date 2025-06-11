<?php

if ($_POST) {
    if (
        isset($_POST["id_qgis"])
        && isset($_POST["nom"])
        && isset($_POST["numvoie"])
        && isset($_POST["adresse"])
        && isset($_POST["CP"])
        && isset($_POST["commune"])
        && isset($_POST["photo"])
        && isset($_POST["geometry"])
        && !empty($_POST["id_qgis"])
        && !empty($_POST["nom"])
        && !empty($_POST["numvoie"])
        && !empty($_POST["adresse"])
        && !empty($_POST["CP"])
        && !empty($_POST["commune"])
        && !empty($_POST["photo"])
        && !empty($_POST["geometry"])
    ) {
        $id_qgis = strip_tags($_POST["id_qgis"]);
        $nom = strip_tags($_POST["nom"]);
        $numvoie = strip_tags($_POST["numvoie"]);
        $adresse = strip_tags($_POST["adresse"]);
        $CP = strip_tags($_POST["CP"]);
        $commune = strip_tags($_POST["commune"]);
        $photo = strip_tags($_POST["photo"]);
        $geometry = strip_tags($_POST["geometry"]);
        require_once("db.php");
        $sql = "INSERT INTO parcs (id_qgis, nom, numvoie, address_name, address_code_postal, address_locality, photo, geom)
VALUES (:id_qgis, :nom, :numvoie, :adresse, :cp, :commune, :photo, ST_SetSRID(ST_GeomFromGeoJSON(:geometry), 4326));";
        $query = $pdo->prepare($sql);
        $query->bindValue(":id_qgis", $id_qgis, PDO::PARAM_STR);
        $query->bindValue(":nom", $nom, PDO::PARAM_STR);
        $query->bindValue(":numvoie", $numvoie, PDO::PARAM_STR);
        $query->bindValue(":adresse", $adresse, PDO::PARAM_STR);
        $query->bindValue(":cp", $CP, PDO::PARAM_STR);
        $query->bindValue(":commune", $commune, PDO::PARAM_STR);
        $query->bindValue(":photo", $photo, PDO::PARAM_STR);
        $query->bindValue(":geometry", $geometry, PDO::PARAM_STR);
        $query->execute();
        require("disconnect.php");
        header("Location: lyon_autrement_admin.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un parc</title>
    <link rel="stylesheet" href="../CSS/lyon_autrement.css">
    <link rel="stylesheet" href="../CSS/lyon_autrement_admin.css">
    <link rel="stylesheet" href="../CSS/lyon_autrement_responsive.css">
</head>

<body>
    <?php include('header_admin.php'); ?>
    <form method="post">
        <fieldset>
            <legend> Informations géographiques (QGIS) </legend>
            <div class="wrapper_form"></div>
            <label for="id_qgis">ID</label>
            <input type="text" name="id_qgis" id="id_qgis" required>
            <div class="wrapper_form"></div>
            <label for="geometry">geometry</label>
            <textarea name="geometry" id="geometry" required>{"type": "MultiPolygon", "coordinates": [[[...]]] }</textarea>
            <!-- ATTENTION : le "geometry" attend des valeurs geoJson de type MultiPolygon -->
        </fieldset>
        <fieldset>
            <legend> Informations générales du parc</legend>
            <div class="wrapper_form">
                <label for="nom">Nom du parc</label>
                <input type="text" name="nom" id="nom" required>
            </div>
            <div class="wrapper_form"></div>
            <label for="photo">photo</label>
            <input type="text" name="photo" id="photo">
            </div>
            <fieldset>
                <legend class="sous-fieldset"> Adresse</legend>
                <div class="wrapper_form">
                    <label for="numvoie">numéro et voie</label>
                    <input type="text" name="numvoie" id="numvoie" required>
                </div>
                <div class="wrapper_form">
                    <label for="adresse">adresse</label>
                    <input type="text" name="adresse" id="adresse" required>
                </div>
                <div class="wrapper_form">
                    <label for="CP">code postal</label>
                    <input type="text" name="CP" id="CP" required>
                </div>
                <div class="wrapper_form">
                    <label for="commune">commune</label>
                    <input type="text" name="commune" id="commune" required>
                </div>
            </fieldset>
        </fieldset>

        <input type="submit" value="Ajouter">
    </form>
    <a href="./lyon_autrement_admin.php">Retour à la liste</a>
</body>

</html>