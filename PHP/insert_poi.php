<?php

require_once 'db.php';

// lecture fichier GeoJSON
$geojson = file_get_contents('../DATA/export_clean_all_poi.geojson');