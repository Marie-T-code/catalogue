<?php

if ( 
    !empty($_GET["id"])
) {
    require_once("db.php");
    $id = filter_var($_GET["id"], FILTER_VALIDATE_INT);
    $sql_delete_poi = "DELETE FROM poi WHERE id_qgis= :id;";
    $query_delete_poi = $pdo->prepare($sql_delete_poi);
    $query_delete_poi->bindValue(":id", $id, PDO::PARAM_INT);
    $query_delete_poi->execute();
    require("disconnect.php");
    header("Location: lyon_autrement_admin.php");
    exit;
}

