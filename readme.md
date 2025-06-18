# Lyon Autrement – Application web cartographique (CRUD SIG)

Projet solo réalisé en autonomie dans le cadre d’un bootcamp de développement web fullstack (HTML/CSS/JS, PHP, PostgreSQL/PostGIS).

🗺️ Objectif : créer une carte interactive responsive intégrant des données géographiques, un fond de carte ancienne, et une interface d’administration complète (CRUD) en PHP.

📍 **Durée : 3 semaines** | **Stack principale : Leaflet, PHP, PostgreSQL/PostGIS, QGIS**  
📹 **[Voir la démo vidéo](https://youtu.be/WPlKPN56bd4)** 

---

## 👩‍💻 Ce que fait l’application

- Carte interactive basée sur Leaflet avec fond de carte ancienne géoréférencée
- Intégration de deux couches de données géographiques (POI + parcs), nettoyées dans QGIS
- Popups dynamiques avec style personnalisé par type de lieu
- Clustering automatique des points, filtres CSS
- Interface admin complète :
  - Ajouter / modifier / supprimer des POI
  - Données stockées en base PostgreSQL/PostGIS
- Design responsive (Flexbox/Grid, dark/light mode, `clamp()`, variables CSS)

---

## 🛠️ Stack technique

**Frontend :**  
HTML5, CSS3 (Grid/Flexbox, responsive, dark/light), JavaScript (vanilla), Leaflet

**Backend :**  
PHP (CRUD), PostgreSQL + PostGIS

**Cartographie SIG :**  
QGIS (nettoyage, export GeoJSON EPSG:4326), carte ancienne géoréférencée via tuiles locales

**Déploiement local :**  
Docker Compose, PHP/Apache, PostgreSQL/PostGIS (sans reverse proxy)

---

## 💡 Compétences développées

- Intégration SIG dans une app web fullstack
- Manipulation avancée de données géo (QGIS → GeoJSON → PostgreSQL)
- Maîtrise du CRUD complet en PHP (sans framework)
- Responsive design et stylisation dynamique via classes JS/CSS
- Création de tuiles à partir de cartes anciennes (via QGIS)

---

## 🔄 Limites & améliorations prévues

- Docker fonctionnel mais simplifié (pas de `.env`, structure à améliorer)
- Dossier PHP externalisé par erreur ➜ correction prévue dans un prochain projet
- Sécurité basique (prochaine étape : validation/sanitisation, gestion rôles)
- améliorer l'interface utilisateur : champs de recherche, tri de l'affichage
- côté back-end : lier les deux tables, pouvoir mettre en place des requêtes "X poi dans un rayon de Y mètres des parcs"

---

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
├── ressources_et_tricks.md (d'où viennent les données, et quelques petites choses apprises durant ce projet)
└── tests.md (POI et polygones en GeoJSON pour test) 
```
---
bonus : faire des arbos dans un .md ? 
https://tree.nathanfriend.com/ 

## ⚙️ Installation locale

1. Cloner le dépôt
2. Lancer `docker-compose up -d`
3. La base PostgreSQL + PostGIS et le serveur PHP sont automatiquement configurés
4. Les données sont chargées depuis `init.sql`
5. Accéder à `http://localhost:8083/` pour la carte

---

## 📥 Télécharger la carte géoréférencée

http://bit.ly/3SMGrvY 

--- 

## 🐳 Note sur Docker & organisation du projet

Le `docker-compose.yml` est basé sur l'exemple de mon formateur.  
Il permet de lancer les services essentiels (PostgreSQL + PHP/Apache) et fonctionne correctement.

Cependant :
- La structure des fichiers PHP n’est pas idéale : le dossier `php/` est externe à `lyon_autrement`, ce qui m’a obligée à recréer une arborescence à la main (`fichier_php/`).
- Les volumes ne sont pas encore optimisés (scripts SQL, logs, séparation nette des données).
- Les variables d’environnement ne sont pas externalisées dans un `.env`.

🎯 Pour un prochain projet, je prévois :
- Une structure de dossier plus claire (`app/`, `db/`, `scripts/`, `logs/`)
- L’utilisation d’un fichier `.env` pour sécuriser les variables sensibles
- Un reverse proxy (Nginx) et une config plus proche de la réalité de production

---
## 🎯 Objectifs du projet

### 1. Valider les exigences de la formation

- Implémenter un CRUD fullstack (PHP + PostgreSQL)
- Utiliser Docker pour orchestrer l’environnement de dev
- Gérer l’insertion, l’édition et la suppression de données SIG
- Expérimenter avec les interactions JS et les classes CSS de Leaflet

📝 Merci à mon formateur pour m’avoir permis d’adapter le sujet à mon profil SIG.

---

### 2. Explorer la chaîne complète de traitement SIG ➜ Web

- Nettoyage et fusion de plusieurs couches SIG dans QGIS
- Export au format GeoJSON (EPSG:4326)
- Création et alimentation de la base de données via PHP
- Affichage cartographique et stylisation dynamique avec Leaflet

---

### 3. Tester l’interface et l’expérience utilisateur

L’objectif n’était pas de construire un outil métier complet,  
mais de valider l’affichage agréable de données SIG sur carte web interactive.  
Je considère cette étape atteinte.

Je vais désormais renforcer mes compétences en :
- JavaScript (interactions avancées)
- PHP côté sécurité et logique métier
- SQL (requêtes spatiales et jointures)

