<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 px-6 py-8">
    <div class="max-w-full mx-auto h-[calc(100vh-100px)] flex flex-col">
        <div class="flex justify-between items-center mb-6">
             <h3 class="text-3xl font-bold text-gray-800">Live Tracking Armada</h3>
             <div class="flex space-x-2">
                 <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                    <span class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></span> Live Update
                 </span>
             </div>
        </div>

        <!-- Map Container -->
        <div class="flex-1 bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden relative">
            <div id="map" class="h-full w-full z-0"></div>
            
            <!-- Driver List Overlay -->
            <div class="absolute top-4 right-4 w-64 bg-white/90 backdrop-blur rounded-lg shadow-xl p-4 z-10 max-h-96 overflow-y-auto hidden md:block">
                <h4 class="font-bold text-gray-700 mb-3 text-sm uppercase tracking-wide">Driver Aktif</h4>
                <div id="driver-list" class="space-y-3">
                    <p class="text-xs text-gray-500 text-center">Memuat driver...</p>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Leaflet CSS & JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<script>
    // Initialize Map
    var map = L.map('map').setView([-7.0, 110.0], 8); // Central Java

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    const driverList = document.getElementById('driver-list');
    let markers = {}; 

    function updateLocations() {
        console.log("Fetching locations...");
        fetch('<?= base_url('admin/get_locations_api') ?>')
            .then(response => response.json())
            .then(data => {
                renderDrivers(data);
            })
            .catch(err => console.error("Error fetching locations:", err));
    }

    function renderDrivers(drivers) {
        // Clear list
        driverList.innerHTML = '';

        if(drivers.length === 0) {
            driverList.innerHTML = '<p class="text-xs text-gray-400 text-center italic">Belum ada driver aktif...</p>';
            return;
        }

        drivers.forEach(d => {
            // Safe fallback
            const name = d.name || 'Unknown';
            const plat = d.plat_nomor || 'No Armada';
            const hasLocation = d.latitude != null && d.longitude != null;
            const lat = hasLocation ? parseFloat(d.latitude) : 0;
            const lng = hasLocation ? parseFloat(d.longitude) : 0;
            const initial = name.charAt(0).toUpperCase();

            // 1. Update List Item
            const item = document.createElement('div');
            item.className = "flex items-center space-x-3 p-3 bg-white border border-gray-100 rounded-xl shadow-sm cursor-pointer hover:bg-gray-50 transition-colors";
            
            if (hasLocation) {
                item.onclick = () => {
                    map.flyTo([lat, lng], 15);
                    if(markers[d.name]) markers[d.name].openPopup();
                };
            }
            
            let statusBadge = '';
            if (!hasLocation) {
                 statusBadge = `<span class="text-[10px] font-bold text-red-500 bg-red-100 px-2 py-0.5 rounded ml-2">No Loc</span>`;
            }

            item.innerHTML = `
                <div class="flex-shrink-0 h-10 w-10 rounded-full ${hasLocation ? 'bg-indigo-600' : 'bg-gray-400'} flex items-center justify-center text-white font-bold text-lg shadow-md">
                    ${initial}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-gray-900 truncate flex items-center">
                        ${name} ${statusBadge}
                    </p>
                    <p class="text-xs font-semibold text-gray-500 mt-1 bg-gray-100 inline-block px-2 py-0.5 rounded uppercase tracking-wider">
                        ${plat}
                    </p>
                </div>
            `;
            driverList.appendChild(item);

            // 2. Update Map Markers
            if (hasLocation) {
                const popupContent = `
                    <div class="text-center">
                        <div class="font-bold text-indigo-700 text-lg">${name}</div>
                        <div class="text-gray-600 font-mono bg-gray-100 px-2 py-1 rounded mt-1 inline-block">${plat}</div>
                        <div class="text-xs text-gray-400 mt-2">Lat: ${lat.toFixed(4)}, Lng: ${lng.toFixed(4)}</div>
                    </div>
                `;

                if (markers[d.name]) {
                    markers[d.name].setLatLng([lat, lng]).setPopupContent(popupContent);
                } else {
                    const marker = L.marker([lat, lng]).addTo(map).bindPopup(popupContent);
                    markers[d.name] = marker;
                }
            } else {
                // Remove marker if it exists but location is now lost (rare case but good cleanup)
                if (markers[d.name]) {
                    map.removeLayer(markers[d.name]);
                    delete markers[d.name];
                }
            }
        });
    }

    // Interval Update
    updateLocations(); // First run
    setInterval(updateLocations, 5000); // Every 5s
</script>
