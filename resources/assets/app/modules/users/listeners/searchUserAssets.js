import observer from "components/observer/EventObserver";
import {SEARCH_USER_ASSETS} from "../constants";

/**
 * Search user assets
 */
export default function () {
    observer.subscribe(SEARCH_USER_ASSETS, data => {
        $('#search-assets-container').html(data);
    });
}
