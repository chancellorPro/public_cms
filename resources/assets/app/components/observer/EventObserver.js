/**
 * Event observer
 */
class EventObserver {
    constructor () {
        this.subscribers = {};
    }

    subscribe (event, handler) {
        this._log('subscribe', event);

        if (!this.subscribers[event]) {
            this.subscribers[event] = [];
        }

        this.subscribers[event].push(handler);

        return this;
    }

    dispatch (event, data) {
        this._log('dispatch', event);

        if (!!this.subscribers[event]) {
            this.subscribers[event].forEach(handler => {
                handler(data, handler);
            });
        }

        return this;
    }

    unsubscribe (event, state) {
        this._log('unsubscribe', event);

        if (!!this.subscribers[event]) {
            this.subscribers[event] = this.subscribers[event].filter(handler => handler !== state);
        }
    }

    _log(method, event) {
        console.log(method.toUpperCase(), ':', '[', event, ']');
    }
}

const observer = new EventObserver();

export default observer;
