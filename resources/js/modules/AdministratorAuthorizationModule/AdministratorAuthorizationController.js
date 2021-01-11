import Inputmask from "inputmask/lib/inputmask";

export default class AdministratorAuthorizationController {
    constructor(domElements) {
        this.domElements = domElements;

        this.setInputMasks();
    }

    setInputMasks() {
        if (this.domElements.phoneInput) {
            new Inputmask({
                mask: '+7 (999) 999 9999'
            }).mask(this.domElements.phoneInput);
        }
    }
}
