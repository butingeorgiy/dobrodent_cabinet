import EventHandler from "../../EventHandler";

export default class PopupController {
    static async open(view, handleClose = false, before = null, after = null) {
        if (before !== null)  { await before(); }
        view.show();
        if (handleClose === false) { await PopupController._autoClose(view); }
        if (after !== null) { await after(); }
    }

    static _autoClose(view) {
        const popupNode = view.getPopup();

        popupNode.addEventListener('mousedown', event => {
            if (event.target.classList.contains('popup-wrapper')) { view.hide(); }
        });
    }

    static async close(view, before = null, after = null) {
        if (before !== null)  { await before(); }
        view.close();
        if (after !== null) { await after(); }
    }
}
