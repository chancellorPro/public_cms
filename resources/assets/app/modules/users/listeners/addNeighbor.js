import observer from "components/observer/EventObserver";
import {ADD_NEIGHBOR} from "../constants";

/**
 * Set neighbor as active
 */
export default function () {
    observer.subscribe(ADD_NEIGHBOR, resp => {
        if (resp.type == 'success') {
            $('#delete-neighbor-' + resp.data.neighbor_id).removeClass('hidden');
            $('#add-neighbor-' + resp.data.neighbor_id).addClass('hidden');
            $('#neighbor-status-' + resp.data.neighbor_id).html(resp.data.status_text);
        }
    });
}
