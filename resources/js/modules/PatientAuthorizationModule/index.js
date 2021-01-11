import PatientAuthorizationController from "./PatientAuthorizationController";
import PatientAuthorizationModel from "./PatientAuthorizationModel";

document.addEventListener('DOMContentLoaded', _ => {
    if (location.pathname === '/patient/login') {
        const form = document.querySelector('#patientLoginForm');

        if (form) {
            const phoneCodeInput = document.querySelector('#patientLoginForm input[name=\'phone_code\']');
            const phoneInput = document.querySelector('#patientLoginForm input[name=\'phone\']');
            const needToSaveCheckbox = document.querySelector('#patientLoginForm input[name=\'need_to_save\']');
            const phoneNotRegisteredMessage = document.querySelector('#patientLoginForm #phoneNotRegisteredMessage');
            const authByPasswordBtn = document.querySelector('#authByPasswordBtn');
            const authBySmsCodeBtn = document.querySelector('#authBySmsCodeBtn');
            const passwordInput = document.querySelector('#patientLoginPasswordInput');
            const smsCodeInput = document.querySelector('#patientLoginSMSCodeInput');
            const patientLoginSMSCodeForm = document.querySelector('#patientLoginSMSCodeForm');

            let errorBoxAboutCode = null;

            if (patientLoginSMSCodeForm) {
                errorBoxAboutCode = patientLoginSMSCodeForm.parentElement.querySelector('.error-message');
            }

            new PatientAuthorizationController({
                phoneCodeInput,
                phoneInput,
                needToSaveCheckbox,
                phoneNotRegisteredMessage,
                authByPasswordBtn,
                authBySmsCodeBtn,
                passwordInput,
                smsCodeInput,
                patientLoginSMSCodeForm,
                errorBoxAboutCode
            }, new PatientAuthorizationModel());
        }
    }
});
