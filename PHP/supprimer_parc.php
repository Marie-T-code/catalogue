<?php

if (!empty($_GET["id"])) {
    require_once("db.php");

    $id = filter_var($_GET["id"], FILTER_VALIDATE_INT);
    $sql_delete_parc = "DELETE FROM parcs WHERE id_qgis = :id;";
    $query_delete_parc = $pdo->prepare($sql_delete_parc);
    $query_delete_parc->bindValue(":id", $id, PDO::PARAM_INT);
    $query_delete_parc->execute();

    require("disconnect.php");
    header("Location: lyon_autrement_admin.php");
    exit;
}