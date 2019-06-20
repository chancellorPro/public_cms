import observer from "components/observer/EventObserver";
import {ACTION_TYPE_STATES_CHANGED} from "modules/action-type/constants";

/**
 * Update indexes of the states
 */
export default function () {
    observer.subscribe(ACTION_TYPE_STATES_CHANGED, () => {
        let index = 1;

        $('.index').each((_, item) => {
            $(item).val(index++);
        })
    });
}
