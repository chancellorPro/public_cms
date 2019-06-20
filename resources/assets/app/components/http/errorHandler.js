/**
 * Base error handler
 *
 * @param response
 */
import notifyError from "components/notify/notifyError";

export default function (response) {
    /**
     * Redirect to the route
     */
    if (!!response.route) {
        location.href = response.route;
        return;
    }

    /**
     * Show main error message
     */
    if (!!response.message) {
        notifyError(response.message);
    }

    /**
     * Show all messages
     */
    if(!!response.errors) {
        Object.keys(response.errors).map((key) => {
            response.errors[key].map(error => {
                notifyError(error);
            })
        });
    }
}
