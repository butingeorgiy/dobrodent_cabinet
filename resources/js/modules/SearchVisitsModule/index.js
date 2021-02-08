import ShowVisitsController from "./ShowVisitsController";
import ShowVisitsModel from "./ShowVisitsModel";

document.addEventListener('DOMContentLoaded', _ => {
    const showVisitsFiltersBtn = document.querySelector('.show-visits-filters-btn');
    const visitsFilters = document.querySelector('.visits-filters');
    const visitStatusesSelect = document.querySelector('.visit-statuses-select');
    const showMoreVisitsBtn = document.querySelector('#showMoreVisitsBtn');
    const visitsContainer = document.querySelector('.visit-list');
    const acceptVisitsFiltersBtn = document.querySelector('.accept-filters-btn');
    const visitsAmountIndicator = document.querySelector('.visits-amount');
    const visitDoctorsSelect = document.querySelector('.visit-doctors-select');
    const visitPatientSelect = document.querySelector('.visit-patients-select');
    const visitIllnessesSelect = document.querySelector('.visit-illnesses-select');
    const dateStartInput = document.querySelector('input[name=\'date_start\']');
    const dateEndInput = document.querySelector('input[name=\'date_end\']');

    new ShowVisitsController({
        showVisitsFiltersBtn,
        visitsFilters,
        visitStatusesSelect,
        showMoreVisitsBtn,
        visitsContainer,
        acceptVisitsFiltersBtn,
        visitsAmountIndicator,
        visitDoctorsSelect,
        visitPatientSelect,
        visitIllnessesSelect,
        dateStartInput,
        dateEndInput
    }, new ShowVisitsModel());
});