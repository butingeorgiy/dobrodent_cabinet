import EventHandler from "../../EventHandler";
import DoctorProfileFormView from "./DoctorProfileFormView";
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import DoctorProfessionalInfoFormView from "./DoctorProfessionalInfoFormView";
import TomSelect from "tom-select";
import flatpickr from "flatpickr";
import {Russian} from "flatpickr/dist/l10n/ru";
import Helper from "../../Helper";

export default class DoctorCabinetController extends EventHandler {
    constructor(domElements) {
        super();

        this.domElements = domElements;

        this.saveProfileDataChanges = this.saveProfileDataChanges.bind(this);
        this.saveProfessionalDataChanges = this.saveProfessionalDataChanges.bind(this);
        this.duplicateDescriptionValueIntoHiddenInput = this.duplicateDescriptionValueIntoHiddenInput.bind(this);

        if (domElements.occupationsSelect) {
            this.initOccupationsSelect();
        }

        if (domElements.doctorProfileForm) {
            this.initBirthdayInput();
            this.saveProfileDataChanges();
            this.duplicateGanderValueIntoHiddenInput();
            this.showProfilePhotoAfterChanging();
        }

        if (domElements.descriptionEditor) {
            this.initDescriptionEditor();
        }
    }

    initBirthdayInput() {
        this.datePicker = flatpickr(this.domElements.doctorBirthdayInput, {
            dateFormat: 'd.m.Y',
            locale: Russian,
            onChange: (selectedDates, dateStr, instance) => {
                this.domElements.doctorBirthdayHiddenInput.value = Helper.parseDateToString(selectedDates[0]);
                console.log(this.domElements.doctorBirthdayHiddenInput.value);
            }
        });
    }

    saveProfileDataChanges() {
        if (
            this.domElements.saveDoctorProfileBtn &&
            this.domElements.confirmDoctorProfileBtn &&
            this.domElements.doctorProfileFormErrorBox
        ) {
            const formView = new DoctorProfileFormView(this.domElements.doctorProfileForm);

            this.addEvent(this.domElements.saveDoctorProfileBtn, 'click', _ => {
                formView.moveToConfirmation(
                    this.domElements.doctorProfileFormErrorBox,
                    this.domElements.saveDoctorProfileBtn,
                    this.domElements.confirmDoctorProfileBtn.parentElement.parentElement
                );
            });
        }
    }

    duplicateGanderValueIntoHiddenInput() {
        const hiddenInput = this.domElements.doctorProfileForm.querySelector('input[name=\'gender\']');
        const select  = this.domElements.doctorProfileForm.querySelector('select[name=\'gender\']');

        if (hiddenInput && select) {
            this.addEvent(select, 'change', event => {
                hiddenInput.value = event.currentTarget.value;
            });
        }
    }

    duplicateOccupationValueIntoHiddenInput() {
        const hiddenInput = this.domElements.doctorProfessionalInfoForm.querySelector('input[name=\'occupation\']');

        if (hiddenInput) {
            this.occupationsSelect.on('change', _ => {
                hiddenInput.value = JSON.stringify(this.occupationsSelect.getValue());
            });
        }
    }

    duplicateDescriptionValueIntoHiddenInput() {
        const hiddenInput = this.domElements.doctorProfessionalInfoForm.querySelector('input[name=\'description\']');

        if (hiddenInput) {
            hiddenInput.value = this.descriptionEditor.getData();
        }
    }

    showProfilePhotoAfterChanging() {
        const input = this.domElements.doctorProfileForm.querySelector('input[name=\'profile_photo\']');
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

    initDescriptionEditor() {
        ClassicEditor
            .create(this.domElements.descriptionEditor)
            .then(editor => {
                this.descriptionEditor = editor;

                if (this.domElements.doctorProfessionalInfoForm) {
                    this.saveProfessionalDataChanges();
                    this.duplicateOccupationValueIntoHiddenInput();
                }
            })
            .catch(error => console.error(error));
    }

    initOccupationsSelect() {
        this.occupationsSelect = new TomSelect('.occupation-select',{
            create: false,
            plugins: ['remove_button'],
            render: {
                'no_results': _ => {
                    return '<div class="no-results">Ничего не найдено</div>';
                }
            }
        });
    }

    saveProfessionalDataChanges() {
        if (
            this.domElements.saveDoctorProfessionalInfoBtn &&
            this.domElements.confirmDoctorProfessionalInfoBtn
        ) {
            const formView = new DoctorProfessionalInfoFormView(
                this.domElements.doctorProfessionalInfoForm,
                this.descriptionEditor,
                this.occupationsSelect
            );

            this.addEvent(this.domElements.saveDoctorProfessionalInfoBtn, 'click', _ => {
                formView.moveToConfirmation(
                    this.domElements.doctorProfessionalInfoErrorBox,
                    this.domElements.saveDoctorProfessionalInfoBtn,
                    this.domElements.confirmDoctorProfessionalInfoBtn.parentElement.parentElement,
                    this.duplicateDescriptionValueIntoHiddenInput
                );
            });
        }
    }
}
