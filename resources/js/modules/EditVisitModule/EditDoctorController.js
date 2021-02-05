import EventHandler from "../../EventHandler";
import PopupView from "../PopupModule/PopupView";
import PopupController from "../PopupModule/PopupController";
import EditPopupView from "./EditPopupView";
import TomSelect from "tom-select";

export default class EditDoctorController extends EventHandler {
    constructor(domElements, model) {
        super();

        this.domElements = domElements;
        this.model = model;

        this.addListenerForChangeDoctor = this.addListenerForChangeDoctor.bind(this);
        this.removeListenerForChangeDoctor = this.removeListenerForChangeDoctor.bind(this);
        this.changeDoctor = this.changeDoctor.bind(this);

        this.openPopup();
        this.initSelect();
    }

    openPopup() {
        const popup = new PopupView('.edit-visit-doctor-popup');
        this.popupView = new EditPopupView(
            this.domElements.saveDoctorBtn,
            this.domElements.errorDoctorEditing,
            this.domElements.successDoctorEditing,
            this.domElements.changeDoctorSelect.parentElement
        );

        this.addEvent(this.domElements.changeDoctorBtn, 'click', event => {
            event.preventDefault();
            PopupController.open(popup, false, null, this.addListenerForChangeDoctor)
                .then()
                .catch(error => console.error(error));
        });
    }

    initSelect() {
        let options = this.domElements.changeDoctorSelect.getAttribute('data-options'),
            chosen = this.domElements.changeDoctorSelect.getAttribute('data-selected');

        if (options) {
            this.domElements.changeDoctorSelect.removeAttribute('data-options');
            options = JSON.parse(options);
        }

        if (chosen) {
            this.domElements.changeDoctorSelect.removeAttribute('data-selected');
            chosen = [chosen];
        }

        this.select = new TomSelect('.edit-visit-doctor-select', {
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
                                    <div class="mr-1 text-base leading-5">${escape(title)}</div>
                                </div>
                            `;
                },
                'no_results': _ => {
                    return '<div class="no-results">Ничего не найдено</div>';
                }
            }
        });
    }

    addListenerForChangeDoctor() {
        this.addEvent(this.domElements.saveDoctorBtn, 'click', this.changeDoctor);
    }

    removeListenerForChangeDoctor() {
        this.removeAllListeners(this.domElements.saveDoctorBtn, 'click');
    }

    changeDoctor() {
        this.popupView.showLoader(this.removeListenerForChangeDoctor);

        const visitId = location.pathname.split('/')[3];
        const doctor_id = this.select.getValue();

        this.popupView.hideMessages();

        this.model.changeDoctor({doctor_id}, visitId)
            .then(result => {
                if (typeof result !== 'string') {
                    if (result.error === true) {
                        this.popupView.showErrorMessage(result.message);
                        this.popupView.hideLoader(this.addListenerForChangeDoctor);
                    } else {
                        this.popupView.showSuccessMessage(result.success);
                        setTimeout(_ => location.reload(), 1000);
                    }
                } else {
                    this.popupView.hideLoader(this.addListenerForChangeDoctor);
                    console.error(result);
                }
            })
            .catch(error => {
                this.popupView.hideLoader(this.addListenerForChangeDoctor);
                console.error(error);
            });
    }
}
