import PatientCabinetController from "./PatientCabinetController";

document.addEventListener('DOMContentLoaded', _ => {
    const patientProfileForm = document.querySelector('#patientProfileForm');
    const savePatientProfileBtn = document.querySelector('#savePatientProfileBtn');
    const confirmPatientProfileBtn = document.querySelector('#confirmPatientProfileBtn');
    const patientProfileFormErrorBox = document.querySelector('#patientProfileForm .error-message');

    new PatientCabinetController({
        patientProfileForm,
        savePatientProfileBtn,
        confirmPatientProfileBtn,
        patientProfileFormErrorBox
    });
});
