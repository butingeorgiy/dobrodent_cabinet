export default class PatientProfileFormView {
    constructor(formNode) {
        this.node = formNode;
        this.values = {};
        this.firstName = formNode.querySelector('input[name=\'first_name\']');
        this.lastName = formNode.querySelector('input[name=\'last_name\']');
        this.middleName = formNode.querySelector('input[name=\'middle_name\']');
        this.email = formNode.querySelector('input[name=\'email\']');
        this.gender = formNode.querySelector('select[name=\'gender\']');
        this.birthday = formNode.querySelector('input[name=\'birthday\']');
        this.profilePhoto = formNode.querySelector('input[name=\'profile_photo\']');

        this._getInitValues();

        this.moveToConfirmation = this.moveToConfirmation.bind(this);
        this._checkValuesOnChanges = this._checkValuesOnChanges.bind(this);
    }

    _getInitValues() {
        if (this.firstName) {
            this.values.firstName = this.firstName.value;
        } else {
            console.error('Not found first_name input!');
        }

        if (this.lastName) {
            this.values.lastName = this.lastName.value;
        } else {
            console.error('Not found last_name input!');
        }

        if (this.middleName) {
            this.values.middleName = this.middleName.value;
        } else {
            console.error('Not found middle_name input');
        }

        if (this.email) {
            this.values.email = this.email.value;
        } else {
            console.error('Not found email input');
        }

        if (this.gender) {
            this.values.gender = this.gender.value;
        } else {
            console.error('Not found gender input');
        }

        if (this.birthday) {
            this.values.birthday = this.birthday.value;
        } else {
            console.error('Not found birthday input');
        }
    }

    _checkValuesOnChanges() {
        let formHasChanges = false;

        for (let key in this.values) {
            if (this.values[key] !== this[key].value) {
                formHasChanges = true;
            }
        }

        if (this.profilePhoto.value !== '') {
            formHasChanges = true;
        }

        return formHasChanges;
    }

    moveToConfirmation(errorNode, saveBtnNode, confirmNode) {
        if (this._checkValuesOnChanges()) {
            errorNode.classList.add('hidden');
            saveBtnNode.classList.add('hidden');
            confirmNode.classList.remove('hidden');

            this.firstName.setAttribute('readonly', 'readonly');
            this.firstName.className += ' cursor-not-allowed bg-gray-100';
            this.lastName.setAttribute('readonly', 'readonly');
            this.lastName.className += ' cursor-not-allowed bg-gray-100';
            this.middleName.setAttribute('readonly', 'readonly');
            this.middleName.className += ' cursor-not-allowed bg-gray-100';
            this.email.setAttribute('readonly', 'readonly');
            this.email.className += ' cursor-not-allowed bg-gray-100';
            this.birthday.setAttribute('readonly', 'readonly');
            this.birthday.className += ' cursor-not-allowed bg-gray-100';
            this.gender.setAttribute('disabled', 'disabled');
            this.gender.className += ' disabled:cursor-not-allowed disabled:bg-gray-100';
            this.profilePhoto.setAttribute('readonly', 'readonly');
        } else {
            errorNode.classList.remove('hidden');
            errorNode.querySelector('span')
                .innerText = 'Ни одно поле не было изменено';

            if (errorNode.nextElementSibling.classList.contains('success-message')) {
                errorNode.nextElementSibling.remove();
            }
        }
    }
}
