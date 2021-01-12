import EventHandler from "../../EventHandler";
import ExtraDropdownMenuView from "./ExtraDropdownMenuView";

export default class GeneralController extends EventHandler{
    constructor(domElements) {
        super();

        this.domElements = domElements;

        this.openExtraDropdownMenu = this.openExtraDropdownMenu.bind(this);

        this.openExtraDropdownMenu();
    }

    openExtraDropdownMenu() {
        if (this.domElements.openExtraDropdownMenuBtn && this.domElements.extraDropdownMenu) {
            const view = new ExtraDropdownMenuView(this.domElements.extraDropdownMenu);

            this.addEvent(document.body, 'click', event => {
                if (!event.target.classList.contains('open-extra-dropdown-menu-btn')) {
                    view.hide();
                }
            });

            this.addEvent(this.domElements.openExtraDropdownMenuBtn, 'click', view.show);
        }
    }
}
