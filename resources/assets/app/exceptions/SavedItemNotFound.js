/**
 * Saved item not found
 *
 * Using in fastSave handler
 */
export class SavedItemNotFound extends Error {
    constructor() {
        const message = 'SavedItemNotFound';
        super(message);
    }
}
