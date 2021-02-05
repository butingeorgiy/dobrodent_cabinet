import EditVisitModel from "./EditVisitModel";
import EditStatusController from "./EditStatusController";
import EditDateAndTimeController from "./EditDateAndTimeController";
import AttachIllnessController from "./AttachIllnessController";
import EditResultController from "./EditResultController";
import AttachFilesController from "./AttachFilesController";
import EditDoctorController from "./EditDoctorController";
import EditPatientController from "./EditPatientController";

document.addEventListener('DOMContentLoaded', _ => {
    const editStatusBtn = document.querySelector('.edit-visit-status-btn');
    const statusesSelect = document.querySelector('.edit-visit-status-select');
    const saveStatusBtn = document.querySelector('.edit-visit-status-popup .save-visit-status-btn');
    const errorStatusEditing = document.querySelector('.edit-visit-status-popup .error-message');
    const successStatusEditing = document.querySelector('.edit-visit-status-popup .success-message');

    if (editStatusBtn && statusesSelect && saveStatusBtn && errorStatusEditing && successStatusEditing) {
        new EditStatusController({
            editStatusBtn,
            statusesSelect,
            saveStatusBtn,
            errorStatusEditing,
            successStatusEditing
        }, new EditVisitModel());
    }


    const editTimeAndDateBtn = document.querySelector('.move-visit-btn');
    const inputsContainer = document.querySelector('.move-visit-inputs-container');
    const errorTimeAndDateEditing = document.querySelector('.move-visit-popup .error-message');
    const successTimeAndDateEditing = document.querySelector('.move-visit-popup .success-message');
    const saveTimeAndDateBtn = document.querySelector('.move-visit-popup .save-visit-moving-btn');

    if (editTimeAndDateBtn && inputsContainer && errorTimeAndDateEditing && successTimeAndDateEditing && saveTimeAndDateBtn) {
        new EditDateAndTimeController({
            editTimeAndDateBtn,
            inputsContainer,
            errorTimeAndDateEditing,
            successTimeAndDateEditing,
            saveTimeAndDateBtn
        }, new EditVisitModel());
    }

    const editIllnessBtn = document.querySelector('.edit-visit-illness-btn');
    const illnessesSelect = document.querySelector('.attach-illness-select');
    const errorIllnessAttaching = document.querySelector('.attach-illness-popup .error-message');
    const successIllnessAttaching = document.querySelector('.attach-illness-popup .success-message');
    const attachIllnessBtn = document.querySelector('.attach-illness-btn');

    if (editIllnessBtn && illnessesSelect && errorIllnessAttaching && successIllnessAttaching && attachIllnessBtn) {
        new AttachIllnessController({
            editIllnessBtn,
            illnessesSelect,
            errorIllnessAttaching,
            successIllnessAttaching,
            attachIllnessBtn
        }, new EditVisitModel());
    }

    const editResultBtn = document.querySelector('.edit-visit-result-btn');
    const resultEditor = document.querySelector('.visit-result-editor');
    const errorResultEditing = document.querySelector('.edit-visit-result-popup .error-message');
    const successResultEditing = document.querySelector('.edit-visit-result-popup .success-message');
    const saveResultBtn = document.querySelector('.save-visit-result-btn');

    if (editResultBtn && resultEditor && errorResultEditing && successResultEditing && saveResultBtn) {
        new EditResultController({
            editResultBtn,
            resultEditor,
            errorResultEditing,
            successResultEditing,
            saveResultBtn
        }, new EditVisitModel());
    }

    const uploadFileInput = document.querySelector('input[name=\'attachment\']');
    const uploadFileForm = document.querySelector('.upload-attachment-form');

    if (uploadFileInput && uploadFileForm) {
        new AttachFilesController({
            uploadFileInput,
            uploadFileForm
        }, new EditVisitModel());
    }

    const changeDoctorBtn = document.querySelector('.edit-visit-doctor-btn');
    const changeDoctorSelect = document.querySelector('.edit-visit-doctor-select');
    const errorDoctorEditing = document.querySelector('.edit-visit-doctor-popup .error-message');
    const successDoctorEditing = document.querySelector('.edit-visit-doctor-popup .success-message');
    const saveDoctorBtn = document.querySelector('.save-visit-doctor-btn');

    if (changeDoctorBtn && changeDoctorSelect && errorDoctorEditing && successDoctorEditing && saveDoctorBtn) {
        new EditDoctorController({
            changeDoctorBtn,
            changeDoctorSelect,
            errorDoctorEditing,
            successDoctorEditing,
            saveDoctorBtn
        }, new EditVisitModel());
    }

    const changePatientBtn = document.querySelector('.edit-visit-patient-btn');
    const changePatientSelect = document.querySelector('.edit-visit-patient-select');
    const errorPatientEditing = document.querySelector('.edit-visit-patient-popup .error-message');
    const successPatientEditing = document.querySelector('.edit-visit-patient-popup .success-message');
    const savePatientBtn = document.querySelector('.save-visit-patient-btn');

    if (changePatientBtn && changePatientSelect && errorPatientEditing && successPatientEditing && savePatientBtn) {
        new EditPatientController({
            changePatientBtn,
            changePatientSelect,
            errorPatientEditing,
            successPatientEditing,
            savePatientBtn
        }, new EditVisitModel());
    }
});
