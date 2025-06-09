<?php

if ($_POST){
    if(isset($_POST["id_qgis"]) 
    && isset($_POST["nom"])
    && isset($_POST["type"])  
    && isset($_POST["adresse"]) 
    && isset($_POST["CP"]) 
    && isset($_POST["commune"]) 
    && isset($_POST["description"]) 
    && isset($_POST["photo"]) 
    && isset($_POST["geometry"]) 
// isset vérifie l’existence (y compris si vide), !empty vérifie aussi qu’il y a du contenu.
    && !empty($_POST["id_qgis"])
    && !empty($_POST["nom"])
    && !empty($_POST["type"])
    && !empty($_POST["adresse"])
    && !empty($_POST["CP"])   
    && !empty($_POST["commune"])
    && !empty($_POST["description"]) 
    && !empty($_POST["photo"])
    && !empty($_POST["geometry"])){
        $id_qgis = strip_tags($_POST["id_qgis"]);
        $nom = strip_tags($_POST["nom"]);
        $type = strip_tags($_POST["type"]);
        $adresse = strip_tags($_POST["adresse"]);
        $CP = strip_tags($_POST["CP"]);
        $commune = strip_tags($_POST["commune"]);
        $description = strip_tags($_POST["description"]);
        $photo = strip_tags($_POST["photo"]);
        $geometry = strip_tags($_POST["geometry"]);
require_once("db.php"); 
$sql = "INSERT INTO poi (id_qgis, nom, type, address_name, address_code_postal, address_locality, description, photo, geom)
VALUES (:id_qgis, :nom, :type, :adresse, :cp, :commune, :description, :photo, ST_SetSRID(ST_GeomFromGeoJSON(:geometry), 4326));";
$query = $pdo->prepare($sql);
$query->bindValue(":id_qgis", $id_qgis, PDO::PARAM_STR); 
        $query->bindValue(":nom", $nom, PDO::PARAM_STR);
        $query->bindValue(":type", $type, PDO::PARAM_STR);
        $query->bindValue(":adresse", $adresse, PDO::PARAM_STR);
        $query->bindValue(":cp", $CP, PDO::PARAM_STR);
        $query->bindValue(":commune", $commune, PDO::PARAM_STR);
        $query->bindValue(":description", $description, PDO::PARAM_STR);
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
    <title>Ajouter un POI</title>
</head>

<body>
    <form method="post">
        <label for="id_qgis">ID</label>
        <input type="text" name="id_qgis" id="id_qgis" required>
        <label for="nom">Nom du POI</label>
        <input type="text" name="nom" id="nom" required>
        <label for="type">type</label>
        <input type="text" name="type" id="type" required>
        <label for="adresse">adresse</label>
        <input type="text" name="adresse" id="adresse" required>
        <label for="CP">code postal</label>
        <input type="text" name="CP" id="CP" required>
        <label for="commune">commune</label>
        <input type="text" name="commune" id="commune" required>
        <label for="description">description</label>
        <textarea name="description" id="description" required></textarea>
        <label for="photo">photo</label>
        <input type="text" name="photo" id="photo" required>
        <label for="geometry">geometry</label>
        <textarea name="geometry" id="geometry" required >{"type": "Point", "coordinates": [4.8357, 45.7640]}</textarea>
        <!-- ATTENTION : le "geometry" attend des valeurs geoJson ! dans textarea entrer par exemple : {"type": "Point", "coordinates": [4.8357, 45.7640]} -->
        <input type="submit" value="Ajouter">
        <!-- ou bien
        <button type="submit"></button> -->
    </form>
    <a href="./lyon_autrement_admin.php">Retour à la liste</a>
</body>
</html>