<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lyon autrement page administrateur</title>
</head>

<body>
<?php
require_once ('db.php');
$sql_poi = "SELECT * FROM poi;";
//preparation de la requête
$query_poi = $pdo->prepare($sql_poi);
//execution de la requête
$query_poi->execute();
// récupération des données de la requête
$pois = $query_poi->fetchAll(PDO::FETCH_ASSOC);

$sql_parcs = "SELECT * FROM parcs;";
$query_parcs = $pdo->prepare($sql_parcs);
$query_parcs->execute();
$parcs = $query_parcs->fetchAll(PDO::FETCH_ASSOC);
require("disconnect.php");
?>
<header id="admin">
     <nav>
            <ul>
                <li><a href="#ajout_poi">ajout POI</a></li>
                <li><a href="#ajout_parcs">ajout PARCS</a></li>
                <li>page utilisateur</li>
            </ul>
        </nav>
    </header>
    <h1>Lyon Autrement : page Administrateur</h1>

    <table>
        <thead>
            <th>id_qgis</th>
            <th>nom</th>
            <th>type</th>
            <th>adresse</th>
            <th>code postal</th>
            <th>commune</th>
            <th>description</th>
            <th>photo</th>
            <th>geom</th>
            <th>actions</th>
        </thead>
        <tbody>
             <?php
            foreach ($pois as $poi):
            ?>
            <tr>
                <td> <?= $poi['id_qgis'] ?> </td>
                <td><?= $poi['nom'] ?></td>
                <td><?= $poi['type'] ?></td>
                <td><?= $poi['address_name'] ?></td>
                <td><?= $poi['address_code_postal'] ?></td>
                <td><?= $poi['address_locality'] ?></td>
                <td><?= $poi['description'] ?></td>
                <td><?= $poi['photo'] ?></td>
                <td><?= $poi['geom'] ?></td>
                <td><a href="voir_poi.php?id=<?= $poi['id_qgis'] ?>">voir</a>
                    <a href="modifier_poi.php?id=<?= $poi['id_qgis'] ?>">Modifier</a>
                    <a href="supprimer_poi.php?id=<?= $poi['id_qgis'] ?>" onclick="return confirm('Supprimer ce point ?')">Supprimer</a>
                </td>
                <!-- onclick="return confirm ('...')" est natif au HTML, n'a pas besoin de script JS, et marche même en statique  -->
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
    <a id="ajout_poi" href="ajout_poi.php">ajouter un POI</a>

      <table id="ajout_parcs">
        <thead>
            <th>id_qgis</th>
            <th>nom</th>
            <th>numvoie</th>
            <th>adresse</th>
            <th>code postal</th>
            <th>commune</th>
            <th>photo</th>
            <th>geom</th>
            <th>actions</th>
        </thead>
        <tbody>
            <?php foreach ($parcs as $parc): ?>
            <tr>
                <td><?= $parc['id_qgis'] ?></td>
                <td><?= $parc['nom'] ?></td>
                <td><?= $parc['numvoie'] ?></td>
                <td><?= $parc['address_name'] ?></td>
                <td><?= $parc['address_code_postal'] ?></td>
                <td><?= $parc['address_locality'] ?></td>
                <td><?= $parc['photo'] ?></td>
                <td><?= $parc['geom'] ?></td>
                <td>
                    <a href="voir_parc.php?id=<?= $parc['id_qgis'] ?>">voir</a>
                    <a href="modifier_parc.php?id=<?= $parc['id_qgis'] ?>">Modifier</a>
                    <a  href="supprimer_parc.php?id=<?= htmlspecialchars($parc['id_qgis']) ?>" onclick="return confirm('Supprimer ce parc ?')">Supprimer</a>
                </td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
    <a href="ajout_parcs.php">ajouter un parc</a>
</body>

</html>