import EventHandler from "../../EventHandler";

export default class DoctorNoteController extends EventHandler {
    constructor(domElements) {
        super();

        this.domElements = domElements;
        this._doctorId = location.pathname.split('/')[3];

        this.showNote();
        this.change();
    }

    _getNote() {
        return localStorage.getItem(`note_d${this._doctorId}`);
    }

    _setNote(note) {
        localStorage.setItem(`note_d${this._doctorId}`, note);
    }

    showNote() {
        this.domElements.textarea.value = this._getNote() || '';
    }

    change() {
        this.addEvent(this.domElements.textarea, 'change', _ => {
            this._setNote(this.domElements.textarea.value);
        });
    }
}
