import EventHandler from "../../EventHandler";
import PopupView from "../PopupModule/PopupView";
import EditPopupView from "./EditPopupView";
import PopupController from "../PopupModule/PopupController";

export default class EditDateAndTimeController extends EventHandler{
    constructor(domElements, model) {
        super();

        this.domElements = domElements;
        this.model = model;

        this.addListenerForSaveMoving = this.addListenerForSaveMoving.bind(this);
        this.removeListenerForSaveMoving = this.removeListenerForSaveMoving.bind(this);
        this.moveVisit = this.moveVisit.bind(this);

        this.openPopupForEditingDateAndTime();
    }

    openPopupForEditingDateAndTime() {
        const editDateAndTimePopup = new PopupView('.move-visit-popup');
        this.popupView = new EditPopupView(
            this.domElements.saveTimeAndDateBtn,
            this.domElements.errorTimeAndDateEditing,
            this.domElements.successTimeAndDateEditing,
            this.domElements.inputsContainer
        );

        this.addEvent(this.domElements.editTimeAndDateBtn, 'click', event => {
            event.preventDefault();
            PopupController.open(editDateAndTimePopup, false, null, this.addListenerForSaveMoving).then().catch(error => console.error(error));
        });
    }

    addListenerForSaveMoving() {
        this.addEvent(this.domElements.saveTimeAndDateBtn, 'click', this.moveVisit);
    }

    removeListenerForSaveMoving() {
        this.removeAllListeners(this.domElements.saveTimeAndDateBtn, 'click');
    }

    moveVisit() {
        const visit_date = this.domElements.inputsContainer.querySelector('input[name=\'visit_date\']').value;
        const visit_time = this.domElements.inputsContainer.querySelector('input[name=\'visit_time\']').value;
        const visitId = location.pathname.split('/')[3];
        const mode = location.pathname.split('/')[1];

        this.popupView.showLoader(this.removeListenerForSaveMoving);

        this.model.move({visit_date, visit_time}, visitId, mode)
            .then(result => {
                if (typeof result !== 'string') {
                    if (result.error === true) {
                        this.popupView.showErrorMessage(result.message);
                        this.popupView.hideLoader(this.addListenerForSaveMoving);
                    } else {
                        this.popupView.showSuccessMessage();
                        setTimeout(_ => location.reload(), 1000);
                    }
                } else {
                    this.popupView.hideLoader(this.addListenerForSaveMoving);
                    console.error(result);
                }
            })
            .catch(error => {
                console.error(error);
                this.popupView.hideLoader(this.addListenerForSaveMoving);
            });
    }
}
