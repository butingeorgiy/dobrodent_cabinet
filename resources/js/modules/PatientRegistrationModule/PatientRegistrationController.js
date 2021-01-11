import EventHandler from "../../EventHandler";
import Inputmask from "inputmask/lib/inputmask";
import PatientRegistrationView from "./PatientRegistrationView";

export default class PatientRegistrationController extends EventHandler {
    constructor(domElements, model) {
        super();

        this.domElements = domElements;
        this.model = model;

        this.setInputMasks = this.setInputMasks.bind(this);
        this.checkPhoneOnRegistration = this.checkPhoneOnRegistration.bind(this);
        this.manageListenerOfMoveToSecondStepBtn = this.manageListenerOfMoveToSecondStepBtn.bind(this);
        this.sendFormWithSecureCode = this.sendFormWithSecureCode.bind(this);

        this.setInputMasks();
        this.checkPhoneOnRegistration();
        this.sendFormWithSecureCode();
    }

    setInputMasks() {
        if (this.domElements.phoneCodeInput) {
            new Inputmask({
                mask: '+9'
            }).mask(this.domElements.phoneCodeInput);
        }

        if (this.domElements.phoneInput) {
            new Inputmask({
                mask: '(999) 999 9999'
            }).mask(this.domElements.phoneInput);
        }

        if (this.domElements.smsCodeInput) {
            new Inputmask({
                mask: '9999'
            }).mask(this.domElements.smsCodeInput);
        }
    }

    checkPhoneOnRegistration() {
        if (this.domElements.phoneInput && this.domElements.phoneCodeInput && this.domElements.phoneIsRegisteredMessage) {
            this.addEvent(this.domElements.phoneInput, 'input', event => {
                const val = event.currentTarget.value.replace(/[^\d]/g, '');

                if (val.length >= 10) {
                    this.model.requestForCheckPhone(
                        this.domElements.phoneCodeInput.value.replace(/[^\d]/g, '') + val
                    )
                        .then(result => {
                            if (typeof result !== "string") {
                                if (result.error === true) {
                                    console.error(result);
                                } else {
                                    PatientRegistrationView.manageAccessToSecondStep(
                                        result.isExist,
                                        this.domElements.phoneIsRegisteredMessage,
                                        this.domElements.moveToSecondStepBtn,
                                        this.manageListenerOfMoveToSecondStepBtn
                                    );
                                }
                            } else {
                                console.error(result);
                            }
                        })
                        .catch(error => console.error(error));
                } else {
                    PatientRegistrationView.manageMessageOfPhoneRegistration(false, this.domElements.phoneIsRegisteredMessage);
                    PatientRegistrationView.manageButtons(true, this.domElements.moveToSecondStepBtn, this.manageListenerOfMoveToSecondStepBtn);
                }
            });
        }
    }

    manageListenerOfMoveToSecondStepBtn(needToRemove = true) {
        if (typeof needToRemove !== 'boolean') {
            console.error(`Undefined type of needToRemove variable: ${needToRemove}`);
            return false;
        }

        if (needToRemove) {
            this.removeAllListeners(this.domElements.moveToSecondStepBtn, 'click');
        } else {
            this.addEvent(
                this.domElements.moveToSecondStepBtn,
                'click',
                _ => {
                    const phoneCode = this.domElements.phoneCodeInput.value.replace(/[^\d]/g, '');
                    const phone = this.domElements.phoneInput.value.replace(/[^\d]/g, '');

                    location.assign(location.origin + `/patient/registration?step=2&phone=${phoneCode + phone}`);
                    return true;
                }
            );
        }
    }

    sendFormWithSecureCode() {
        if (this.domElements.smsCodeInput && this.domElements.patientRegSMSCodeForm) {
            this.addEvent(this.domElements.smsCodeInput, 'keydown', event => {
                if(event.keyCode === 13) { event.preventDefault(); }
            });

            this.addEvent(this.domElements.smsCodeInput, 'input', event => {
                const code = event.currentTarget.value.replace(/[^\d]/g, '');
                if (code.length >= 4) { this.domElements.patientRegSMSCodeForm.submit(); }
            });

            this.addEvent(this.domElements.smsCodeInput, 'click', _ => {
                if (this.domElements.errorBoxAboutCode) {
                    this.domElements.errorBoxAboutCode.classList.add('hidden');
                    this.removeAllListeners(this.domElements.smsCodeInput, 'click');
                }
            });
        }
    }
}
