/**
 * Notify helper
 *
 * @param message
 * @param type
 */
export default function notify(message, type) {
    $.notify({message: message},{
        type: type,
        z_index: 1051
    });
}
