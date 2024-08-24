<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interactive Map with Persistent Popup Table</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        #map { height: 700px; width: 100%; }
        .popup-table {
            width: 200px;
            border-collapse: collapse;
            margin: 0 auto;
        }
        .popup-table th, .popup-table td {
            border: 1px solid #ddd;
            padding: 5px;
            text-align: left;
            font-size: 12px;
        }
        .popup-table th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div id="map"></div>
    <script>
        var map = L.map('map').setView([-14.996665839805985, 35.04404396532377], 9.5);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Load GeoJSON data
        fetch('data.geojson')  // Replace with the path to your GeoJSON file
            .then(response => response.json())
            .then(geojsonData => {
                L.geoJSON(geojsonData, {
                    onEachFeature: function (feature, layer) {
                        // Define a function to create the popup content
                        function createPopupContent() {
                            var name = feature.properties.name;
                            var coordinates = feature.geometry.coordinates;
                            return `
                                <table class="popup-table">
                                    <tr><th>Name</th><td>${name}</td></tr>
                                    <tr><th>Latitude</th><td>${coordinates[1]}</td></tr>
                                    <tr><th>Longitude</th><td>${coordinates[0]}</td></tr>
                                </table>
                            `;
                        }

                        // Bind a popup to the marker, set it to open when the marker is clicked
                        layer.bindPopup(createPopupContent());

                        // Ensure the popup opens on click every time
                        layer.on('click', function() {
                            layer.openPopup();
                        });
                    }
                }).addTo(map);
            })
            .catch(error => console.error('Error loading GeoJSON:', error));
    </script>
</body>
</html>
