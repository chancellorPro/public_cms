import observer from "components/observer/EventObserver";
import {TAMATOOL_SHOW_FORM} from "../constants";

export default function () {
    observer.subscribe(TAMATOOL_SHOW_FORM, (data, self) => {
        observer.unsubscribe(TAMATOOL_SHOW_FORM, self);

        $('.neighbor-activity-form .datepicker').datetimepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            minView: '2'
        });
    });
}
