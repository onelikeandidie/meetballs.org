import axios from 'axios';

window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import human from 'human-time';
import leaflet from 'leaflet';
import 'leaflet/dist/leaflet.css';

window.utils = {
  formatHumanDuration: human
}

import { Alpine } from 'alpinejs';

document.addEventListener('alpine:init', () => {
  Alpine.data('map', (options, markers = []) => ({
    map: null,
    layers: [],
    init() {
      // this.map = new leaflet.Map(this.$el, options);
      this.map = new leaflet.map(this.$el);
      this.map.setView(options.center, options.zoom);
      // this.map.addLayer(new leaflet.Layer("http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"));
      leaflet.tileLayer("http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", { maxZoom: 18 })
        .addTo(this.map);
      for (let marker of markers) {
        console.log(marker);
        let newMarker = leaflet.marker(marker.position);
        newMarker.addTo(this.map);
        if (marker.popup) {
          let popup = newMarker.bindPopup(marker.popup.message);
          if (marker.popup.openByDefault) {
            popup.openPopup();
          }
        }
      }
    },
    addLayer(options) {
      let layer = new leaflet.Layer(options);
      this.layers.push(layer);
      this.map.addLayer(layer);
    }
  }));
});

window.Alpine = Alpine;
Alpine.start();
