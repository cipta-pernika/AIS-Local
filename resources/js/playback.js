export default function leafletAISMaps() {
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

            // Fetch AIS data from the API and create markers
            try {
                const data = {
                    mmsi: "",
                    dateFrom: "2024-01-03",
                    dateTo: "2024-01-04",
                    sensor: ["ais"],
                };
                const playbackResponse = await axios.post(
                    "https://backend.sopbuntutksopbjm.com/api/playback",
                    data
                );
                const playbackData =
                    playbackResponse.data.message.ais[0].playback;

                // Create a TrackPlayback instance
                trackPlayback = L.trackplayback(playbackData, map, {
                    trackPointOptions: {
                        /* Additional options for track points */
                    },
                    markerOptions: {
                        /* Additional options for playback markers */
                    },
                });

                const trackplaybackControl =
                    L.trackplaybackcontrol(trackPlayback);

                trackplaybackControl.addTo(map);

                trackPlayback.start();
            } catch (error) {
                console.error("Error fetching AIS data:", error);
            }

            map.on("load", function () {});

            // Create a layer control and add it to the map
            L.control.layers(baseLayers).addTo(map);

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
