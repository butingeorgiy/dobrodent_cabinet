export default class FiltersContainerView {
    constructor(containerNode) {
        this._containerNode = containerNode;
        this._isShown = false;

        this.toggle = this.toggle.bind(this);
    }

    toggle() {
        if (this._isShown === true) {
            this._isShown = false;

            this._containerNode.classList.remove('max-h-screen');
            setTimeout(_ => {
                this._containerNode.classList.add('hidden');
            }, 680);
        } else if (this._isShown === false) {
            this._isShown = true;

            this._containerNode.classList.remove('hidden');
            setTimeout(_ => {
                this._containerNode.classList.add('max-h-screen');
            }, 0);
        }
    }
}
