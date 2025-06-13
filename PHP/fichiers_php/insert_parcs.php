<?php
require_once 'db.php';
$geojson = file_get_contents(__DIR__ . '/../DATA/export_clean_all_polygons_parcs_et_jardins.geojson');
$data = json_decode($geojson, true);

if (!$data || !isset($data['features'])){
    die("Fichier Geojson invalide ou vide");
}

foreach ($data['features'] as $feature){
    $props = $feature['properties'];
    $geom = $feature['geometry'];

    $sql ="INSERT INTO parcs (
    id_qgis, nom, numvoie, address_name, address_code_postal, address_locality, photo, geom)
    VALUES (
    :id_qgis, :nom, :numvoie, :address_name, :address_code_postal, :address_locality, :photo,
    ST_SetSRID(ST_GeomFromGeoJSON(:geom), 4326)
    )";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':id_qgis' => $props['id'] ??  null, 
        ':nom' => $props['nom'] ?? null, 
        ':numvoie' => $props['numvoie'] ?? null, 
        ':address_name' => $props['numvoie'] ?? null, 
        ':address_code_postal' => $props['codepost'] ?? null, 
        ':address_locality' => $props['commune'] ?? null, 
        ':photo' => $props['photo'] ?? null, 
        ':geom' =>json_encode($geom)
    ]);
};

echo "Tous les parcs sont parqués";
