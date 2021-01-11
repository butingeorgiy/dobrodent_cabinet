import PatientRegistrationController from "./PatientRegistrationController";
import PatientRegistrationModel from "./PatientRegistrationModel";

document.addEventListener('DOMContentLoaded', _ => {
    if (location.pathname === '/patient/registration') {
        const form = document.querySelector('#patientRegForm');

        if (form) {
            const phoneCodeInput = document.querySelector('#patientRegForm input[name=\'phone_code\']');
            const phoneInput = document.querySelector('#patientRegForm input[name=\'phone\']');
            const phoneIsRegisteredMessage = document.querySelector('#patientRegForm #phoneNotRegisteredMessage');
            const moveToSecondStepBtn = document.querySelector('#patientRegForm #moveToSecondStepBtn');
            const smsCodeInput = document.querySelector('#patientRegForm #patientRegSMSCodeInput');
            const patientRegSMSCodeForm = document.querySelector('#patientRegForm #patientRegSMSCodeForm');

            let errorBoxAboutCode = null;

            if (patientRegSMSCodeForm) {
                errorBoxAboutCode = patientRegSMSCodeForm.parentElement.querySelector('.error-message');
            }

            new PatientRegistrationController({
                phoneCodeInput,
                phoneInput,
                phoneIsRegisteredMessage,
                moveToSecondStepBtn,
                smsCodeInput,
                patientRegSMSCodeForm,
                errorBoxAboutCode
            }, new PatientRegistrationModel());
        }
    }
});
