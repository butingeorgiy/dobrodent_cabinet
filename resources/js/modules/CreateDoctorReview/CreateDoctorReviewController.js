import EventHandler from "../../EventHandler";
import ReviewPopupView from "./ReviewPopupView";
import PopupController from "../PopupModule/PopupController";
import PopupView from "../PopupModule/PopupView";

export default class CreateDoctorReviewController extends EventHandler {
    constructor(domElements, model) {
        super();

        this.domElements = domElements;
        this.model = model;
        this.mark = null;
        this.doctorId = location.pathname.split('/')[3];

        this.addListenerForSaveReview = this.addListenerForSaveReview.bind(this);
        this.removeListenerForSaveReview = this.removeListenerForSaveReview.bind(this);
        this.saveReview = this.saveReview.bind(this);

        this.popupView = new ReviewPopupView(
            domElements.saveReviewBtn,
            domElements.errorReviewSaving,
            domElements.successReviewSaving,
            domElements.reviewComment.parentElement,
            domElements.marksButtons
        );

        this.popup = new PopupView('.create-doctor-review-popup');

        this.openPopupForAttachIllness();
        this.chooseMark();

        if (location.hash === '#create-review') {
            location.hash = '';
            PopupController.open(this.popup, false, null, this.addListenerForSaveReview)
                .then()
                .catch(error => console.error(error));
        }
    }

    chooseMark() {
        this.domElements.marksButtons.forEach(btn => {
            this.addEvent(btn, 'click', event => {
                this.mark = event.currentTarget.getAttribute('data-mark');
                this.popupView.toggleMarkButton(event.currentTarget);
            });
        });
    }

    openPopupForAttachIllness() {
        this.addEvent(this.domElements.openReviewPopupBtn, 'click', event => {
            event.preventDefault();
            PopupController.open(this.popup, false, null, this.addListenerForSaveReview)
                .then()
                .catch(error => console.error(error));
        });
    }

    addListenerForSaveReview() {
        this.addEvent(this.domElements.saveReviewBtn, 'click', this.saveReview);
    }

    removeListenerForSaveReview() {
        this.removeAllListeners(this.domElements.saveReviewBtn, 'click');
    }

    saveReview() {
        const comment = this.domElements.reviewComment.value;

        if (!this.mark) {
            this.popupView.showErrorMessage('Необходимо поставить оценку');
            return false;
        }

        this.popupView.showLoader(this.removeListenerForSaveReview);

        this.model.create({
            comment,
            doctor_id: this.doctorId,
            mark: this.mark
        }).then(result => {
            if (typeof result !== 'string') {
                if (result.error === true) {
                    this.popupView.showErrorMessage(result.message);
                    this.popupView.hideLoader(this.addListenerForSaveReview);
                } else {
                    this.popupView.showSuccessMessage(result.success);
                    setTimeout(_ => location.replace(location.pathname), 1000);
                }
            } else {
                this.popupView.hideLoader(this.addListenerForSaveReview);
                console.error(result);
            }
        }).catch(error => {
            this.popupView.hideLoader(this.addListenerForSaveReview);
            console.error(error);
        })
    }
}
