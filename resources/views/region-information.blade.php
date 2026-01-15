@extends('layouts.application-blank', ['title' => __('pages/region-information.title'), 'paddingContent' => 'mb-0'])

@section ('content')
<div id="map" style="height: 400px;" class="card-header"></div>
    <style>
        :root {
            --lexi-black: #111111;
            --lexi-gray: #666666;
            --lexi-light: #f9f9f9;
            --lexi-border: #f2f2f2;
        }
        
        .locator-box {
            background: var(--lexi-light);
            border: 1px solid var(--lexi-border);
            padding: 3rem;
            margin-bottom: 3rem;
        }
        .lexi-search-input-group {
            background: #fff;
            border: 2px solid var(--lexi-black);
            display: flex;
            max-width: 600px;
        }
        .lexi-search-input-group input { border: none; flex-grow: 1; padding: 15px; outline: none; font-size: 1.1rem; }
        .lexi-search-input-group button { border: none; background: var(--lexi-black); color: #fff; padding: 0 30px; font-weight: 600; }
        
        .lexi-result-card {
            border: 1px solid var(--lexi-border);
            padding: 1.5rem;
            background: #fff;
            margin-top: 2rem;
            max-width: 100%;
            display: none; /* Verborgen tot zoekopdracht */
        }
        .card-meta { font-weight: 800; text-transform: uppercase; font-size: 0.7rem; color: var(--lexi-gray); letter-spacing: 0.1em; display: block; margin-bottom: 0.5rem; }
        .card-title { font-weight: 700; font-size: 1.4rem; margin-bottom: 0.25rem; display: block; }

        .meta-label {
            font-size: 0.65rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--lexi-gray);
            margin-bottom: 0.5rem;
            display: block;
        }

        .editorial-content p { margin-bottom: 1.5rem; }
        .province-tag {
            font-weight: 800;
            text-transform: uppercase;
            font-size: 0.75rem;
            margin-top: 1.5rem;
            display: block;
            border-bottom: 1px solid var(--lexi-black);
            padding-bottom: 2px;
            margin-bottom: 0.5rem;
        }
        .regio-link { color: var(--lexi-gray); text-decoration: none; font-size: 0.95rem; display: block; padding: 4px 0; }
    </style>

    <div class="card border-0">
        <div class="card-body">
            <div class="container py-5">
    <div class="row mb-5">
        <div class="col-lg-10 editorial-content">
            <span class="meta-label">Methodologie</span>
            <h1 class="fw-bold color-green">De Vlaamse dialectregio’s</h1>
            <p class="mb-0">Het Vlaamse Woordenboek is in de eerste plaats een verzameling van woorden en uitdrukkingen die in heel Vlaanderen bekend en gebruikelijk zijn. Als die het label <strong>‘Belgisch-Nederlands’</strong> (in woordenboeken als Van Dale) of <strong>‘standaardtaal in België’</strong> (op Taaladvies.net en bij Team Taaladvies van de Vlaamse overheid) krijgen, beschouwen wij ze als standaard Belgisch-Nederlands. Als ze dat label niet hebben, beschouwen wij ze ondanks hun ruime verspreiding ook niet als ‘standaardtaal’. Meestal zijn het woorden of uitdrukkingen die vooral in de gesproken taal gangbaar zijn.</p>
        </div>
    </div>


    <div class="row g-5">
        <div class="col-lg-7 editorial-content">
            <p>Daarnaast zijn er heel wat woorden waarvan gebruikers denken dat ze algemeen zijn, terwijl ze maar in een deel van Vlaanderen voorkomen. Of waarvan algemeen geweten is dat hun gebruik geografisch beperkt is, maar die te mooi zijn om te laten liggen. Hoewel het Vlaams Woordenboek geen dialectwoordenboek is in de strikte zin van het woord, verdienen ook die woorden en uitdrukkingen een plaatsje in het woordenboek. Die woorden krijgen een of meerdere <strong>regiolabels</strong>, zodat gebruikers weten in welke regio ze thuishoren. De lijst met regiolabels, gebaseerd op een indeling uit de dialectologie, staat hieronder.</p>

            <p>We willen wel nog eens benadrukken dat het Vlaams Woordenboek <strong>géén dialectwoordenboek</strong> is. Dialectwoorden blijven de uitzondering op de regel. Er moet een goede reden zijn om zo'n woord op te nemen. Onze rijke en mooie dialectwoordenschat wordt immers al in tal van andere bronnen beschreven.</p>

            <span class="meta-label mt-5">Regio overzicht</span>
            <h4 class="fw-bold color-green pb-2">De regiolijst die we hanteren</h4>
            <p>blabla dit is shit</p>

            <div class="row mt-4">
                <div class="col-md-6">
                    <span class="province-tag">Provincie West-Vlaanderen</span>
                    <span class="regio-link"><x-heroicon-o-map class="icon color-green me-1"/> Westelijk West-Vlaanderen</span>
                    <a href="#" class="regio-link">Noord-West-Vlaanderen</a>
                    <a href="#" class="regio-link">Binnen-West-Vlaanderen</a>
                </div>
                <div class="col-md-6">
                    <span class="province-tag">Brabant & Limburg</span>
                    <a href="#" class="regio-link">Zuid-Brabant</a>
                    <a href="#" class="regio-link">Kempen</a>
                    <a href="#" class="regio-link">West-Limburg</a>
                    <a href="#" class="regio-link">Noord-West-Vlaanderen</a>
                    <a href="#" class="regio-link">Binnen-West-Vlaanderen</a>
                </div>
                <div class="col-md-6">
                    <span class="province-tag">West-Vlaanderen</span>
                    <a href="#" class="regio-link">Westelijk West-Vlaanderen</a>
                    <a href="#" class="regio-link">Noord-West-Vlaanderen</a>
                    <a href="#" class="regio-link">Binnen-West-Vlaanderen</a>
                </div>
                <div class="col-md-6">
                    <span class="province-tag">Brabant & Limburg</span>
                    <a href="#" class="regio-link">Zuid-Brabant</a>
                    <a href="#" class="regio-link">Kempen</a>
                    <a href="#" class="regio-link">West-Limburg</a>
                </div>
                <div class="col-md-6">
                    <span class="province-tag">West-Vlaanderen</span>
                    <a href="#" class="regio-link">Westelijk West-Vlaanderen</a>
                    <a href="#" class="regio-link">Noord-West-Vlaanderen</a>
                    <a href="#" class="regio-link">Binnen-West-Vlaanderen</a>
                </div>
                <div class="col-md-6">
                    <span class="province-tag">Brabant & Limburg</span>
                    <a href="#" class="regio-link">Zuid-Brabant</a>
                    <a href="#" class="regio-link">Kempen</a>
                    <a href="#" class="regio-link">West-Limburg</a>
                </div>
            </div>
        </div>

        <aside class="col-lg-5">
            <div class="p-4 border-start border-dark border-2 bg-white">
                <span class="meta-label">Externe Bronnen</span>
                <p class="small text-muted mb-4">Zo hebben veel dorpen en steden intussen een eigen woordenboek. Een groot deel daarvan is online te vinden:</p>
                <ul class="list-unstyled small">
                    <li class="mb-2"><a href="https://www.dialectloket.be" class="text-dark fw-bold">Woordenbank van het Dialectloket</a></li>
                    <li class="mb-2"><a href="#" class="text-dark fw-bold">Database van de Zuidelijk Nederlandse Dialecten (INT)</a></li>
                    <li><a href="https://www.mijnwoordenboek.nl/dialecten/" class="text-dark fw-bold">MijnWoordenboek: Stel zelf dialectwoorden voor</a></li>
                </ul>
            </div>

            <a href="#" target="_blank" class="lexi-result-card">
                <div class="card-meta">
                    <span>Onderzoek</span>
                    <span class="text-dark">Instituut NT</span>
                </div>
                <span class="card-title">Database ZND</span>
                <p class="card-body-text">De Database van de Zuidelijk Nederlandse Dialecten biedt wetenschappelijke diepgang in de dialectologie.</p>
                <div class="card-footer-cta">
                    Raadpleeg archief <i class="bi bi-arrow-up-right"></i>
                </div>
            </a>
        </aside>
    </div>
</div>

<script>
    /**
     * @function findRegio
     * @description Matches postal code to dialect region and displays result card
     */
    function findRegio() {
        const query = document.getElementById('postcode-search').value;
        const card = document.getElementById('result-card');

        // Mock data voor demonstratie
        const regions = {
            "2000": { town: "Antwerpen", region: "Antwerpen / Stad" },
            "8000": { town: "Brugge", region: "Noord-West-Vlaanderen" },
            "9000": { town: "Gent", region: "Oost-Vlaanderen" },
            "2300": { town: "Turnhout", region: "Kempen" },
            "3500": { town: "Hasselt", region: "West-Limburg" }
        };

        const match = regions[query];

        if (match) {
            document.getElementById('result-town').innerText = match.town + " (" + query + ")";
            document.getElementById('result-region').innerText = match.region;
            card.style.display = 'block';
        } else {
            alert("Deze postcode is niet opgenomen in de demo-dataset. Probeer 2000, 8000, 9000, 2300 of 3500.");
            card.style.display = 'none';
        }
    }
</script>
        </div>
    </div>
@endsection

@section('scripts')
 <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
     integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
     crossorigin=""></script>
<style>
    .leaflet-tile { border-color: transparent; }
.leaflet-container path.leaflet-interactive:focus:not(:focus-visible) {
  outline: 0;
}
</style>

<script>
        // Initialize the map
        var map = L.map('map', {
}).setView([50.8503, 4.3517], 8); // Set initial view (approx. Brussels center)

        // Add a base tile layer (e.g., OpenStreetMap)
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 12,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        // URL of your Laravel API endpoint
        const geoApiUrl = '/api/geo-data'; // Adjust if your API path is different

        // Fetch the GeoJSON data from the backend
        fetch(geoApiUrl)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json(); // Parse the JSON response
            })
            .then(geojsonData => {
                // Data fetched successfully, add it to the map
                if (geojsonData && geojsonData.type === "FeatureCollection") {
                    function getColor(d) {
                        return d == 3 ? '#059669' :
                            d == 4  ? '#4F46E5' :
                            d == 5  ? '#7C3AED' :
                            d == 6  ? '#FC4E2A' :
                            d == 7   ? '#FD8D3C' :
                            d == 8   ? '#93C5FD' :
                            d == 9   ? '#831843' :
                            d == 10 ? '#5C4033' :
                            d == 11 ? '	#5E5820' :
                            d == 12 ? '	#3A4C7A' :
                            d == 13 ? '	#519' :
                            d == 14 ? '	#475' :
                            d == 15 ? '	#F40' :
                            d == 16 ? '#5E3' :
                            d == 17 ? '#033' :
                            d == 18 ? '#000' :
                            d == 19 ? '	#580F1A' :
                                        '#FFEDA0';
}

                     var geojsonLayer = L.geoJSON(geojsonData, {
                        // Optional: Style the polygon
                        style: function (feature) {
                            return {
                                color: getColor(feature.properties.region_id), // Border color (blue)
                                weight: 1,         // Border thickness
                                opacity: 1,      // Border opacity
                                fillColor: getColor(feature.properties.region_id), // Fill color (blue)
                                fillOpacity: 0.1   // Fill opacity
                            };
                        },
                        // Optional: Add popups or other interactions
                        onEachFeature: function (feature, layer) {
                                layer.bindPopup("<strong>Gemeente(s):</strong><br>" + feature.properties.name + "<br><br><strong>Taalkundige regio: </strong><br>" + feature.properties.region_name)


                        }
                    }).addTo(map);

                    // Optional: Fit the map view to the bounds of the GeoJSON layer
                    map.fitBounds(geojsonLayer.getBounds());

                } else {
                     console.error("Invalid GeoJSON data received:", geojsonData);
                }
            })
            .catch(error => {
                console.error("Error fetching geo data:", error);
            });

    </script>
@endsection

@section('scripts')
 <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
     integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
     crossorigin=""></script>
<style>
    .leaflet-tile { border-color: transparent; }
.leaflet-container path.leaflet-interactive:focus:not(:focus-visible) {
  outline: 0;
}
</style>

<script>
        // Initialize the map
        var map = L.map('map', {
}).setView([50.8503, 4.3517], 8); // Set initial view (approx. Brussels center)

        // Add a base tile layer (e.g., OpenStreetMap)
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 12,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        // URL of your Laravel API endpoint
        const geoApiUrl = '/api/geo-data'; // Adjust if your API path is different

        // Fetch the GeoJSON data from the backend
        fetch(geoApiUrl)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json(); // Parse the JSON response
            })
            .then(geojsonData => {
                // Data fetched successfully, add it to the map
                if (geojsonData && geojsonData.type === "FeatureCollection") {
                    function getColor(d) {
                        return d == 3 ? '#059669' :
                            d == 4  ? '#4F46E5' :
                            d == 5  ? '#7C3AED' :
                            d == 6  ? '#FC4E2A' :
                            d == 7   ? '#FD8D3C' :
                            d == 8   ? '#93C5FD' :
                            d == 9   ? '#831843' :
                            d == 10 ? '#5C4033' :
                            d == 11 ? '	#5E5820' :
                            d == 12 ? '	#3A4C7A' :
                            d == 13 ? '	#519' :
                            d == 14 ? '	#475' :
                            d == 15 ? '	#F40' :
                            d == 16 ? '#5E3' :
                            d == 17 ? '#033' :
                            d == 18 ? '#000' :
                            d == 19 ? '	#580F1A' :
                                        '#FFEDA0';
}

                     var geojsonLayer = L.geoJSON(geojsonData, {
                        // Optional: Style the polygon
                        style: function (feature) {
                            return {
                                color: getColor(feature.properties.region_id), // Border color (blue)
                                weight: 1,         // Border thickness
                                opacity: 1,      // Border opacity
                                fillColor: getColor(feature.properties.region_id), // Fill color (blue)
                                fillOpacity: 0.1   // Fill opacity
                            };
                        },
                        // Optional: Add popups or other interactions
                        onEachFeature: function (feature, layer) {
                                layer.bindPopup("<strong>Gemeente(s):</strong><br>" + feature.properties.name + "<br><br><strong>Taalkundige regio: </strong><br>" + feature.properties.region_name)


                        }
                    }).addTo(map);

                    // Optional: Fit the map view to the bounds of the GeoJSON layer
                    map.fitBounds(geojsonLayer.getBounds());

                } else {
                     console.error("Invalid GeoJSON data received:", geojsonData);
                }
            })
            .catch(error => {
                console.error("Error fetching geo data:", error);
            });

    </script>
@endsection
