<?php 
require_once ("db.php");

if ($_POST) {
    if (
        !empty($_POST["id_qgis"])
        && !empty($_POST["nom"])
        && !empty($_POST["type"])
        && !empty($_POST["description"])
        && !empty($_POST["geometry"])
    ) {
        $id = filter_var($_POST["id_qgis"], FILTER_VALIDATE_INT); // ou FILTER_SANITIZE_STRING si alphanum
        $nom = htmlspecialchars(strip_tags($_POST["nom"]), ENT_QUOTES);
        $type = htmlspecialchars(strip_tags($_POST["type"]), ENT_QUOTES);
        $description = htmlspecialchars(strip_tags($_POST["description"]), ENT_QUOTES);
        $address_name = htmlspecialchars(strip_tags($_POST["address_name"]), ENT_QUOTES);
        $address_code_postal = htmlspecialchars(strip_tags($_POST["address_code_postal"]), ENT_QUOTES);
        $address_locality = htmlspecialchars(strip_tags($_POST["address_locality"]), ENT_QUOTES);
        $photo = htmlspecialchars(strip_tags($_POST["photo"]), ENT_QUOTES);
        $geometry = $_POST["geometry"]; // pas de strip_tags pour GeoJSON

        $sql = "UPDATE poi 
                SET nom = :nom, type = :type, description = :description, 
                    address_name = :address_name, address_code_postal = :address_code_postal,
                    address_locality = :address_locality, photo = :photo,
                    geom = ST_GeomFromGeoJSON(:geometry)
                WHERE id_qgis = :id_qgis;";

        $query = $pdo->prepare($sql);
        $query->bindValue(":id_qgis", $id, PDO::PARAM_INT);
        $query->bindValue(":nom", $nom);
        $query->bindValue(":type", $type);
        $query->bindValue(":description", $description);
        $query->bindValue(":address_name", $address_name);
        $query->bindValue(":address_code_postal", $address_code_postal);
        $query->bindValue(":address_locality", $address_locality);
        $query->bindValue(":photo", $photo);
        $query->bindValue(":geometry", $geometry, PDO::PARAM_STR);

        $query->execute();

        header("Location: Lyon_autrement_admin.php");
    }
}

if (
    isset($_GET["id"])
    && !empty($_GET["id"])
) {
    $id = $_GET["id"];
    $sql = "SELECT *, ST_AsGeoJSON(geom) AS geometry FROM poi WHERE id_qgis = :id";
    $query = $pdo->prepare($sql);
    $query->bindValue(":id", $id, PDO::PARAM_INT);
    $query->execute();
    $poi = $query->fetch();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Modifier un POI</title>
</head>
<body>
<?php if (!empty($poi)): ?>
<form method="post">
    <label for="nom">Nom</label>
    <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($poi['nom'], ENT_QUOTES) ?>" required>

    <label for="type">Type</label>
    <input type="text" id="type" name="type" value="<?= htmlspecialchars($poi['type'], ENT_QUOTES) ?>" required>

    <label for="description">Description</label>
    <textarea id="description" name="description" required><?= htmlspecialchars($poi['description'], ENT_QUOTES) ?></textarea>

    <label for="address_name">Adresse</label>
    <input type="text" id="address_name" name="address_name" value="<?= htmlspecialchars($poi['address_name'], ENT_QUOTES) ?>">

    <label for="address_code_postal">Code postal</label>
    <input type="text" id="address_code_postal" name="address_code_postal" value="<?= htmlspecialchars($poi['address_code_postal'], ENT_QUOTES) ?>">

    <label for="address_locality">Commune</label>
    <input type="text" id="address_locality" name="address_locality" value="<?= htmlspecialchars($poi['address_locality'], ENT_QUOTES) ?>">

    <label for="photo">URL Photo</label>
    <input type="text" id="photo" name="photo" value="<?= htmlspecialchars($poi['photo'], ENT_QUOTES) ?>">

    <label for="geometry">Géométrie (GeoJSON)</label>
    <textarea id="geometry" name="geometry" required><?= htmlspecialchars($poi['geometry']) ?></textarea>
    <small>Exemple : {"type": "Point", "coordinates": [4.8357, 45.7640]}</small>

    <input type="hidden" name="id_qgis" value="<?= htmlspecialchars($poi['id_qgis'], ENT_QUOTES) ?>">
    <input type="submit" value="Modifier">
</form>
<a href="lyon_autrement_admin.php">Retour à la liste</a>
<?php else: ?>
<p>Le POI n’a pas été trouvé.</p>
<?php endif; ?>
</body>
</html>
