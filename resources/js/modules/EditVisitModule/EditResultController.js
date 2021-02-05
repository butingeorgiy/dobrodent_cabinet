import EventHandler from "../../EventHandler";
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import PopupView from "../PopupModule/PopupView";
import EditPopupView from "./EditPopupView";
import PopupController from "../PopupModule/PopupController";

export default class EditResultController extends EventHandler {
    constructor(domElements, model) {
        super();

        this.domElements = domElements;
        this.model = model;

        this.addListenerForEditResult = this.addListenerForEditResult.bind(this);
        this.removeListenerForEditResult = this.removeListenerForEditResult.bind(this);
        this.saveResult = this.saveResult.bind(this);

        this.initEditor();
        this.openPopupForEditResult();
    }

    initEditor() {
        ClassicEditor
            .create(this.domElements.resultEditor)
            .then(editor => {
                this.editor = editor;
            })
            .catch(error => console.error(error));
    }

    openPopupForEditResult() {
        const resultPopup = new PopupView('.edit-visit-result-popup');
        this.popupView = new EditPopupView(
            this.domElements.saveResultBtn,
            this.domElements.errorResultEditing,
            this.domElements.successResultEditing,
            this.domElements.resultEditor.parentElement
        );

        this.addEvent(this.domElements.editResultBtn, 'click', event => {
           event.preventDefault();
           PopupController.open(resultPopup, false, null, this.addListenerForEditResult)
               .then()
               .catch(error => console.error(error));
        });
    }

    addListenerForEditResult() {
        this.addEvent(this.domElements.saveResultBtn, 'click', this.saveResult);
    }

    removeListenerForEditResult() {
        this.removeAllListeners(this.domElements.saveResultBtn, 'click');
    }

    saveResult() {
        const visitId = location.pathname.split('/')[3];
        const mode = location.pathname.split('/')[1];
        const result = this.editor.getData();

        this.popupView.showLoader(this.removeListenerForEditResult);

        this.model.editResult({result}, visitId, mode)
            .then(res => {
                if (typeof res !== 'string') {
                    if (res.error === true) {
                        this.popupView.showErrorMessage(res.message);
                        this.popupView.hideLoader(this.addListenerForEditResult);
                    } else {
                        this.popupView.showSuccessMessage(res.success);
                        setTimeout(_ => location.reload(), 1000);
                    }
                } else {
                    this.popupView.hideLoader(this.addListenerForEditResult);
                    console.error(res);
                }
            })
            .catch(error => {
                this.popupView.hideLoader(this.addListenerForEditResult);
                console.error(error);
            });
    }
}
