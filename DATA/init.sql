CREATE EXTENSION IF NOT EXISTS postgis;

CREATE TABLE poi (
    id INTEGER GENERATED ALWAYS AS IDENTITY PRIMARY KEY, 
    id_qgis INTEGER, 
    nom TEXT, 
    type TEXT, 
    address_name TEXT,
    address_code_postal TEXT, 
    address_locality TEXT, 
    description TEXT, 
    photo TEXT, 
    geom geometry(Point, 4326)
);

CREATE TABLE parcs (
    id INTEGER GENERATED ALWAYS AS IDENTITY PRIMARY KEY, 
    id_qgis INTEGER, 
    nom TEXT, 
    numvoie TEXT, 
    address_name TEXT, 
    address_code_postal TEXT, 
    address_locality TEXT, 
    photo TEXT, 
    geom geometry(MultiPolygon, 4326)
);

-- ATTENTION revoir la création de table parcs : modification de la structure dans insert_parcs.php