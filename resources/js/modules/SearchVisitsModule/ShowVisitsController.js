import EventHandler from "../../EventHandler";
import FiltersContainerView from "./FiltersContainerView";
import VisitsListView from "./VisitsListView";
import TomSelect from 'tom-select/dist/js/tom-select.complete.min';
import flatpickr from "flatpickr";
import { Russian } from 'flatpickr/dist/l10n/ru.js'
import Helper from "../../Helper";

export default class ShowVisitsController extends EventHandler {
    constructor(domElements, model) {
        super();

        this.domElements = domElements;
        this.model = model;
        this.filters = {};
        this.mode = location.pathname.split('/')[1];
        this.searchingMore = false;
        this.canShowMore = true;
        this.prevFilters = null;

        this.allowToShowMore = this.allowToShowMore.bind(this);
        this.forbidToShowMore = this.forbidToShowMore.bind(this);

        if (domElements.showVisitsFiltersBtn && domElements.visitsFilters) {
            this.showFilters();
        }

        if (domElements.datePeriodInput) {
            this.initDateInputs();
        }

        if (domElements.visitStatusesSelect) {
            this.initVisitStatusesSelect();
        }

        if (domElements.visitDoctorsSelect) {
            this.initVisitDoctorsSelect();
        }

        if (domElements.visitPatientSelect) {
            this.initVisitPatientsSelect();
        }

        if (domElements.visitIllnessesSelect) {
            this.initVisitIllnessesSelect();
        }

        if (
            domElements.showMoreVisitsBtn &&
            domElements.visitsContainer &&
            domElements.acceptVisitsFiltersBtn
        ) {
            this.acceptFilters();
            this.showMore();

            this.visitsListView = new VisitsListView(
                domElements.showMoreVisitsBtn,
                domElements.visitsContainer,
                domElements.visitsAmountIndicator
            );
        }
    }

    initDateInputs() {
        this.datePicker = flatpickr(this.domElements.datePeriodInput, {
            mode: 'range',
            dateFormat: 'd.m.Y',
            locale: Russian
        });
    }

    showFilters() {
        const view = new FiltersContainerView(this.domElements.visitsFilters)
        this.addEvent(this.domElements.showVisitsFiltersBtn, 'click', view.toggle);
    }

    initVisitStatusesSelect() {
        this.statusesSelect = new TomSelect('.visit-statuses-select', {
            create: false,
            plugins: ['remove_button'],
            sortField: {
                field: 'value',
                direction: 'asc'
            },
            render: {
                'no_results': function () {
                    return '<div class="no-results">Ничего не найдено</div>';
                }
            }
        });
    }

    initVisitDoctorsSelect() {
        this.doctorsSelect = new TomSelect('.visit-doctors-select', {
            create: false,
            plugins: ['remove_button'],
            sortField: {
                field: 'value',
                direction: 'asc'
            },
            render: {
                'no_results': _ => {
                    return '<div class="no-results">Ничего не найдено</div>';
                }
            }
        });
    }

    initVisitIllnessesSelect() {
        this.illnessesSelect = new TomSelect('.visit-illnesses-select', {
            create: false,
            plugins: ['remove_button'],
            sortField: {
                field: 'value',
                direction: 'asc'
            },
            render: {
                'no_results': _ => {
                    return '<div class="no-results">Ничего не найдено</div>';
                }
            }
        });

        if (location.search.slice(1, 8) === 'illness' && this.mode === 'patient') {
            this.filters = this.getFilters();
        }
    }

    initVisitPatientsSelect() {
        this.patientsSelect = new TomSelect('.visit-patients-select', {
            create: false,
            plugins: ['remove_button'],
            sortField: {
                field: 'value',
                direction: 'asc'
            },
            render: {
                'no_results': function () {
                    return '<div class="no-results">Ничего не найдено</div>';
                }
            }
        });
    }

    allowToShowMore() {
        this.canShowMore = true;
    }

    forbidToShowMore() {
        this.canShowMore = false;
    }

    showMore() {
        const showMoreListener = _ => {
            if (
                ((this.domElements.showMoreVisitsBtn.getBoundingClientRect().top - document.documentElement.clientHeight) < 0)
                && this.searchingMore === false
                && this.canShowMore === true
            ) {
                this.searchingMore = true;
                this.showVisits(false);
            }
        };

        this.addEvent(window, 'scroll', showMoreListener);
    }

    showVisits(needToClear = false) {
        this.visitsListView.showLoader();
        this.model.get(this.visitsListView.getOffset(), this.filters, this.mode)
            .then(result => {
                if (typeof result !== 'string') {
                    if (result.error === true) {
                        console.error(result);
                    } else {
                        if (needToClear === true) {
                            this.visitsListView.clear();
                        }
                        this.visitsListView.render(result, this.forbidToShowMore, this.mode);
                        this.searchingMore = false;
                    }
                } else {
                    console.error(result);
                }
            })
            .catch(error => {
                console.error(error);
            });
    }

    acceptFilters() {
        this.addEvent(this.domElements.acceptVisitsFiltersBtn, 'click', _ => {
            this.filters = this.getFilters();
            if (JSON.stringify(this.filters) !== JSON.stringify(this.prevFilters)) {
                this.prevFilters = this.filters;
                this.visitsListView.reset(this.allowToShowMore, this.forbidToShowMore);
                this.showVisits(true);
            }
        });
    }

    getFilters() {
        let filters = {};

        if (this.statusesSelect) {
            filters.statuses = JSON.stringify(this.statusesSelect.getValue());
        }

        if (this.doctorsSelect && this.mode === 'administrator') {
            if (this.doctorsSelect.getValue().length !== 0) {
                filters.doctors = JSON.stringify(this.doctorsSelect.getValue());
            }
        }

        if (this.patientsSelect && (this.mode === 'administrator' || this.mode === 'doctor')) {
            if (this.patientsSelect.getValue().length !== 0) {
                filters.patients = JSON.stringify(this.patientsSelect.getValue());
            }
        }

        if (this.illnessesSelect && this.mode === 'patient') {
            if (this.illnessesSelect.getValue().length !== 0) {
                filters.illnesses = JSON.stringify(this.illnessesSelect.getValue());
            }
        }

        if (this.datePicker.selectedDates.length > 0) {
            filters.date_start = Helper.parseDateToString(this.datePicker.selectedDates[0]);
            filters.date_end = Helper.parseDateToString(this.datePicker.selectedDates[1]);
        }

        return filters;
    }
}
