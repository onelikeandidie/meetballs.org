import axios from 'axios';

window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import human from 'human-time';

window.utils = {
    formatHumanDuration: human
}

import {Alpine} from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();
