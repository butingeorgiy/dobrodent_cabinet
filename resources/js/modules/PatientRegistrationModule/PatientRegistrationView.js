export default class PatientRegistrationView {
    static manageAccessToSecondStep(isExist, messageNode, buttonNode, manageListenerOfMoveToSecondStepBtn) {
        if (typeof isExist === 'boolean') {
            PatientRegistrationView.manageButtons(isExist, buttonNode, manageListenerOfMoveToSecondStepBtn);
            PatientRegistrationView.manageMessageOfPhoneRegistration(isExist, messageNode);
        } else {
            console.error(`Undefined value of isExist variable: ${ isExist }`);
        }
    }

    static manageMessageOfPhoneRegistration(needToShow, messageNode) {
        if (needToShow === true) {
            if (messageNode.classList.contains('hidden')) {
                messageNode.classList.remove('hidden');
            }
        } else {
            if (!messageNode.classList.contains('hidden')) {
                messageNode.classList.add('hidden');
            }
        }
    }

    static manageButtons(needToDisable, buttonNode, manageListenerOfMoveToSecondStepBtn) {
        if (needToDisable === true) {
            if (!buttonNode.disabled) {
                buttonNode.disabled = true;
                manageListenerOfMoveToSecondStepBtn(true);
            }
        } else {
            if (buttonNode.disabled) {
                buttonNode.disabled = false;
                manageListenerOfMoveToSecondStepBtn(false);
            }
        }
    }
}
