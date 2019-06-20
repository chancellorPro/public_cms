/**
 * jQuery
 */
import $ from 'jquery';
window.$ = $;
window.jQuery = $;

/**
 * Bootstrap
 */
import './vendor/bootstrap';

/**
 * Bootstrap Ccolorpicker
 */
import 'bootstrap-colorpicker';
import 'bootstrap-colorpicker/dist/css/bootstrap-colorpicker.css';

/**
 * Font Awesome
 */
import 'font-awesome/scss/font-awesome.scss';

/**
 * External modules
 * TODO: get by npm
 */
import './vendor/animate';
import './vendor/bootstrap-confirmation';
import './vendor/bootstrap-datetimepicker';
import './vendor/bootstrap-notify';
import './vendor/select2';
import './vendor/ekko-lightbox';
import './vendor/theme';

/**
 * Components
 */
import './components';

/**
 * Handlers
 */
import './handlers';

/**
 * Styles
 */
import './styles/index.scss';

/**
 * Modules loader
 */
const path = location.pathname.split('/');
const context = require.context('modules', true, /module\.js$/);
if (path[1].length > 2) {
    /**
     * To creating different files for each module
     * (Don't forget npm i --save-dev bundle-loader)
     * const context = require.context('bundle-loader!modules', true, /index\.js$/);
     */
    context.keys().map(module => {
        if (module.split('/')[1] === 'settings') {
            if (path[2] !== undefined && module.split('/')[3] === path[2]) {
                console.log('MODULE:', path[2]);
                context(module);
            }
        }

        if (module.split('/')[1] === path[1]) {
            console.log('MODULE:', path[1]);
            context(module);
        }

        if(path[1].length === 0) {
            context('./default/module.js');
        }
    });
} else {
    console.log('MODULE: public');
    context('./public/module.js');
}
