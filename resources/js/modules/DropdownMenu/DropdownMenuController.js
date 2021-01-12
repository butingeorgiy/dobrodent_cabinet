import DropdownMenuView from "./DropdownMenuView";
import EventHandler from "../../EventHandler";

export default class DropdownMenuController extends EventHandler {
    constructor(domElements) {
        super();

        this.domElements = domElements;

        this.view = new DropdownMenuView(
            this.domElements.menu
        );

        this.manageDropdownMenu = this.manageDropdownMenu.bind(this);

        this.manageDropdownMenu();
    }

    manageDropdownMenu() {
        if (this.domElements.menu && this.domElements.openDropdownMenuBtn) {
            this.addEvent(this.domElements.openDropdownMenuBtn, 'click', this.view.toggle);
        }
    }
}
