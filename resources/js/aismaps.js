export default function leafletAISMaps() {
    let markerClusterEnabled = false;
    let markers;
    let map;
    return {
        init: async function () {
            map = L.map(this.$refs.map.id).setView(
                [-1.5499571228201094, 117.89427962462793],
                5.4
            );

            const tiles = L.tileLayer
                .provider("OpenStreetMap.Mapnik")
                .addTo(map);

            // Create a base layers object
            const baseLayers = {
                OpenStreetMap: tiles,
                // Add other base layers here
            };

            // Fetch AIS data from the API and create markers
            try {
                const response = await axios.get(
                    "https://ksop.cakrawala.id/api/aisdataunique"
                );
                const aisData = response.data.message;

                // Create markers or marker cluster based on the initial data
                markers = createMarkers(aisData, markerClusterEnabled);

                // Add the markers or marker cluster to the map
                map.addLayer(markers);
            } catch (error) {
                console.error("Error fetching AIS data:", error);
            }

            map.on("load", function () {});

            // Enable Leaflet-Geoman on the map
            map.pm.setGlobalOptions({ optIn: false }); // Set to false to enable by default

            // Register the Leaflet-Geoman toolbar
            map.pm.addControls({
                position: "topleft",
                drawMarker: false, // Disable drawing markers (use your cluster markers instead)
            });

            L.control.locate().addTo(map);

            L.terminator().addTo(map)

            setInterval(function() {
                terminator.setTime();
            }, 60000); // Every minute

            // Add Leaflet Sidebar
            const sidebar = L.control
                .sidebar({
                    autopan: false,
                    closeButton: true,
                    container: "sidebar",
                    position: "left",
                })
                .addTo(map);

            // Add a panel to the sidebar
            sidebar.addPanel({
                id: "Content",
                tab: '<i class="fa fa-info"></i>',
                pane: `
                       <button id="toggleMarkerCluster">Toggle Marker Cluster</button>`,
                title: "Sidebar",
                position: "top",
            });

            // Create a layer control and add it to the map
            L.control.layers(baseLayers).addTo(map);

            // Event handler for the button to toggle Marker Cluster
            document
                .getElementById("toggleMarkerCluster")
                .addEventListener("click", async function () {
                    markerClusterEnabled = !markerClusterEnabled; // Toggle the state

                    // Remove existing markers or marker cluster
                    map.removeLayer(markers);

                    // Fetch AIS data from the API
                    try {
                        const response = await axios.get(
                            "https://ksop.cakrawala.id/api/aisdataunique"
                        );
                        const aisData = response.data.message;

                        // Recreate markers or marker cluster based on the new data
                        markers = createMarkers(aisData, markerClusterEnabled);

                        // Add the markers or marker cluster to the map
                        map.addLayer(markers);
                    } catch (error) {
                        console.error("Error fetching AIS data:", error);
                    }
                });
        },
    };
}

// Function to create markers or marker cluster based on the data and markerClusterEnabled
function createMarkers(data, markerClusterEnabled) {
    const newMarkers = markerClusterEnabled
        ? L.markerClusterGroup()
        : L.featureGroup();

    data.forEach((aisItem) => {
        const marker = L.marker([
            aisItem.latitude,
            aisItem.longitude,
        ]).bindPopup(`AIS Data: ${JSON.stringify(aisItem)}`);

        if (aisItem.is_inside_geofence === 1) {
            const pulsingIcon = L.icon.pulse({
                iconSize: [10, 10],
                color: "red",
                fillColor: "red",
                animate: true,
                pulseColor: "red",
            });
            marker.setIcon(pulsingIcon);
        }

        newMarkers.addLayer(marker);
    });

    return newMarkers;
}
