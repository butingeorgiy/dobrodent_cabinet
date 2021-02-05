import EventHandler from "../../EventHandler";
import PopupView from "../PopupModule/PopupView";
import EditPopupView from "./EditPopupView";
import PopupController from "../PopupModule/PopupController";
import TomSelect from "tom-select";

export default class AttachIllnessController extends EventHandler {
    constructor(domElements, model) {
        super();

        this.domElements = domElements;
        this.model = model;

        this.addListenerForAttachIllness = this.addListenerForAttachIllness.bind(this);
        this.removeListenerForAttachIllness = this.removeListenerForAttachIllness.bind(this);
        this.attachVisit = this.attachVisit.bind(this);

        this.openPopupForAttachIllness();
        this.initIllnessesSelect();
    }

    initIllnessesSelect() {
        this.illnesessSelect = new TomSelect('.attach-illness-select', {
            create: true,
            sortField: {
                field: 'value',
                direction: 'asc'
            },
            render: {
                'no_results': _ => {
                    return '<div class="no-results">Ничего не найдено</div>';
                },
                'option_create': (data, escape) => {
                    return `<div class="create">Создать болезнь: <p class="font-semibold">${escape(data.input)}</p>&hellip;</div>`;
                }
            }
        });
    }

    openPopupForAttachIllness() {
        const attachIllnessPopup = new PopupView('.attach-illness-popup');
        this.popupView = new EditPopupView(
            this.domElements.attachIllnessBtn,
            this.domElements.errorIllnessAttaching,
            this.domElements.successIllnessAttaching,
            this.domElements.illnessesSelect.parentElement
        );

        this.addEvent(this.domElements.editIllnessBtn, 'click', event => {
           event.preventDefault();
           PopupController.open(attachIllnessPopup, false, null, this.addListenerForAttachIllness)
               .then()
               .catch(error => console.error(error));
        });
    }

    addListenerForAttachIllness() {
        this.addEvent(this.domElements.attachIllnessBtn, 'click', this.attachVisit);
    }

    removeListenerForAttachIllness() {
        this.removeAllListeners(this.domElements.attachIllnessBtn, 'click');
    }

    attachVisit() {
        const illness = this.illnesessSelect.getValue();
        const visitId = location.pathname.split('/')[3];
        const mode = location.pathname.split('/')[1];

        this.popupView.showLoader(this.removeListenerForAttachIllness);

        this.model.attachIllness({illness}, visitId, mode)
            .then(result => {
                if (typeof result !== 'string') {
                    if (result.error === true) {
                        this.popupView.showErrorMessage(result.message);
                        this.popupView.hideLoader(this.addListenerForAttachIllness);
                    } else {
                        this.popupView.showSuccessMessage(result.success);
                        setTimeout(_ => location.reload(), 1000);
                    }
                } else {
                    this.popupView.hideLoader(this.addListenerForAttachIllness);
                    console.error(result);
                }
            })
            .catch(error => {
                this.popupView.hideLoader(this.addListenerForAttachIllness);
                console.error(error);
            });
    }
}
