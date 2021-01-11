import Inputmask from "inputmask/lib/inputmask";
import PatientAuthorizationView from "./PatientAuthorizationView";
import EventHandler from "../../EventHandler";

export default class PatientAuthorizationController extends EventHandler {

    constructor(domElements, model) {
        super();

        this.domElements = domElements;
        this.model = model;

        this.setInputMasks = this.setInputMasks.bind(this);
        this.checkPhoneOnRegistration = this.checkPhoneOnRegistration.bind(this);
        this.manageListenersOfAuthButtons = this.manageListenersOfAuthButtons.bind(this);
        this.moveToSecondStep = this.moveToSecondStep.bind(this);
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
        if (this.domElements.phoneInput && this.domElements.phoneCodeInput && this.domElements.phoneNotRegisteredMessage) {
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
                                    PatientAuthorizationView.manageAccessToSecondStep(
                                        result.isExist,
                                        this.domElements.phoneNotRegisteredMessage,
                                        this.domElements.authByPasswordBtn,
                                        this.domElements.authBySmsCodeBtn,
                                        this.manageListenersOfAuthButtons
                                    );
                                }
                            } else {
                                console.error(result);
                            }
                        })
                        .catch(error => console.error(error));
                } else {
                    this.domElements.authByPasswordBtn.removeEventListener('click', this.moveToSecondStep);
                    this.domElements.authBySmsCodeBtn.removeEventListener('click', this.moveToSecondStep);

                    PatientAuthorizationView.manageMessageOfPhoneRegistration(
                        false,
                        this.domElements.phoneNotRegisteredMessage
                    );
                    PatientAuthorizationView.manageButtons(
                        true,
                        this.domElements.authByPasswordBtn,
                        this.domElements.authBySmsCodeBtn,
                        this.manageListenersOfAuthButtons
                    )
                }
            });
        }
    }

    manageListenersOfAuthButtons(needToRemove = true) {
        if (typeof needToRemove !== 'boolean') {
            console.error(`Undefined type of needToRemove variable: ${needToRemove}`);
            return false;
        }

        if (needToRemove) {
            this.removeAllListeners(this.domElements.authByPasswordBtn, 'click');
            this.removeAllListeners(this.domElements.authBySmsCodeBtn, 'click');
        } else {
            this.addEvent(
                this.domElements.authByPasswordBtn,
                'click',
                _ => {
                    this.moveToSecondStep('password');
                }
            );
            this.addEvent(
                this.domElements.authBySmsCodeBtn,
                'click',
                _ => {
                    this.moveToSecondStep('code');
                }
            );
        }
    }

    moveToSecondStep(type = 'password') {
        if (type !== 'password' && type !== 'code') {
            console.error(`Undefined type of type variable: ${type}`);
            return false;
        } else {
            const phoneCode = this.domElements.phoneCodeInput.value.replace(/[^\d]/g, '');
            const phone = this.domElements.phoneInput.value.replace(/[^\d]/g, '');
            const needToSave = this.domElements.needToSaveCheckbox.checked;

            location.assign(location.origin + `/patient/login?step=2&type=${type}&phone=${phoneCode + phone}&save=${needToSave}`);
            return true;
        }
    }

    sendFormWithSecureCode() {
        if (this.domElements.smsCodeInput && this.domElements.patientLoginSMSCodeForm) {
            this.addEvent(this.domElements.smsCodeInput, 'keydown', event => {
                if(event.keyCode === 13) { event.preventDefault(); }
            });

            this.addEvent(this.domElements.smsCodeInput, 'input', event => {
                const code = event.currentTarget.value.replace(/[^\d]/g, '');
                if (code.length >= 4) { this.domElements.patientLoginSMSCodeForm.submit(); }
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
