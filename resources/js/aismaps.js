export default function leafletAISMaps() {
    let markerClusterEnabled = false;
    let markers;
    let map;
    let trackPlayback;
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
                "Google Maps": L.tileLayer(
                    "https://mt1.google.com/vt/lyrs=r&x={x}&y={y}&z={z}",
                    {
                        attribution: "Google Maps",
                    }
                ),
            };

            var ts = new L.aisTrackSymbol({});

            ts.addData({
                msgId: 4,
                mmsi: 24422002,
                name: "demo",
                utcYear: 2016,
                utcMon: 11,
                utcDay: 14,
                utcHour: 13,
                utcMin: 40,
                utcSec: 30,
                posAcc: 1,
                longitude: 8.155278333333333,
                latitude: 54.185555,
                devType: 7,
                raim: 0,
                comstate: { syncState: 0, slotTimeout: 2, slotNr: 1150 },
                timestamp: 1479130830744,
            });
            ts.addTo(map);

            // Fetch AIS data from the API and create markers
            try {
                const response = await axios.get(
                    "https://lumensopbuntut.cakrawala.id/api/aisdataunique"
                );
                const aisData = response.data.message;

                // Create markers or marker cluster based on the initial data
                markers = createMarkers(aisData, markerClusterEnabled);

                // Add the markers or marker cluster to the map
                map.addLayer(markers);
            } catch (error) {
                console.error("Error fetching AIS data:", error);
            }

            // Fetch AIS data from the API and create markers
            try {
                const data = {
                    mmsi: "",
                    dateFrom: "2024-01-03",
                    dateTo: "2024-01-04",
                    sensor: ["ais"],
                };
                const playbackResponse = await axios.post(
                    "https://backend.sopbuntutksopbjm.com/api/playback"
                , data);
                const playbackData = playbackResponse.data.message.ais[0].playback;

                // Create a TrackPlayback instance
                trackPlayback = L.trackplayback(playbackData, map, {
                    trackPointOptions: {
                        /* Additional options for track points */
                    },
                    markerOptions: {
                        /* Additional options for playback markers */
                    },
                });

                const trackplaybackControl = L.trackplaybackcontrol(trackPlayback);

    trackplaybackControl.addTo(map);

                trackPlayback.start();
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

            L.terminator().addTo(map);

            setInterval(function () {
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
                       <button id="toggleMarkerCluster">Toggle Marker Cluster</button>
                       <button id="startPlayback">Start Playback</button>
        <button id="stopPlayback">Stop Playback</button>`,
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

            // Event handler to start playback
            document
                .getElementById("startPlayback")
                .addEventListener("click", function () {
                    trackPlayback.start();
                });

            // Event handler to stop playback
            document
                .getElementById("stopPlayback")
                .addEventListener("click", function () {
                    trackPlayback.stop();
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

        // const p1 = [+aisItem.latitude || 0, +aisItem.longitude || 0];
        // const trueHeading1 = aisItem.heading || 0;
        // const cog1 = aisItem.course || 0;
        // const sog1 = +aisItem.speed || 0;

        // // Creating the PositionReport
        // let positionReport1 = {
        //     latitude: p1[0],
        //     longitude: p1[1],
        //     trueHeading: trueHeading1,
        //     cog: cog1,
        //     sog: sog1,
        // };

        // const aisTrackSymbol = new L.aisTrackSymbol(positionReport1, {
        //     shipStaticData: {
        //         userId: aisItem.vessel.id || 0,
        //         imoNumber: aisItem.vessel.imo || 0,
        //         callSign: aisItem.vessel.callsign || "",
        //         name: aisItem.vessel.vessel_name || "",
        //         type: aisItem.vessel.type_number || 0,
        //         dimension: {
        //             A: aisItem.vessel.dimension_to_bow || 0,
        //             B: aisItem.vessel.dimension_to_stern || 0,
        //             C: aisItem.vessel.dimension_to_port || 0,
        //             D: aisItem.vessel.dimension_to_starboard || 0,
        //         },
        //         fixType: aisItem.vessel.out_of_range || 0,
        //         eta: {
        //             month: aisItem.vessel.reported_eta
        //                 ? new Date(aisItem.vessel.reported_eta).getMonth() + 1
        //                 : null,
        //             day: aisItem.vessel.reported_eta
        //                 ? new Date(aisItem.vessel.reported_eta).getDate()
        //                 : null,
        //             hour: aisItem.vessel.reported_eta
        //                 ? new Date(aisItem.vessel.reported_eta).getHours()
        //                 : null,
        //             minute: aisItem.vessel.reported_eta
        //                 ? new Date(aisItem.vessel.reported_eta).getMinutes()
        //                 : null,
        //         },
        //         destination: aisItem.vessel.reported_destination || "",
        //         dte: aisItem.vessel.dte === "1",
        //     },
        // });
        // aisTrackSymbol.bindTooltip(aisItem.vessel.vessel_name || "");
        // aisTrackSymbol.addTo(map);

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
