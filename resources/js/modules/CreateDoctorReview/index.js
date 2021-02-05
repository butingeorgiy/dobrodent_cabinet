import CreateDoctorReviewController from "./CreateDoctorReviewController";
import CreateDoctorReviewModel from "./CreateDoctorReviewModel";

document.addEventListener('DOMContentLoaded', _ => {
    const marksButtons = document.querySelectorAll('.mark-btn');
    const markInput = document.querySelector('.create-doctor-review-popup input[name=\'mark\']');
    const doctorInput = document.querySelector('.create-doctor-review-popup input[name=\'doctor_id\']');
    const reviewComment = document.querySelector('textarea[name=\'comment\']');
    const saveReviewBtn = document.querySelector('.save-review-btn');
    const openReviewPopupBtn = document.querySelector('.open-review-popup-btn');
    const errorReviewSaving = document.querySelector('.create-doctor-review-popup .error-message');
    const successReviewSaving = document.querySelector('.create-doctor-review-popup .success-message');

    if (
        marksButtons.length === 3 &&
        markInput &&
        doctorInput &&
        reviewComment &&
        saveReviewBtn &&
        openReviewPopupBtn &&
        errorReviewSaving &&
        successReviewSaving
    ) {
        new CreateDoctorReviewController({
            marksButtons,
            markInput,
            doctorInput,
            reviewComment,
            saveReviewBtn,
            openReviewPopupBtn,
            errorReviewSaving,
            successReviewSaving
        }, new CreateDoctorReviewModel());
    }
});
