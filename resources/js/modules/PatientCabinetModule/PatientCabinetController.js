import PatientProfileFormView from "./PatientProfileFormView";
import EventHandler from "../../EventHandler";
import flatpickr from "flatpickr";
import {Russian} from "flatpickr/dist/l10n/ru";
import Helper from "../../Helper";

export default class PatientCabinetController extends EventHandler {
    constructor(domElements) {
        super();

        this.domElements = domElements;

        this.saveProfileDataChanges = this.saveProfileDataChanges.bind(this);

        if (domElements.patientProfileForm) {
            this.saveProfileDataChanges();
            this.duplicateGanderValueIntoHiddenInput();
            this.showProfilePhotoAfterChanging();
        }

        if (this.domElements.patientBirthdayInput) {
            this.initBirthdayInput();
        }
    }

    initBirthdayInput() {
        this.datePicker = flatpickr(this.domElements.patientBirthdayInput, {
            dateFormat: 'd.m.Y',
            locale: Russian,
            onChange: (selectedDates, dateStr, instance) => {
                this.domElements.patientBirthdayHiddenInput.value = Helper.parseDateToString(selectedDates[0]);
                console.log(this.domElements.patientBirthdayHiddenInput.value);
            }
        });
    }

    saveProfileDataChanges() {
        if (
            this.domElements.savePatientProfileBtn &&
            this.domElements.confirmPatientProfileBtn &&
            this.domElements.patientProfileFormErrorBox
        ) {
            const formView = new PatientProfileFormView(this.domElements.patientProfileForm);

            this.addEvent(this.domElements.savePatientProfileBtn, 'click', _ => {
                formView.moveToConfirmation(
                    this.domElements.patientProfileFormErrorBox,
                    this.domElements.savePatientProfileBtn,
                    this.domElements.confirmPatientProfileBtn.parentElement.parentElement
                );
            });
        }
    }

    duplicateGanderValueIntoHiddenInput() {
        const hiddenInput = this.domElements.patientProfileForm.querySelector('input[name=\'gender\']');
        const select  = this.domElements.patientProfileForm.querySelector('select[name=\'gender\']');

        if (hiddenInput && select) {
            this.addEvent(select, 'change', event => {
                hiddenInput.value = event.currentTarget.value;
            });
        }
    }

    showProfilePhotoAfterChanging() {
        const input = this.domElements.patientProfileForm.querySelector('input[name=\'profile_photo\']');
        const label = input.parentElement;

        if (input && label) {
            this.addEvent(input, 'change', event => {
                const file = event.target.files[0];
                const reader = new FileReader();

                reader.onload = f => {
                    label.style.backgroundImage = `url(${f.target.result})`;
                }

                reader.readAsDataURL(file);
            });
        }
    }
}
