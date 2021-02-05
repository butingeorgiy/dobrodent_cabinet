import EventHandler from "../../EventHandler";
import PopupController from "../PopupModule/PopupController";
import PopupView from "../PopupModule/PopupView";
import TomSelect from "tom-select";
import EditPopupView from "./EditPopupView";

export default class EditStatusController extends EventHandler {
    constructor(domElements, model) {
        super();

        this.domElements = domElements;
        this.model = model;

        this.addListenerForSaveStatus = this.addListenerForSaveStatus.bind(this);
        this.removeListenerForSaveStatus = this.removeListenerForSaveStatus.bind(this);
        this.saveStatus = this.saveStatus.bind(this);

        this.openPopupForEditingStatus();
        this.initStatusesSelect();
    }

    openPopupForEditingStatus() {
        const editStatusPopup = new PopupView('.edit-visit-status-popup');
        this.popupView = new EditPopupView(
            this.domElements.saveStatusBtn,
            this.domElements.errorStatusEditing,
            this.domElements.successStatusEditing,
            this.domElements.statusesSelect.parentElement
        );

        this.addEvent(this.domElements.editStatusBtn, 'click', event => {
            event.preventDefault();
            PopupController.open(editStatusPopup, false, null, this.addListenerForSaveStatus).then().catch(error => console.error(error));
        });
    }

    initStatusesSelect() {
        const initValue = this.domElements.statusesSelect.getAttribute('data-init');
        this.domElements.statusesSelect.removeAttribute('data-init');

        this.editStatusSelect = new TomSelect('.edit-visit-status-select', {
            create: false,
            sortField: {
                field: 'value',
                direction: 'asc'
            },
            items: [initValue],
            render: {
                'no_results': function () {
                    return '<div class="no-results">Ничего не найдено</div>';
                }
            }
        })
    }

    addListenerForSaveStatus() {
        this.addEvent(this.domElements.saveStatusBtn, 'click', this.saveStatus);
    }

    removeListenerForSaveStatus() {
        this.removeAllListeners(this.domElements.saveStatusBtn, 'click');
    }

    saveStatus() {
        const status_id = this.editStatusSelect.getValue();
        const visitId = location.pathname.split('/')[3];
        const mode = location.pathname.split('/')[1];

        this.popupView.showLoader(this.removeListenerForSaveStatus);

        this.model.editStatus({status_id}, visitId, mode)
            .then(result => {
                if (typeof result !== 'string') {
                    if (result.error === true) {
                        this.popupView.showErrorMessage(result.message);
                        this.popupView.hideLoader(this.addListenerForSaveStatus);
                    } else {
                        this.popupView.showSuccessMessage();
                        setTimeout(_ => location.reload(), 1000);
                    }
                } else {
                    this.popupView.hideLoader(this.addListenerForSaveStatus);
                    console.error(result);
                }
            })
            .catch(error => {
                console.error(error);
                this.popupView.hideLoader(this.addListenerForSaveStatus);
            });
    }
}
