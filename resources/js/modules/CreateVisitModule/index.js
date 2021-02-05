import CreateVisitController from "./CreateVisitController";
import VisitModel from "./VisitModel";

document.addEventListener('DOMContentLoaded', _ => {
    const visitDestinationSelect = document.querySelector('.visit-destination-select');
    const visitPatientSelect = document.querySelector('.visit-patient-select');
    const createVisitBtn = document.querySelector('.create-visit-btn');
    const causeTextarea = document.querySelector('textarea[name=\'cause\']');
    const timeInput = document.querySelector('input[name=\'visit_time\']');
    const dateInput = document.querySelector('input[name=\'visit_date\']');
    const errorBox = document.querySelector('.error-message');
    const successBox = document.querySelector('.success-message');

    new CreateVisitController({
        visitDestinationSelect,
        visitPatientSelect,
        createVisitBtn,
        causeTextarea,
        timeInput,
        dateInput,
        errorBox,
        successBox
    }, new VisitModel());
});
