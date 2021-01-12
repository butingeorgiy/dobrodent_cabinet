export default class DropdownMenuView {
    constructor(menuNode) {
        this._isShown = false;
        this.menuNode = menuNode;

        this.toggle = this.toggle.bind(this);
    }

    toggle() {
        if (this._isShown === false) {
            this.menuNode.classList.remove('hidden');
            setTimeout(_ => {
                this.menuNode.classList.add('max-h-screen')
            }, 0);
        } else {
            this.menuNode.classList.remove('max-h-screen');
            setTimeout(_ => {
                this.menuNode.classList.add('hidden');
            }, 500);
        }

        this._isShown = !this._isShown;
    }
}

