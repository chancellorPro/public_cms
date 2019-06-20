import observer from "components/observer/EventObserver";
import notifySuccess from "components/notify/notifySuccess";
import {SUBMIT_USER_PART_FORM} from "../constants";

/**
 * Submit user part form
 */
export default function () {
    observer.subscribe(SUBMIT_USER_PART_FORM, resp => {
        let form = $(resp.data);
        $('#' + resp.container).replaceWith(form);
        form.find('.select2').select2();
        notifySuccess('User data updated');
    });
}
