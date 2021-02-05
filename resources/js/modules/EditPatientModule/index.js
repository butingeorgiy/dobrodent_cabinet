import EditPatientController from "./EditPatientController";
import EditPatientModel from "./EditPatientModel";

document.addEventListener('DOMContentLoaded', _ => {
    const editPatientBtn = document.querySelector('.edit-patient-data-btn');
    const editPatientInputsContainer = document.querySelector('.edit-patient-popup .inputs-container');
    const editPatientErrorMessage = document.querySelector('.edit-patient-popup .error-message');
    const editPatientSuccessMessage = document.querySelector('.edit-patient-popup .success-message');
    const savePatientEditingBtn = document.querySelector('.save-patient-data-btn');

    if (
        editPatientBtn &&
        editPatientInputsContainer &&
        editPatientErrorMessage &&
        editPatientSuccessMessage &&
        savePatientEditingBtn
    ) {
        new EditPatientController({
            editPatientBtn,
            editPatientInputsContainer,
            editPatientErrorMessage,
            editPatientSuccessMessage,
            savePatientEditingBtn
        }, new EditPatientModel());
    }
});
