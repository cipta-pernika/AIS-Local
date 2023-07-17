// eslint-disable-next-line eslint-comments/disable-enable-pair
/* eslint-disable func-names */
// eslint-disable-next-line eslint-comments/disable-enable-pair
/* eslint-disable prefer-rest-params */
// eslint-disable-next-line eslint-comments/disable-enable-pair
/* eslint-disable no-undef */
// eslint-disable-next-line eslint-comments/disable-enable-pair
/* eslint-disable @typescript-eslint/no-unused-expressions */
!(function () {


    L.Icon.Measurement = L.DivIcon.extend({
        initialize(measurement, options) {
            L.Icon.prototype.initialize.call(this, L.extend({
                className: 'leaflet-measure-path-measurement',
                html: measurement,
                iconSize: [50, 18]
            }, options));
        }
    });

    L.icon.measurement = function (measurement, options) {
        return new L.Icon.Measurement(measurement, options);
    };

    L.Marker.Measurement = L.Marker.extend({
        initialize(latLng, measurement, options) {
            const icon = L.icon.measurement(measurement, options);
            L.Marker.prototype.initialize.call(this, latLng, L.extend({
                icon
            }, options));
        },

        _setPos() {
            L.Marker.prototype._setPos.apply(this, arguments);
            if (this.options.rotation) {
                this._icon.style.transform += ` rotate(${this.options.rotation}rad)`;
            }
        }
    });

    L.marker.measurement = function (latLng, measurement, options) {
        return new L.Marker.Measurement(latLng, measurement, options);
    };

    const formatDistance = function (d) {
        let unit;
        let feet;

        if (this._measurementOptions.imperial) {
            feet = d / 0.3048;
            if (feet > 3000) {
                d /= 1609.344;
                unit = 'mi';
            } else {
                d = feet;
                unit = 'ft';
            }
        } else if (d > 1000) {
            d /= 1000;
            unit = 'km';
        } else {
            unit = 'm';
        }

        if (d < 100) {
            return `${d.toFixed(1)} ${unit}`;
        }
        return `${Math.round(d)} ${unit}`;

    }

    const formatArea = function (a) {
        let unit;
        // let sqfeet;

        if (this._measurementOptions.imperial) {
            if (a > 404.685642) {
                a /= 4046.85642;
                unit = 'ac';
            } else {
                a /= 0.09290304;
                unit = 'ft<sup>2</sup>';
            }
        } else if (a > 100000) {
            a /= 100000;
            unit = 'km<sup>2</sup>';
        } else {
            unit = 'm<sup>2</sup>';
        }

        if (a < 100) {
            return `${a.toFixed(1)} ${unit}`;
        }
        return `${Math.round(a)} ${unit}`;

    }

    const RADIUS = 6378137;
    // ringArea function copied from geojson-area
    // (https://github.com/mapbox/geojson-area)
    // This function is distributed under a separate license,
    // see LICENSE.md.
    const ringArea = function ringArea(coords) {
        const rad = function rad(_) {
            return _ * Math.PI / 180;
        };
        let p1; let p2; let p3; let lowerIndex; let middleIndex; let upperIndex;
        let area = 0;
        const coordsLength = coords.length;

        if (coordsLength > 2) {
            for (let i = 0; i < coordsLength; i++) {
                if (i === coordsLength - 2) {// i = N-2
                    lowerIndex = coordsLength - 2;
                    middleIndex = coordsLength - 1;
                    upperIndex = 0;
                } else if (i === coordsLength - 1) {// i = N-1
                    lowerIndex = coordsLength - 1;
                    middleIndex = 0;
                    upperIndex = 1;
                } else { // i = 0 to N-3
                    lowerIndex = i;
                    middleIndex = i + 1;
                    upperIndex = i + 2;
                }
                p1 = coords[lowerIndex];
                p2 = coords[middleIndex];
                p3 = coords[upperIndex];
                area += (rad(p3.lng) - rad(p1.lng)) * Math.sin(rad(p2.lat));
            }

            area = area * RADIUS * RADIUS / 2;
        }

        return Math.abs(area);
    };

    const circleArea = function circleArea(d) {
        const rho = d / RADIUS;
        return 2 * Math.PI * RADIUS * RADIUS * (1 - Math.cos(rho));
    };

    const override = function (method, fn, hookAfter) {
        if (!hookAfter) {
            return function () {
                method.apply(this, arguments);
                fn.apply(this, arguments);
            }
        }
        return function () {
            fn.apply(this, arguments);
            method.apply(this, arguments);
        }

    };

    L.Polyline.include({
        showMeasurements(options) {
            if (!this._map || this._measurementLayer) return this;

            this._measurementOptions = L.extend({
                showOnHover: false,
                minPixelDistance: 30,
                showDistances: true,
                showArea: true,
                lang: {
                    totalLength: 'Total length',
                    totalArea: 'Total area',
                    segmentLength: 'Segment length'
                }
            }, options || {});

            this._measurementLayer = L.layerGroup().addTo(this._map);
            this.updateMeasurements();

            this._map.on('zoomend', this.updateMeasurements, this);

            return this;
        },

        hideMeasurements() {
            this._map.off('zoomend', this.updateMeasurements, this);

            if (!this._measurementLayer) return this;
            this._map.removeLayer(this._measurementLayer);
            this._measurementLayer = null;

            return this;
        },

        onAdd: override(L.Polyline.prototype.onAdd, function () {
            if (this.options.showMeasurements) {
                this.showMeasurements(this.options.measurementOptions);
            }
        }),

        onRemove: override(L.Polyline.prototype.onRemove, function () {
            this.hideMeasurements();
        }, true),

        setLatLngs: override(L.Polyline.prototype.setLatLngs, function () {
            this.updateMeasurements();
        }),

        spliceLatLngs: override(L.Polyline.prototype.spliceLatLngs, function () {
            this.updateMeasurements();
        }),

        formatDistance,
        formatArea,

        updateMeasurements() {
            if (!this._measurementLayer) return;

            const latLngs = this.getLatLngs();
            const isPolygon = this instanceof L.Polygon;
            const options = this._measurementOptions;
            let totalDist = 0;
            let formatter;
            let ll1;
            let ll2;
            let pixelDist;
            let dist;

            this._measurementLayer.clearLayers();

            if (this._measurementOptions.showDistances && latLngs.length > 1) {
                formatter = this._measurementOptions.formatDistance || L.bind(this.formatDistance, this);

                for (let i = 1, len = latLngs.length; (isPolygon && i <= len) || i < len; i++) {
                    ll1 = latLngs[i - 1];
                    ll2 = latLngs[i % len];
                    dist = ll1.distanceTo(ll2);
                    totalDist += dist;

                    pixelDist = this._map.latLngToLayerPoint(ll1).distanceTo(this._map.latLngToLayerPoint(ll2));

                    if (pixelDist >= options.minPixelDistance) {
                        L.marker.measurement(
                            [(ll1.lat + ll2.lat) / 2, (ll1.lng + ll2.lng) / 2],
                            `<span title="${options.lang.segmentLength}">${formatter(dist)}</span>`,
                            L.extend({}, options, { rotation: this._getRotation(ll1, ll2) }))
                            .addTo(this._measurementLayer);
                    }
                }

                // Show total length for polylines
                if (!isPolygon) {
                    L.marker.measurement(ll2, `<strong title="${options.lang.totalLength}">${formatter(totalDist)}</strong>`, options)
                        .addTo(this._measurementLayer);
                }
            }

            if (isPolygon && options.showArea && latLngs.length > 2) {
                formatter = options.formatArea || L.bind(this.formatArea, this);
                const area = ringArea(latLngs);
                L.marker.measurement(this.getBounds().getCenter(),
                    `<span title="${options.lang.totalArea}">${formatter(area)}</span>`, options)
                    .addTo(this._measurementLayer);
            }
        },

        _getRotation(ll1, ll2) {
            const p1 = this._map.project(ll1);
            const p2 = this._map.project(ll2);

            return Math.atan((p2.y - p1.y) / (p2.x - p1.x));
        }
    });

    L.Polyline.addInitHook(function () {
        if (this.options.showMeasurements) {
            this.showMeasurements();
        }
    });

    L.Circle.include({
        showMeasurements(options) {
            if (!this._map || this._measurementLayer) return this;

            this._measurementOptions = L.extend({
                showOnHover: false,
                showArea: true
            }, options || {});

            this._measurementLayer = L.layerGroup().addTo(this._map);
            this.updateMeasurements();

            this._map.on('zoomend', this.updateMeasurements, this);

            return this;
        },

        hideMeasurements() {
            this._map.on('zoomend', this.updateMeasurements, this);

            if (!this._measurementLayer) return this;
            this._map.removeLayer(this._measurementLayer);
            this._measurementLayer = null;

            return this;
        },

        onAdd: override(L.Circle.prototype.onAdd, function () {
            if (this.options.showMeasurements) {
                this.showMeasurements(this.options.measurementOptions);
            }
        }),

        onRemove: override(L.Circle.prototype.onRemove, function () {
            this.hideMeasurements();
        }, true),

        setLatLng: override(L.Circle.prototype.setLatLng, function () {
            this.updateMeasurements();
        }),

        setRadius: override(L.Circle.prototype.setRadius, function () {
            this.updateMeasurements();
        }),

        formatArea,

        updateMeasurements() {
            if (!this._measurementLayer) return;

            const latLng = this.getLatLng();
            const options = this._measurementOptions;
            let formatter = options.formatDistance || L.bind(this.formatDistance, this);

            this._measurementLayer.clearLayers();

            if (options.showArea) {
                formatter = options.formatArea || L.bind(this.formatArea, this);
                const area = circleArea(this.getRadius());
                L.marker.measurement(latLng, formatter(area), options)
                    .addTo(this._measurementLayer);
            }
        }
    })

    L.Circle.addInitHook(function () {
        if (this.options.showMeasurements) {
            this.showMeasurements();
        }
    });
})();
