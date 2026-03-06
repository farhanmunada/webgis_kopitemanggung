let map;
let markers = [];
let markerCluster;
let directionsService;
let directionsRenderer;

async function initMap() {
    // Initial Map Center (Temanggung coordinates)
    const temanggung = { lat: -7.319561, lng: 110.169434 };
    
    map = new google.maps.Map(document.getElementById("map"), {
        zoom: 12,
        center: temanggung,
        mapTypeId: "roadmap",
    });

    directionsService = new google.maps.DirectionsService();
    directionsRenderer = new google.maps.DirectionsRenderer();
    directionsRenderer.setMap(map);

    // Setup Search Box
    const input = document.getElementById("pac-input");
    const searchBox = new google.maps.places.SearchBox(input);
    
    searchBox.addListener("places_changed", () => {
        const places = searchBox.getPlaces();
        if (places.length == 0) {
            return;
        }
        
        const bounds = new google.maps.LatLngBounds();
        places.forEach((place) => {
            if (!place.geometry || !place.geometry.location) return;
            if (place.geometry.viewport) {
                bounds.union(place.geometry.viewport);
            } else {
                bounds.extend(place.geometry.location);
            }
        });
        map.fitBounds(bounds);
        map.setZoom(16);
    });

    // Fetch UMKM Data
    await loadUMKMMarkers();
    
    // Setup Filter Buttons
    document.querySelectorAll('.filter-btn').forEach(button => {
        button.addEventListener('click', (e) => {
            e.preventDefault();
            const categoryId = e.target.getAttribute('data-category');
            
            // Toggle active state
            e.target.classList.toggle('opacity-50');
            const isActive = !e.target.classList.contains('opacity-50');
            
            // Filter markers
            markers.forEach(marker => {
                if (marker.umkmData.category_id == categoryId) {
                    marker.setVisible(isActive);
                }
            });
            
            // Update clusterer
            const visibleMarkers = markers.filter(m => m.getVisible());
            markerCluster.clearMarkers();
            markerCluster.addMarkers(visibleMarkers);
        });
    });
}

async function loadUMKMMarkers() {
    try {
        const response = await fetch('/api/umkm');
        const umkms = await response.json();
        
        const infoWindow = new google.maps.InfoWindow({maxWidth: 280});
        
        umkms.forEach(umkm => {
            const position = { 
                lat: parseFloat(umkm.latitude), 
                lng: parseFloat(umkm.longitude) 
            };
            
            // Create SVG Marker based on color
            const svgMarker = {
                path: "M10.453 14.016l6.563-6.609-1.406-1.406-5.156 5.203-2.063-2.109-1.406 1.406zM12 2.016q2.906 0 4.945 2.039t2.039 4.945q0 1.453-0.727 3.328t-1.758 3.516-2.039 3.070-1.711 2.273l-0.75 0.797q-0.281-0.328-0.75-0.867t-1.688-2.156-2.133-3.141-1.664-3.445-0.75-3.375q0-2.906 2.039-4.945t4.945-2.039z",
                fillColor: umkm.category.color ?? "#000000",
                fillOpacity: 1,
                strokeWeight: 1,
                strokeColor: "#FFFFFF",
                rotation: 0,
                scale: 1.5,
                anchor: new google.maps.Point(12, 24),
            };

            const marker = new google.maps.Marker({
                position: position,
                map: map,
                icon: svgMarker,
                title: umkm.business_name
            });
            
            marker.umkmData = umkm;

            // InfoWindow content
            const contentString = `
                <div class="p-2">
                    <div class="flex items-center space-x-3 mb-2">
                        <img src="${umkm.photo ? '/storage/'+umkm.photo : 'https://placehold.co/60x60?text=Kopi'}" class="w-16 h-16 rounded-md object-cover" />
                        <div>
                            <h3 class="font-bold text-lg leading-tight mb-1">${umkm.business_name}</h3>
                            <span class="inline-block px-2 py-1 text-xs font-semibold text-white rounded bg-gray-600 shadow-sm" style="background-color: ${umkm.category.color}">${umkm.category.name}</span>
                        </div>
                    </div>
                    <p class="text-xs text-gray-600 mb-1 flex items-start"><span class="mr-1">📍</span> ${umkm.address}</p>
                    <p class="text-sm font-bold text-yellow-500 mb-3">★ ${umkm.avg_rating} / 5.0</p>
                    <div class="flex flex-col space-y-2">
                        <a href="/umkm/${umkm.slug}" class="bg-blue-600 text-white px-3 py-1.5 rounded text-sm hover:bg-blue-700 w-full text-center transition shadow-sm font-medium">Lihat Detail</a>
                        <button onclick="getRouteTo(${umkm.latitude}, ${umkm.longitude})" class="bg-green-600 text-white px-3 py-1.5 rounded text-sm hover:bg-green-700 w-full text-center transition shadow-sm font-medium flex justify-center items-center"><span class="mr-1">🧭</span> Get Route</button>
                    </div>
                </div>
            `;

            marker.addListener("click", () => {
                infoWindow.setContent(contentString);
                infoWindow.open(map, marker);
            });

            markers.push(marker);
        });
        
        // Add Marker Clusterer
        markerCluster = new markerClusterer.MarkerClusterer({ map, markers });
        
    } catch (error) {
        console.error("Error fetching UMKM data:", error);
    }
}

window.getRouteTo = function(destLat, destLng) {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            (position) => {
                const origin = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude,
                };
                
                const request = {
                    origin: origin,
                    destination: { lat: destLat, lng: destLng },
                    travelMode: google.maps.TravelMode.DRIVING
                };
                
                directionsService.route(request, (result, status) => {
                    if (status == 'OK') {
                        directionsRenderer.setDirections(result);
                    } else {
                        alert("Gagal memuat rute: " + status);
                    }
                });
            },
            () => {
                alert("Error: Layanan Geolocation gagal atau tidak diizinkan.");
            }
        );
    } else {
        alert("Browser Anda tidak mendukung Geolocation.");
    }
};

window.initMap = initMap;
