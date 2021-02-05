export default class DoctorProfessionalInfoFormView {
    constructor(formNode, editor, occupation) {
        this.node = formNode;
        this.values = {};
        this.description = editor;
        this.occupation = occupation;

        this.moveToConfirmation = this.moveToConfirmation.bind(this);
    }

    moveToConfirmation(errorNode, saveBtnNode, confirmNode, duplicateDescription) {
        if (errorNode.nextElementSibling.classList.contains('success-message')) {
            errorNode.nextElementSibling.remove();
        }

        if (this.occupation.getValue().length !== 0) {
            errorNode.classList.add('hidden');
            saveBtnNode.classList.add('hidden');
            confirmNode.classList.remove('hidden');

            this.description.isReadOnly = true;
            this.occupation.disable();

            duplicateDescription();
        } else {
            errorNode.classList.remove('hidden');
            errorNode.querySelector('span')
                .innerText = 'Необходимо выбрать специализацию';
        }
    }
}
