# Lyon Autrement – Projet CRUD SIG

Projet solo de city guide interactif sur fond de carte ancienne.  
Développé dans le cadre d’un bootcamp fullstack (HTML/CSS/JS, PHP, PostgreSQL/PostGIS, Leaflet, QGIS).

## 🔧 Stack technique

- **Frontend** : HTML, CSS (flex/grid, responsive, dark/light), JavaScript (vanilla), Leaflet
- **Backend** : PHP (CRUD), PostgreSQL + PostGIS
- **Carto** : QGIS pour le nettoyage/export GeoJSON, carte ancienne géoréférencée (tuiles locales)

## 📌 Fonctionnalités

- Affichage dynamique de deux couches (POI et parcs/jardins) depuis PostgreSQL
- Popups personnalisées, clustering, filtres CSS par type
- Interface admin : ajout, modification et suppression de POI
- Données nettoyées dans QGIS, exportées en EPSG:4326, importées via SQL
- Fond de carte ancienne affiché en tuiles locales Leaflet

## 📁 Arborescence actuelle (classée par stack)

```text
├── DATA/
│   ├── export_clean_all_poi.geojson
│   ├── export_clean_all_poi.qmd
│   ├── export_clean_all_polygons_parcs_et_jardins.geojson
│   ├── export_clean_all_polygons_parcs_et_jardins.qmd
│   └── init.sql
├── PHP/
│   ├── CSS
│   ├── DATA
│   ├── fichiers_php/
│   │   ├── fetch_poi.php           
│   │   ├── fetch_parcs.php       
│   │   ├── ajouter_poi.php          
│   │   ├── modifier_poi.php          
│   │   ├── supprimer_poi.php
│   │   ├── (ajouter/modifier/supprimer parcs.php – logique CRUD)
│   │   └── lyon_autrement_admin.php (interface admin)
│   ├── FONTS
│   ├── HTML
│   ├── images
│   ├── JS/
│   │   ├── ui.js
│   │   └── map.js
│   ├── tests
│   └── index.php
├── .gitignore
├── docker-compose
├── Dockerfile
├── readme
├── ressources catalogue
└── tests.md (POI et polygones en GeoJSON pour test) 
```


## ⚙️ Installation locale

1. Cloner le dépôt
2. Lancer `docker-compose up -d`
3. La base PostgreSQL + PostGIS et le serveur PHP sont automatiquement configurés
4. Les données sont chargées depuis `init.sql`
5. Accéder à `http://localhost:8083/` pour la carte

---
bonus : faire des arbo dans un .md ? 
https://tree.nathanfriend.com/ 

--- 

## telecharger les tuiles et la carte géoréférencee 

http://bit.ly/3SMGrvY 