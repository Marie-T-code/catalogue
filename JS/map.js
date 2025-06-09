var map = L.map('map').setView([45.761, 4.83], 15);
const osm = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    minZoom: 14,
    maxZoom: 17,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);


const light = L.tileLayer('../tiles/desktop_light/mapnik/{z}/{x}/{y}.png', {
  minZoom: 15,
  maxZoom: 16,
  tileSize: 256,
  noWrap: true,
  attribution: 'Carte Darmet 1850',
  opacity: 1
}).addTo(map);

const dark = L.tileLayer('../tiles/desktop_dark/{z}/{x}/{y}.png', {
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
  'EQUIPEMENT': '../images/carriage.svg',
  // Ajoute d’autres types si besoin
};


fetch('../DATA/export_clean_all_poi.geojson')
  .then(response => response.json())
  .then(data => {
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

