<?php
require_once 'bd.php'; 

// fichier à destination JS/leaflet, ne sert PAS à l'insertion etc. de données côté admin


header('Content-Type: application/json');
// script qui enverra du json => cette ligne est une instruction php qui informe le navigateur que les données seront en json (pas html ni texte brut)
 $sql_fetch_parcs= "SELECT id, id_qgis, nom, numvoie, address_name, address_code_postal, address_locality, photo, ST_AsGeoJSON(geom)::json AS geometry FROM parcs";

// preparation de la requête 
$query_fetch_parcs = $db->prepare($sql_fetch_parcs);
// execution d ela requête 
$query_fetch_parcs->execute();
$features = [];
// preparation d'un tableau vide dans lequel chacune des feature sera stockée (rappel : geoJson attend une FeatureCollection)

    while ($row = $query_fetch_parcs->fetch(PDO::FETCH_ASSOC)) {
        $geometry = $row['geometry'];
    // extraction de la geometrie d'un côté 
        unset($row['geometry']);
    // retirer la géométrie des propriétés 
        $features[] = [
            "type" => "Feature",
            "geometry" => $geometry,
            "properties" => $row
        ];
      // créer un tableau type featurecollection avec d'un côté les features et de l'autre la geom correspondant au modèle geojson 
    }



    echo json_encode([
        "type" => "FeatureCollection",
        "features" => $features
    ], JSON_UNESCAPED_UNICODE);

?>
