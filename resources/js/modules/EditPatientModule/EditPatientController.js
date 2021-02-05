import EventHandler from "../../EventHandler";
import PopupView from "../PopupModule/PopupView";
import EditPopupView from "./EditPopupView";
import PopupController from "../PopupModule/PopupController";

export default class EditPatientController extends EventHandler {
    constructor(domElements, model) {
        super();

        this.domElements = domElements;
        this.model = model;

        this.addListenerForEditPatient = this.addListenerForEditPatient.bind(this);
        this.removeListenerForEditPatient = this.removeListenerForEditPatient.bind(this);
        this.savePatientChanges = this.savePatientChanges.bind(this);

        this.openPopup();
    }

    openPopup() {
        const popup = new PopupView('.edit-patient-popup');
        this.popupView = new EditPopupView(
            this.domElements.savePatientEditingBtn,
            this.domElements.editPatientErrorMessage,
            this.domElements.editPatientSuccessMessage,
            this.domElements.editPatientInputsContainer
        );

        this.addEvent(this.domElements.editPatientBtn, 'click', event => {
            event.preventDefault();
            PopupController.open(popup, false, null, this.addListenerForEditPatient)
                .then()
                .catch(error => console.error(error));
        });
    }

    addListenerForEditPatient() {
        this.addEvent(this.domElements.savePatientEditingBtn, 'click', this.savePatientChanges);
    }

    removeListenerForEditPatient() {
        this.removeAllListeners(this.domElements.savePatientEditingBtn, 'click');
    }

    savePatientChanges() {
        const patientId = location.pathname.split('/')[3];
        const params = {};

        if (this.domElements.editPatientInputsContainer.querySelector('input[name=\'first_name\']')) {
            params.first_name = this.domElements.editPatientInputsContainer.querySelector('input[name=\'first_name\']').value;
        }

        if (this.domElements.editPatientInputsContainer.querySelector('input[name=\'last_name\']')) {
            params.last_name = this.domElements.editPatientInputsContainer.querySelector('input[name=\'last_name\']').value;
        }

        if (this.domElements.editPatientInputsContainer.querySelector('input[name=\'middle_name\']')) {
            params.middle_name = this.domElements.editPatientInputsContainer.querySelector('input[name=\'middle_name\']').value;
        }

        if (this.domElements.editPatientInputsContainer.querySelector('select[name=\'gender\']')) {
            params.gender = this.domElements.editPatientInputsContainer.querySelector('select[name=\'gender\']').value;
        }

        this.model.save(patientId, params)
            .then(result => {
                if (typeof result !== 'string') {
                    if (result.error === true) {
                        this.popupView.showErrorMessage(result.message);
                        this.popupView.hideLoader(this.addListenerForEditPatient);
                    } else {
                        this.popupView.showSuccessMessage(result.success);
                        setTimeout(_ => location.reload(), 1000);
                    }
                } else {
                    this.popupView.hideLoader(this.addListenerForEditPatient);
                }
            })
            .catch(error => {
                this.popupView.hideLoader(this.addListenerForEditPatient);
                console.error(error);
            });
    }
}
