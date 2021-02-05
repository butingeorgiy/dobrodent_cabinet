import EventHandler from "../../EventHandler";

export default class AttachFilesController extends EventHandler {
    constructor(domElements, model) {
        super();

        this.domElements = domElements;
        this.model = model;

        this.changeInput();
    }

    changeInput() {
        this.addEvent(this.domElements.uploadFileInput, 'change', _ => {
            this.domElements.uploadFileForm.submit();
        });
    }
}
