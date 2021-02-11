import PatientCabinetController from "./PatientCabinetController";

document.addEventListener('DOMContentLoaded', _ => {
    const patientProfileForm = document.querySelector('#patientProfileForm');
    const savePatientProfileBtn = document.querySelector('#savePatientProfileBtn');
    const confirmPatientProfileBtn = document.querySelector('#confirmPatientProfileBtn');
    const patientProfileFormErrorBox = document.querySelector('#patientProfileForm .error-message');
    const patientBirthdayInput = document.querySelector('#patientProfileForm input[name=\'birthday\'][type=\'text\']');
    const patientBirthdayHiddenInput = document.querySelector('#patientProfileForm input[name=\'birthday\'][type=\'hidden\']');

    new PatientCabinetController({
        patientProfileForm,
        savePatientProfileBtn,
        confirmPatientProfileBtn,
        patientProfileFormErrorBox,
        patientBirthdayInput,
        patientBirthdayHiddenInput
    });
});
