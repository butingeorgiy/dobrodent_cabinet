import BaseEditPopupView from "../../base/BaseEditPopupView";

export default class ReviewPopupView extends BaseEditPopupView {
    constructor(btn, error, success, content, markButtons) {
        super(btn, error, success, content);

        this.markButtons = markButtons;
    }

    toggleMarkButton(btn) {
        this.markButtons.forEach(markBtn => {
            markBtn.classList.remove('active');
        });

        btn.classList.add('active');
    }
}
