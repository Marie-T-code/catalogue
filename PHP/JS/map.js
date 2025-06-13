console.log('map.js loaded');
console.log("🧠 map.js VIVANT", window.location.href);

var map = L.map('map').setView([45.761, 4.83], 15);
const osm = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
  minZoom: 14,
  maxZoom: 17,
  attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);


const light = L.tileLayer('tiles/desktop_light/mapnik/{z}/{x}/{y}.png', {
  minZoom: 15,
  maxZoom: 16,
  tileSize: 256,
  noWrap: true,
  attribution: 'Carte Darmet 1850',
  opacity: 1
}).addTo(map);

light.on('tileerror', e => {
  console.error('🟥 Erreur de tuile LIGHT:', e.tile.src);
});

const dark = L.tileLayer('tiles/desktop_dark/{z}/{x}/{y}.png', {
  minZoom: 15,
  maxZoom: 16,
  attribution: 'Carte Darmet 1850 (dark)',
  opacity: 1,
  noWrap: true
});

// toggle darl/Light maps

const baseMaps = {
  "Light": light,
  "Dark": dark
};

L.control.layers(baseMaps).addTo(map);


// les POI 
const typeIcons = {
  'EQUIPEMENT': 'images/carriage.svg',
  // Ajoute d’autres types si besoin
};


fetch('../fichiers_php/fetch_poi.php')
  .then(response => {
    if (!response.ok) {
      throw new Error(`Erreur HTTP: ${response.status}`);
    }
    return response.json();
  })
  .then(data => {
    // Debug - regarde ce que tu reçois vraiment
    console.log('Données reçues:', data);
    console.log('Type de data:', typeof data);
    console.log('data.features:', data.features);
    // Vérifier si on a des données
    if (!data.features || data.features.length === 0) {
      console.warn('Aucune donnée trouvée');
      alert('Aucun point d\'intérêt trouvé');
      return;
    }
    // 1. Initialise le groupe de clusters
    const markers = L.markerClusterGroup();

    // 2. Crée une couche GeoJSON classique
    const geojsonLayer = L.geoJSON(data, {
      pointToLayer: function (feature, latlng) {
        const type = feature.properties.type || 'inconnu';

        if (type === 'EQUIPEMENT') {
          return L.marker(latlng, {
            icon: L.icon({
              iconUrl: typeIcons[type],
              iconSize: [40, 40],
              iconAnchor: [20, 40],
              popupAnchor: [0, -35]
            })
          });
        }

        return L.marker(latlng); // marqueur par défaut
      },

      onEachFeature: function (feature, layer) {
        const nom = feature.properties.nom || 'Sans nom';
        const description = feature.properties.description || '';
        const type = feature.properties.type || 'inconnu';

        const iconPath = typeIcons[type] || null;
        const iconHtml = iconPath
          ? `<img src="${iconPath}" alt="${type}" class="popup-icon">`
          : '';

        const popupContent = `
          <div class="popup-content popup-${type.toLowerCase()}">
            ${iconHtml}
            <strong>${nom}</strong><br>${description}
          </div>
        `;

        layer.bindPopup(popupContent);
      }
    });

    // 3. Ajoute la couche GeoJSON dans le cluster
    markers.addLayer(geojsonLayer);

    // 4. Ajoute le cluster à la carte
    map.addLayer(markers);
  })
  .catch(error => console.error('Erreur de chargement GeoJSON :', error));

document.addEventListener('themeChanged', (e) => {
  const mode = e.detail.mode;
  if (mode === 'dark') {
    map.removeLayer(light);
    map.addLayer(dark);
  } else {
    map.removeLayer(dark);
    map.addLayer(light);
  }
});


// LES PARCS 

fetch('../fichiers_php/fetch_parcs.php')
  .then(response => {
    if (!response.ok) {
      throw new Error(`Erreur HTTP: ${response.status}`);
    }
    return response.json();
  })
  .then(data => {
    // Debug - regarde ce que tu reçois vraiment
    console.log('Données reçues:', data);
    console.log('Type de data:', typeof data);
    console.log('data.features:', data.features);
    // Vérifier si on a des données
    if (!data.features || data.features.length === 0) {
      console.warn('Aucune donnée trouvée');
      alert('Aucun parc trouvé');
      return;
    }
    L.geoJSON(data, {
      style: () => ({
        className: 'layer-parcs',
        weight: 2,
      }),
      onEachFeature: function (feature, layer) {
        const nom = feature.properties.nom || 'Sans nom';
        const adresse = feature.properties.address_name || '';
        const photo = feature.properties.photo || 'inconnu';

        const popupContent = `
          <div class="popup-content popup-${adresse.toLowerCase()}">
            <strong>${nom}</strong><br>${photo}
          </div>
        `;
        layer.bindPopup(popupContent);
      }
    }).addTo(map);
  }); 
