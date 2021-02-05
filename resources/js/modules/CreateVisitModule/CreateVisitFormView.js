export default class CreateVisitFormView {
    constructor(desc, patient, cause, time, date, btn, error, success) {
        this.descSelect = desc;
        this.patientSelect = patient;
        this.causeTextarea = cause;
        this.timeInput = time;
        this.dateInput = date;
        this.btn = btn;
        this.error = error;
        this.success = success;
    }

    disable() {
        this.descSelect.disable();
        this.causeTextarea.setAttribute('disabled', 'disabled');
        this.timeInput.setAttribute('disabled', 'disabled');
        this.timeInput.parentElement.classList.add('opacity-50');
        this.dateInput.setAttribute('disabled', 'disabled');
        this.dateInput.parentElement.classList.add('opacity-50');
        this.btn.remove();

        if (this.patientSelect) {
            this.patientSelect.disable();
        }
    }

    showSuccessStatus(msg) {
        this.success.classList.remove('hidden');
        this.success.querySelector('span')
            .innerText = msg;
    }

    showErrorStatus(msg) {
        this.error.classList.remove('hidden');
        this.error.querySelector('span')
            .innerText = msg;
    }

    hideMessages() {
        this.success.classList.add('hidden');
        this.error.classList.add('hidden');
    }
}
