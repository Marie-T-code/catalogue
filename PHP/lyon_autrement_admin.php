<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lyon autrement page administrateur</title>
    <link rel="stylesheet" href="../CSS/lyon_autrement.css">
    <link rel="stylesheet" href="../CSS/lyon_autrement_admin.css">
    <link rel="stylesheet" href="../CSS/lyon_autrement_responsive.css">
</head>

<body>
    <?php
    require_once('db.php');
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
    <?php include('header_admin.php'); ?>
    <h1>Lyon Autrement : page Administrateur</h1>
    <section aria-labelledby="liste-des-POI">
        <h2 id="liste-des-POI">Liste des POI</h2>
        <div class="table-wrapper">
            <table id=table_poi>
                <thead>
                    <th scope="col">id_qgis</th>
                    <th scope="col">nom</th>
                    <th scope="col">type</th>
                    <th scope="col">adresse</th>
                    <th scope="col">code postal</th>
                    <th scope="col">commune</th>
                    <th scope="col">description</th>
                    <th scope="col">photo</th>
                    <th scope="col">geom</th>
                    <th scope="col">actions</th>
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
                            <td>
                                <details>
                                    <summary>Voir la géométrie</summary>
                                    <pre><?= $poi['geom'] ?></pre>
                                </details>
                            </td>
                            <td><a href="voir_poi.php?id=<?= $poi['id_qgis'] ?>"
                                    aria-label="Voir le POI <?= $poi['id_qgis'] ?> – <?= htmlspecialchars($poi['nom']) ?>">voir</a>
                                <a href="modifier_poi.php?id=<?= $poi['id_qgis'] ?>"
                                    aria-label="Modifier le POI <?= $poi['id_qgis'] ?> – <?= htmlspecialchars($poi['nom']) ?>">Modifier</a>
                                <a href="supprimer_poi.php?id=<?= $poi['id_qgis'] ?>"
                                    aria-label="Supprimer le POI <?= $poi['id_qgis'] ?> – <?= htmlspecialchars($poi['nom']) ?>"
                                    onclick="return confirm('Supprimer ce point ?')">Supprimer</a>
                            </td>
                            <!-- onclick="return confirm ('...')" est natif au HTML, n'a pas besoin de script JS, et marche même en statique  -->
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
            <a aria-label="Ajouter un poi" class="btn" id="ajout_poi" href="ajout_poi.php">ajouter un POI</a>
        </div>
    </section>
    <section aria-labelledby="liste_des_parcs">
        <h2 id="liste_des_parcs">Liste des parcs</h2>
        <div class="table-wrapper">
            <table id=table_parcs>
                <thead>
                    <th scope="col">id_qgis</th>
                    <th scope="col">nom</th>
                    <th scope="col">numvoie</th>
                    <th scope="col">adresse</th>
                    <th scope="col">code postal</th>
                    <th scope="col">commune</th>
                    <th scope="col">photo</th>
                    <th scope="col">geom</th>
                    <th scope="col">actions</th>
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
                            <td>
                                <details>
                                    <summary>Voir la géométrie</summary>
                                    <pre><?= $parc['geom'] ?></pre>
                                </details>
                            </td>
                            <td>
                                <a href="voir_parc.php?id=<?= $parc['id_qgis'] ?>"
                                    aria-label="Voir le parc <?= $parc['id_qgis'] ?> – <?= htmlspecialchars($parc['nom']) ?>">voir</a>
                                <a href="modifier_parc.php?id=<?= $parc['id_qgis'] ?>"
                                    aria-label="Modifier le POI <?= $poi['id_qgis'] ?> – <?= htmlspecialchars($poi['nom']) ?>">Modifier</a>
                                <a href="supprimer_parc.php?id=<?= htmlspecialchars($parc['id_qgis']) ?>"
                                    aria-label="Supprimer le POI <?= $parc['id_qgis'] ?> – <?= htmlspecialchars($parc['nom']) ?>"
                                    onclick="return confirm('Supprimer ce parc ?')">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
            <a aria-label="Ajouter un parc" class="btn" id="ajout_parcs" href="ajout_parcs.php">ajouter un parc</a>
        </div>
    </section>
</body>

</html>