import observer from "components/observer/EventObserver";
import {DELETE_NEIGHBOR} from "../constants";

/**
 * Set neighbor as deleted
 */
export default function () {
    observer.subscribe(DELETE_NEIGHBOR, resp => {
        if (resp.type == 'success') {
            $('#delete-neighbor-' + resp.data.neighbor_id).addClass('hidden');
            $('#add-neighbor-' + resp.data.neighbor_id).removeClass('hidden');
            $('#neighbor-status-' + resp.data.neighbor_id).html(resp.data.status_text);
        }
    });
}
