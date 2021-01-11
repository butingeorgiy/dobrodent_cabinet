export default class PatientAuthorizationView {
    static manageAccessToSecondStep(isExist, messageNode, authByPasswordBtnNode, authByCodeBtnNode, manageListenersOfAuthButtons) {
        if (typeof isExist === 'boolean') {
            PatientAuthorizationView.manageMessageOfPhoneRegistration(!isExist, messageNode);
            PatientAuthorizationView.manageButtons(!isExist, authByPasswordBtnNode, authByCodeBtnNode, manageListenersOfAuthButtons)
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

    static manageButtons(needToDisable, authByPasswordBtnNode, authByCodeBtnNode, manageListenersOfAuthButtons) {
        if (needToDisable === true) {
            if (!authByPasswordBtnNode.disabled || !authByCodeBtnNode.disabled) {
                authByPasswordBtnNode.disabled = true;
                authByCodeBtnNode.disabled = true;
                manageListenersOfAuthButtons(true);
            }
        } else {
            if (authByPasswordBtnNode.disabled || authByCodeBtnNode.disabled) {
                authByPasswordBtnNode.disabled = false;
                authByCodeBtnNode.disabled = false;
                manageListenersOfAuthButtons(false);
            }
        }
    }
}
