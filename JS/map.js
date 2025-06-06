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

fetch('../DATA/export_clean_all_poi.geojson')
  .then(response => response.json())
  .then(data => {
    L.geoJSON(data, {
      onEachFeature: function (feature, layer) {
        const nom = feature.properties.nom || 'Sans nom';
        const description = feature.properties.description || '';
        layer.bindPopup(`<strong>${nom}</strong><br>${description}`);
      }
    }).addTo(map);
  })
  .catch(error => console.error('Erreur de chargement GeoJSON :', error));