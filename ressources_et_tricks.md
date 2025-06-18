# Ressources

## Bouton toggle dark/light

- Bouton de base : [vidéo YouTube](https://www.youtube.com/watch?v=S-T9XoCMwt4)  
  → adapté avec inclusion de JS, **sans** passer par une checkbox invisible en pur CSS.
- Icônes lune et soleil : SVG extraits de [svg.repo] — domaine public (licence PD).

---


## Carte géoréférencée

- Carte ancienne : [Gallica – Plan de Lyon](https://gallica.bnf.fr/ark:/12148/btv1b53084997b)  
  (téléchargée en HD, voir plus bas pour l’astuce IIIF).

---

## Données de la base de données

- Source d’inspiration : [patrimoine-lyon.org](https://www.patrimoine-lyon.org)
- Données utilisées : [data.grandlyon.com](https://data.grandlyon.com)  
  → arrondissements 1 à 9 uniquement

---

# Petits trucs et astuces appris durant le projet

## Télécharger une image Gallica en HD

URL type :  
https://gallica.bnf.fr/iiif/ark:/12148/btv1b53084997b/f1/full/full/0/native.jpg

Structure : 

/iiif/ + identifiant de l’image + /f1/ (n° de page) + full/full/0/native.jpg

🔎 Astuce : si plusieurs pages sont à imprimer, changer le `f1`.


---

## Découverte du back-end

- Faire un **hard refresh** quand on modifie du JS :  
  `CTRL + SHIFT + R` (pas juste `F5`).

---

## `.gitignore` – règles utiles

- `nom_dossier/` → ignore ce dossier partout dans le dépôt  
- `/nom_dossier/` → ignore **uniquement** à la racine  
- `chemin/vers/dossier_specifique/` → ignore à ce chemin précis  
- `**/nom_dossier/` → variante explicite pour “partout” (le `**` = zéro ou plusieurs répertoires)

💡 Pour un cas simple comme `images/fonds_de_carte/`, pas besoin du `**`, Git comprend sans.

---

## Fonts : VariableFont vs Fonts classiques

Lors du téléchargement de polices via Google Fonts, deux types de fichiers peuvent apparaître :

- des **fichiers classiques** (par graisse), à placer dans un dossier `static/`
- des **fichiers variables**, du type :  
  `YourFont-VariableFont_wght.woff2`  
  → **`.woff2` est recommandé pour le web**

Place les fichiers variables dans un dossier `fonts/`.

Avec une police variable, on peut utiliser une **plage de poids** dans `@font-face` :

```css
@font-face {
  font-family: 'YourFont';
  src: url('/fonts/YourFont-VariableFont_wght.woff2') format('woff2');
  font-weight: 100 900;
}
h1 {
  font-weight: 525;
  transition: font-weight 0.3s ease;
}
```
🎯 Avantages :

- contrôle plus fin (font-weight: 525)

- transitions animées entre les graisses (transition: font-weight)

---

📝 Ce fichier est un mémo personnel compilé pendant le projet Lyon Autrement.