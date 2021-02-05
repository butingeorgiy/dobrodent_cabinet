import EventHandler from "../../EventHandler";
import TomSelect from 'tom-select/dist/js/tom-select.complete.min';
import CreateVisitFormView from "./CreateVisitFormView";

export default class CreateVisitController extends EventHandler {
    constructor(domElements, model) {
        super();

        this.domElements = domElements;
        this.model = model;
        this.mode = location.pathname.split('/')[1];

        this.createVisit = this.createVisit.bind(this);


        if (domElements.visitDestinationSelect) {
            this.initVisitDestinationSelect();
        }

        if (domElements.visitPatientSelect && (this.mode === 'doctor' || this.mode === 'administrator')) {
            this.initPatientsSelect();
        }

        if (
            domElements.createVisitBtn &&
            domElements.visitDestinationSelect &&
            domElements.causeTextarea &&
            domElements.timeInput &&
            domElements.dateInput &&
            domElements.errorBox &&
            domElements.successBox
        ) {
            this.createVisitFormView = new CreateVisitFormView(
                this.destSelect,
                this.patientSelect,
                this.domElements.causeTextarea,
                this.domElements.timeInput,
                this.domElements.dateInput,
                this.domElements.createVisitBtn,
                this.domElements.errorBox,
                this.domElements.successBox
            );

            this.addListenerForCreatingVisit();
        }
    }

    initPatientsSelect() {
        let options = this.domElements.visitPatientSelect.getAttribute('data-options'),
            chosen = this.domElements.visitPatientSelect.getAttribute('data-selected');

        if (options) {
            this.domElements.visitPatientSelect.removeAttribute('data-options');
            options = JSON.parse(options);
        }

        if (chosen) {
            this.domElements.visitPatientSelect.removeAttribute('data-selected');
            chosen = [chosen];
        }

        this.patientSelect = new TomSelect('.visit-patient-select', {
            create: false,
            valueField: 'id',
            searchField: 'title',
            options,
            items: chosen,
            render: {
                option: (data, escape) => {
                    return `
                                <div class="flex items-center">
                                    <div class="min-w-8 min-h-8 w-8 h-8 p-1 mr-2 bg-center bg-no-repeat bg-contain rounded-full" style="background-image: url(${data.photo})"></div>
                                    <div class="mr-1 text-sm sm:text-base leading-5 hover:bg-gray-50">${escape(data.title)}</div>
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
                                    <div class="min-w-8 min-h-8 w-8 h-8 p-1 mr-2 bg-center bg-no-repeat bg-contain rounded-full" style="background-image: url(${data.photo})"></div>
                                    <div class="mr-1 text-sm sm:text-base leading-5">${escape(title)}</div>
                                </div>
                            `;
                },
                'no_results': _ => {
                    return '<div class="no-results">Ничего не найдено</div>';
                },
            }
        });
    }

    initVisitDestinationSelect() {
        let options = this.domElements.visitDestinationSelect.getAttribute('data-options');
        let chosen = this.domElements.visitDestinationSelect.getAttribute('data-selected');

        if (options) {
            this.domElements.visitDestinationSelect.removeAttribute('data-options');
            options = JSON.parse(options);
        }

        if (chosen) {
            this.domElements.visitDestinationSelect.removeAttribute('data-selected');
            chosen = [chosen];
        }

        this.destSelect = new TomSelect('.visit-destination-select', {
            create: false,
            valueField: 'id',
            searchField: 'title',
            options,
            items: chosen,
            render: {
                option: (data, escape) => {
                    return `
                                <div class="flex items-center">
                                    <div class="min-w-8 min-h-8 w-8 h-8 p-1 mr-2 bg-center bg-no-repeat bg-contain rounded-full" style="background-image: url(${data.photo})"></div>
                                    <div class="mr-1 text-sm sm:text-base leading-5 hover:bg-gray-50">${escape(data.title)}</div>
                                    <div class="hidden md:block mr-1 text-sm text-gray-500">${ data.extra !== '' ? '(' + data.extra + ')' : ''}</div>
                                </div>
                            `;
                },
                item: (data, escape) => {
                    let title = '';

                    if (data.id[0] === 'd') {
                        title = data.title.split(' ')[0] + ' ' + data.title.split(' ')[1][0] + '.';

                        if (data.title.split(' ')[2]) {
                            title += data.title.split(' ')[2][0] + '.';
                        }
                    } else {
                        title = data.title;
                    }

                    return `
                                <div class="inline-flex items-center">
                                    <div class="min-w-8 min-h-8 w-8 h-8 p-1 mr-2 bg-center bg-no-repeat bg-contain rounded-full" style="background-image: url(${data.photo})"></div>
                                    <div class="mr-1 text-sm sm:text-base leading-5">${escape(title)}</div>
                                    <div class="hidden md:block mr-1 text-sm text-gray-500">${data.extra !== '' ? '(' + data.extra + ')' : ''}</div>
                                </div>
                            `;
                },
                'no_results': _ => {
                    return '<div class="no-results">Ничего не найдено</div>';
                },
            }
        });
    }

    addListenerForCreatingVisit() {
        this.addEvent(this.domElements.createVisitBtn, 'click', this.createVisit);
    }

    createVisit() {
        this.removeAllListeners(this.domElements.createVisitBtn, 'click');

        let data = {}

        if (this.destSelect) { data.dest = this.destSelect.getValue(); }
        if (this.domElements.causeTextarea) { data.cause = this.domElements.causeTextarea.value; }
        if (this.domElements.timeInput) { data.time = this.domElements.timeInput.value; }
        if (this.domElements.dateInput) { data.date = this.domElements.dateInput.value; }

        if (this.patientSelect && (this.mode === 'doctor' || this.mode === 'administrator')) {
            data.patient_id = this.patientSelect.getValue();
        }

        this.createVisitFormView.hideMessages();

        this.model.create(data, this.mode)
            .then(result => {
                if (typeof result !== 'string') {
                    if (result.error === true) {
                        this.addListenerForCreatingVisit();
                        this.createVisitFormView.showErrorStatus(result.message);
                    } else {
                        this.createVisitFormView.disable();
                        this.createVisitFormView.showSuccessStatus(result.success);
                        setTimeout(_ => {
                            location.assign(`/${this.mode}/visits`);
                        }, 1000)
                    }
                } else {
                    this.addListenerForCreatingVisit();
                    this.createVisitFormView.showErrorStatus(result);
                }
            })
            .catch(error => {
                this.addListenerForCreatingVisit();
                this.createVisitFormView.showErrorStatus(error);
            });
    }
}
