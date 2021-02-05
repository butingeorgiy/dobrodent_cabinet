import EventHandler from "../../EventHandler";
import PopupView from "../PopupModule/PopupView";
import EditPopupView from "./EditPopupView";
import TomSelect from "tom-select";
import PopupController from "../PopupModule/PopupController";

export default class EditPatientController extends EventHandler {
    constructor(domElements, model) {
        super();

        this.domElements = domElements;
        this.model = model;

        this.addListenerForChangePatient = this.addListenerForChangePatient.bind(this);
        this.removeListenerForChangePatient = this.removeListenerForChangePatient.bind(this);
        this.changePatient = this.changePatient.bind(this);

        this.openPopup();
        this.initSelect();
    }

    openPopup() {
        const popup = new PopupView('.edit-visit-patient-popup');
        this.popupView = new EditPopupView(
            this.domElements.savePatientBtn,
            this.domElements.errorPatientEditing,
            this.domElements.successPatientEditing,
            this.domElements.changePatientSelect.parentElement
        );

        this.addEvent(this.domElements.changePatientBtn, 'click', event => {
            event.preventDefault();
            PopupController.open(popup, false, null, this.addListenerForChangePatient)
                .then()
                .catch(error => console.error(error));
        })
    }

    initSelect() {
        let options = this.domElements.changePatientSelect.getAttribute('data-options'),
            chosen = this.domElements.changePatientSelect.getAttribute('data-selected');

        if (options) {
            this.domElements.changePatientSelect.removeAttribute('data-options');
            options = JSON.parse(options);
        }

        if (chosen) {
            this.domElements.changePatientSelect.removeAttribute('data-selected');
            chosen = [chosen];
        }

        this.select = new TomSelect('.edit-visit-patient-select', {
            create: false,
            valueField: 'id',
            searchField: 'title',
            options,
            items: chosen,
            render: {
                option: data => {
                    return `
                                <div class="flex items-center">
                                    <div class="min-w-10 min-h-10 w-10 h-10 p-1 mr-2 bg-center bg-no-repeat bg-contain rounded-full" style="background-image: url(${data.photo})"></div>
                                    <div class="mr-1 text-base leading-5 hover:bg-gray-50">${data.title}</div>
                                </div>
                            `;
                },
                item: (data, escape) => {
                    let title = '';

                    if (data.id !== '') {
                        title = data.title.split(' ')[0] + ' ' + data.title.split(' ')[1][0] + '.';

                        if (data.title.split(' ')[2]) {
                            title += data.title.split(' ')[2][0] + '.';
                        }
                    } else {
                        title = data.title;
                    }

                    return `
                                <div class="inline-flex items-center">
                                    <div class="min-w-10 min-h-10 w-10 h-10 p-1 mr-2 bg-center bg-no-repeat bg-contain rounded-full" style="background-image: url(${data.photo})"></div>
                                    <div class="mr-1 leading-5 text-base">${escape(title)}</div>
                                </div>
                            `;
                },
                'no_results': _ => {
                    return '<div class="no-results">Ничего не найдено</div>';
                }
            }
        });
    }

    addListenerForChangePatient() {
        this.addEvent(this.domElements.savePatientBtn, 'click', this.changePatient);
    }

    removeListenerForChangePatient() {
        this.removeAllListeners(this.domElements.savePatientBtn, 'click');
    }

    changePatient() {
        this.popupView.showLoader(this.removeListenerForChangePatient);

        const visitId = location.pathname.split('/')[3];
        const patient_id = this.select.getValue();

        this.popupView.hideMessages();

        this.model.changePatient({patient_id}, visitId)
            .then(result => {
                if (typeof result !== 'string') {
                    if (result.error === true) {
                        this.popupView.showErrorMessage(result.message);
                        this.popupView.hideLoader(this.addListenerForChangePatient);
                    } else {
                        this.popupView.showSuccessMessage(result.success);
                        setTimeout(_ => location.reload(), 1000);
                    }
                } else {
                    this.popupView.hideLoader(this.addListenerForChangePatient);
                    console.error(result);
                }
            })
            .catch(error => {
                this.popupView.hideLoader(this.addListenerForChangePatient);
                console.error(error);
            });
    }
}
