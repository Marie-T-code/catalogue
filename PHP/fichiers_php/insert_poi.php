<?php

require_once 'db.php';

// lecture fichier GeoJSON
$geojson = file_get_contents(__DIR__ . '/../DATA/export_clean_all_poi.geojson');
$data = json_decode($geojson, true);

// veriiier que $data est exploitable

if (!$data || ! isset($data['features'])) {
    die("Fichier Geojson invalide ou vide");
}

foreach ($data['features'] as $feature) {
    $props = $feature['properties'];
    $geom = $feature['geometry'];


    $sql = "INSERT INTO poi(
        id_qgis, nom, type, address_name, address_code_postal, address_locality, description, photo, geom)
VALUES (
        :id_qgis, :nom, :type, :address_name, :address_code_postal, :address_locality, :description, :photo, ST_SetSRID(ST_GeomFromGeoJSON(:geom), 4326)
)";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':id_qgis' => $props['id'] ?? null,
        ':nom' => $props['nom'] ?? null,
        ':type' => $props['type'] ?? null,
        ':address_name' => $props['address_name'] ?? null,
        ':address_code_postal' => $props['address_postalCode'] ?? null,
        ':address_locality' => $props['address_addressLocality'] ?? null,
        ':description' => $props['descrcourtfr'] ?? null,
        ':photo' => $props['photo'] ?? null,
        ':geom' => json_encode($geom)
    ]);
};


echo "Tous les POI ont été insérés sans erreur.";