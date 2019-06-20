import errorHandler from './errorHandler';
import successHandler from "./successHandler";

/**
 * HTTP Request Builder
 */
export default class {

    constructor(url) {
        this._url = url;
        this._method = 'get';
        this._data = {};
        this._error = errorHandler;
        this._success = successHandler;
        this._complete = function () {};
    }

    method(method) {
        this._method = method;

        return this;
    }

    data(data) {
        this._data = data;

        return this;
    }

    error(fn) {
        this._error = fn;

        return this;
    }

    success(fn) {
        this._success = fn;

        return this;
    }

    complete(fn) {
        this._complete = fn;

        return this;
    }

    send() {
        $.ajax({
            url: this._url,
            type: this._method,
            data: this._data,
            error: response => {
                if (!!response.responseJSON) {
                    this._error(response.responseJSON);
                }
            },
            success: this._success,
            complete: this._complete,
        });
    }
}
