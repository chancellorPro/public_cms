import observer from "components/observer/EventObserver";
import {BANNER_SHOW_FORM} from "../constants";
import changeType from "../handlers/changeType";

/**
 * Show form listener
 */
export default function () {
    observer.subscribe(BANNER_SHOW_FORM, () => {

        /**
         * Type select change trigger
         */
        changeType();

        /**
         * Dates init
         */
        $('.banner-form .datepicker').datetimepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            minView: '2'
        });
    });
}
