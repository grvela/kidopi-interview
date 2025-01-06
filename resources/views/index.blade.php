<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Kidopi - COVID 19</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
 
    <link 
        rel="stylesheet" 
        href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
        crossorigin=""
    />
    
    <script 
        src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
        crossorigin=""
    ></script>

    <style>
        #map {
            width: 100%;
            height: 100vh;
        }

        #sidebar {
            border: 1px solid red;
            width: 500px;
            background: #f8f9fa;
            height: 100vh;
            position: fixed;
            top: 0;
            right: 0;
            z-index: 1000;
            box-shadow: -2px 0 5px rgba(0, 0, 0, 0.2);
            padding: 10px;
            overflow-y: auto;
            transition: transform 0.3s ease;
        }

        #sidebar.collapsed {
            transform: translateX(100%);
        }

        #toggleSidebar {
            position: fixed;
            top: 20px;
            right: 10px;
            z-index: 1100;
            background: #007bff;
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 5px;
            display: none;
        }

        @media (max-width: 768px) {
            #toggleSidebar {
                display: block;
            }

            #sidebar {
                transform: translateX(100%);
            }

            #sidebar.open {
                transform: translateX(0);
            }
        }
    </style>
</head>
<body>

    <button id="toggleSidebar">☰</button>
    

    <div id="sidebar">
        <h2>Covid 19 - Data Tracker</h2>

        <h3>Countries: </h3>

        <select id="countries" name="country" style="max-height: 150px; overflow-y: auto;">
            @foreach ($countriesList as $item)
                <option value="{{ $item->country }}">{{ $item->country }}</option>
            @endforeach
        </select>

        <h3>Compare with: </h3>
        <a>Comparação de taxa de mortes: T1 - T2</a>


        <div class="countryCovidData">
            <h1>Total cases: </h1>
            <h1>Total deaths: </h1>
        </div>

        <div class="statesCovidData"">
            <h1>State: </h1>
            <h1>Confirmed cases: </h1>
            <h1>Confirmed deaths: </h1>
        </div>
    </div>

    <div id="map"></div>

    <script>
        const map = L.map('map').setView([0, 0], 2.5);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        const geojsonData = {!! $geojson !!};

        function style(feature) {
            return {
                fillColor: 'transparent',
                weight: 2,
                opacity: 1,
                color: 'white',
                fillOpacity: 0
            };
        }

        const defaultFillColor = '#E31A1C';
        let selectedLayer = null;

        const sidebar = document.getElementById('sidebar');
        const toggleSidebar = document.getElementById('toggleSidebar');

        toggleSidebar.addEventListener('click', () => {
            sidebar.classList.toggle('open');
        });

        const countrySelect = document.getElementById('countries');

        const countryLayerMap = {};

        function onEachFeature(feature, layer) {
            if (feature.id) {
                countryLayerMap[feature.id] = layer;
            }

            layer.on({
                click: function (e) {
                    highlightCountry(e.target.feature.id);
                    countrySelect.value = feature.properties.name;
                }
            });
        }

        const geojsonLayer = L.geoJSON(geojsonData, {
            style: style,
            onEachFeature: onEachFeature
        }).addTo(map);

        function highlightCountry(countryId) {
            if (selectedLayer) {
                selectedLayer.setStyle({
                    fillColor: 'transparent',
                    fillOpacity: 0
                });
            }

            const layer = countryLayerMap[countryId];
            if (layer) {
                selectedLayer = layer;
                layer.setStyle({
                    fillColor: defaultFillColor,
                    fillOpacity: 0.7
                });

                map.fitBounds(layer.getBounds());
            }
        }

        countrySelect.addEventListener('change', (e) => {
            const selectedCountry = e.target.value;
            const countryId = Object.keys(countryLayerMap).find(
                id => countryLayerMap[id].feature.properties.name === selectedCountry
            );
            highlightCountry(countryId);
        });
    </script>

</body>
</html>
