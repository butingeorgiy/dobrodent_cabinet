export default class PopupView {
    constructor(selector) {
        this._wrapper = document.querySelector(selector);
        this._popup = null;
        this._canOpen = false;

        if (this._wrapper) { this._popup = this._wrapper.querySelector('.popup'); }

        if (this._wrapper && this._popup) { this._canOpen = true; }
    }

    show() {
        if (this._canOpen) {
            const timerContext = this;

            this._wrapper.classList.remove('hidden');
            setTimeout(_ => timerContext._popup.classList.add('top-0'), 10);
        }
    }

    hide() {
        if (this._canOpen) {
            const timerContext = this;

            this._popup.classList.remove('top-0');
            setTimeout(_ => timerContext._wrapper.classList.add('hidden'), 250);
        }
    }

    getPopup() {
        return this._wrapper;
    }
}
