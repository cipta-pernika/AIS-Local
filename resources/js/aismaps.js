export default function leafletAISMaps() {
    let markerClusterEnabled = false;
    let markers;
    return {
        init: async function () {
            console.log("start leafletAISMaps");
            const map = L.map(this.$refs.map.id).setView([51.505, -0.09], 13);

            const tiles = L.tileLayer
                .provider("OpenStreetMap.Mapnik")
                .addTo(map);

            // Add individual markers to the marker cluster group
            const marker1 = L.marker([51.505, -0.09]).bindPopup("Marker 1");
            const marker2 = L.marker([51.51, -0.1], {
                icon: L.AwesomeMarkers.icon({
                    icon: "coffee",
                    markerColor: "green",
                    prefix: "fa",
                }),
            }).bindPopup("Marker 2");
            const marker3 = L.marker([51.52, -0.08]).bindPopup("Marker 3");

            // Add markers to a feature group (not clustering by default)
            markers = L.featureGroup([marker1, marker2, marker3]);

            // Add the feature group to the map
            map.addLayer(markers);

            // Fetch AIS data from the API
            try {
                const response = await axios.get(
                    "https://ksop.cakrawala.id/api/aisdataunique"
                );
                const aisData = response.data.message;

                // Iterate through AIS data and create markers
                aisData.forEach((aisItem) => {
                    const marker = L.marker([
                        aisItem.latitude,
                        aisItem.longitude,
                    ]).bindPopup(`AIS Data: ${JSON.stringify(aisItem)}`);

                    // Check if inside geofence
                    if (aisItem.is_inside_geofence === 1) {
                        // Blinking effect using Leaflet Pulse
                        const pulsingIcon = L.icon.pulse({
                            iconSize: [10, 10],
                            color: "red",
                            fillColor: "red",
                            animate: true,
                            pulseColor: "red",
                        });
                        marker.setIcon(pulsingIcon);
                    }

                    markers.addLayer(marker);
                });

                // Add the marker cluster group to the map
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

            // Add Leaflet Sidebar
            const sidebar = L.control
                .sidebar({
                    autopan: false,
                    closeButton: true,
                    container: "sidebar",
                    position: "left",
                })
                .addTo(map);

            // Event handler for marker3 click to show sidebar
            marker3.on("click", function () {
                sidebar.open("marker3Content"); // Open the specific content with ID 'marker3Content'
            });

            // Add a panel to the sidebar
            sidebar.addPanel({
                id: "marker3Content",
                tab: '<i class="fa fa-info"></i>',
                pane: `<h1>Marker 3 Content</h1>
                       <button id="toggleMarkerCluster">Toggle Marker Cluster</button>
                       <p>This is some content for Marker 3.</p>`,
                title: "Marker 3 Information",
                position: "top",
            });

            // Event handler for the button to toggle Marker Cluster
            document
                .getElementById("toggleMarkerCluster")
                .addEventListener("click", function () {
                    markerClusterEnabled = !markerClusterEnabled; // Toggle the state

                    if (markerClusterEnabled) {
                        // Enable Marker Cluster
                        map.removeLayer(markers); // Remove individual markers
                        markers = L.markerClusterGroup(); // Create a new marker cluster group
                        map.addLayer(markers); // Add the new marker cluster group to the map
                        markers.addLayer(
                            L.featureGroup([marker1, marker2, marker3])
                        ); // Add individual markers to the cluster group
                    } else {
                        // Disable Marker Cluster
                        map.removeLayer(markers); // Remove the marker cluster group
                        markers = L.featureGroup([marker1, marker2, marker3]); // Create a new feature group with individual markers
                        map.addLayer(markers); // Add individual markers to the map
                    }
                });
        },
    };
}
