export default class ExtraDropdownMenuView {
    constructor(dropdownNode) {
        this._isShown = false;
        this._dropdownNode = dropdownNode;

        this.show = this.show.bind(this);
        this.hide = this.hide.bind(this);
    }

    show() {
        if (this._isShown === false) {
            this._dropdownNode.classList.remove('hidden');
            this._isShown = true;
        }
    }

    hide() {
        if (this._isShown === true) {
            this._dropdownNode.classList.add('hidden');
            this._isShown = false;
        }
    }

    isShown() {
        return this._isShown;
    }
}
