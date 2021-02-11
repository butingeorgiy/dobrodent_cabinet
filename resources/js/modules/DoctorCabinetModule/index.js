import DoctorCabinetController from "./DoctorCabinetController";

document.addEventListener('DOMContentLoaded', _ => {
    const doctorProfileForm = document.querySelector('#doctorProfileForm');
    const saveDoctorProfileBtn = document.querySelector('#saveDoctorProfileBtn');
    const confirmDoctorProfileBtn = document.querySelector('#confirmDoctorProfileBtn');
    const doctorProfileFormErrorBox = document.querySelector('#doctorProfileForm .error-message');
    const doctorBirthdayInput = document.querySelector('#doctorProfileForm input[name=\'birthday\'][type=\'text\']');
    const doctorBirthdayHiddenInput = document.querySelector('#doctorProfileForm input[name=\'birthday\'][type=\'hidden\']');

    const descriptionEditor = document.querySelector('#doctorDescriptionEditor');
    const doctorProfessionalInfoForm = document.querySelector('#doctorProfessionalInfoForm');
    const saveDoctorProfessionalInfoBtn = document.querySelector('#saveDoctorProfessionalInfoBtn');
    const confirmDoctorProfessionalInfoBtn = document.querySelector('#confirmDoctorProfessionalInfoBtn');
    const doctorProfessionalInfoErrorBox = document.querySelector('#doctorProfessionalInfoForm .error-message');
    const occupationsSelect = document.querySelector('.occupation-select');

    new DoctorCabinetController({
        doctorProfileForm,
        saveDoctorProfileBtn,
        confirmDoctorProfileBtn,
        doctorProfileFormErrorBox,
        descriptionEditor,
        doctorProfessionalInfoForm,
        saveDoctorProfessionalInfoBtn,
        confirmDoctorProfessionalInfoBtn,
        doctorProfessionalInfoErrorBox,
        occupationsSelect,
        doctorBirthdayInput,
        doctorBirthdayHiddenInput
    });
});
