let map;
let markers = [];
let markerCluster;
let directionsService;
let directionsRenderer;

async function initMap() {
    // Initial Map Center (Temanggung coordinates)
    const temanggung = { lat: -7.319561, lng: 110.169434 };
    
    // Custom Map Style to hide POIs
    const mapStyles = [
        {
            featureType: "poi",
            elementType: "labels",
            stylers: [{ visibility: "off" }]
        },
        {
            featureType: "transit",
            elementType: "labels",
            stylers: [{ visibility: "off" }]
        }
    ];

    map = new google.maps.Map(document.getElementById("map"), {
        zoom: 12,
        center: temanggung,
        mapTypeId: "roadmap",
        styles: mapStyles,
        disableDefaultUI: false,
        zoomControl: true,
        mapTypeControl: false,
        streetViewControl: false,
        fullscreenControl: false
    });

    directionsService = new google.maps.DirectionsService();
    directionsRenderer = new google.maps.DirectionsRenderer();
    directionsRenderer.setMap(map);

    // Setup Search Box
    setupSearch();

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
        
        const infoWindow = new google.maps.InfoWindow({
            maxWidth: 320,
            pixelOffset: new google.maps.Size(0, -10)
        });
        
        umkms.forEach(umkm => {
            const position = { 
                lat: parseFloat(umkm.latitude), 
                lng: parseFloat(umkm.longitude) 
            };
            
            // Create SVG Marker based on color - Enlarged and Restyled
            const svgMarker = {
                path: "M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z",
                fillColor: umkm.category.color ?? "#ff9800",
                fillOpacity: 1,
                strokeWeight: 2,
                strokeColor: "#FFFFFF",
                rotation: 0,
                scale: 2.5,
                anchor: new google.maps.Point(12, 22),
                labelOrigin: new google.maps.Point(12, -10), // Positioning the label above the marker
            };

            const marker = new google.maps.Marker({
                position: position,
                map: map,
                icon: svgMarker,
                title: umkm.business_name,
                animation: google.maps.Animation.DROP,
                label: {
                    text: umkm.business_name,
                    color: "#000000",
                    fontSize: "12px",
                    fontWeight: "900",
                    className: "marker-label" // For custom CSS if needed
                }
            });
            
            marker.umkmData = umkm;

            // Redesigned InfoWindow content to match catalog card
            const contentString = `
                <div class="umkm-popup-card overflow-hidden rounded-[25px] bg-white shadow-xl border border-gray-100 font-sans" style="width: 280px;">
                    <div class="relative h-32 overflow-hidden">
                        <img src="${umkm.photo ? '/storage/'+umkm.photo : 'https://placehold.co/400x250?text='+encodeURIComponent(umkm.business_name)}" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                        <span class="absolute top-3 left-3 px-2 py-1 bg-white/90 text-[8px] font-black rounded-lg uppercase tracking-widest text-gray-800 shadow-sm border border-white">
                            ${umkm.category.name}
                        </span>
                    </div>
                    <div class="p-4">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center text-amber-500 text-[10px] font-black">
                                <i class="fas fa-star mr-1"></i>
                                <span class="text-gray-900">${umkm.avg_rating || '5.0'}</span>
                            </div>
                            <span class="text-gray-400 text-[8px] uppercase font-black tracking-widest">Produk Unggulan</span>
                        </div>
                        <h3 class="text-base font-black mb-1 leading-tight text-gray-900 truncate">${umkm.business_name}</h3>
                        <p class="text-gray-500 text-[10px] line-clamp-2 italic mb-4 font-medium leading-relaxed">"${umkm.description || 'Kopi terbaik dari Temanggung untuk dunia.'}"</p>
                        
                        <div class="flex items-center space-x-2 pt-3 border-t border-gray-50">
                            <a href="/katalog/umkm/${umkm.slug}" class="flex-1 text-center py-2.5 rounded-xl font-black text-[10px] uppercase tracking-widest bg-gray-900 text-white hover:bg-amber-600 transition duration-300 no-underline">
                                PROFIL
                            </a>
                            <a href="https://www.google.com/maps/dir/?api=1&destination=${umkm.latitude},${umkm.longitude}" target="_blank" class="w-10 h-10 rounded-xl bg-gray-100 text-gray-500 flex items-center justify-center hover:text-amber-600 hover:bg-amber-50 transition duration-300 no-underline" title="Navigasi">
                                <i class="fas fa-location-dot text-sm"></i>
                            </a>
                        </div>
                    </div>
                </div>
            `;

            marker.addListener("click", () => {
                infoWindow.setContent(contentString);
                infoWindow.open(map, marker);
            });

            markers.push(marker);
        });
        
        // Disable Marker Clusterer as requested (markers will stay individual)
        // markerCluster = new markerClusterer.MarkerClusterer({ map, markers });
        
    } catch (error) {
        console.error("Error fetching UMKM data:", error);
    }
}

// Improved Search functionality to handle UMKM names as well
function setupSearch() {
    const input = document.getElementById("pac-input");
    const searchBox = new google.maps.places.SearchBox(input);
    
    searchBox.addListener("places_changed", () => {
        const places = searchBox.getPlaces();
        const searchText = input.value.toLowerCase();

        // 1. Check for local UMKM matches first
        const matchedUMKM = markers.find(m => 
            m.umkmData.business_name.toLowerCase().includes(searchText)
        );

        if (matchedUMKM) {
            map.setCenter(matchedUMKM.getPosition());
            map.setZoom(17);
            google.maps.event.trigger(matchedUMKM, 'click');
            return;
        }

        // 2. Fallback to Google Places search
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
        if (map.getZoom() > 16) map.setZoom(16);
    });
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

