export default class BaseEditPopupView {
    constructor(btn, error, success, content) {
        this.btn = btn;
        this.error = error;
        this.success = success;
        this.content = content;

        this.hideMessages = this.hideMessages.bind(this);
    }

    hideMessages() {
        this.error.classList.add('hidden');
        this.success.classList.add('hidden');
    }

    showSuccessMessage(text = 'Изменения успешно созранены') {
        this.hideMessages();

        this.success.classList.remove('hidden');
        this.success.getElementsByTagName('span')[0].innerText = text;
        this.btn.classList.add('hidden');
        this.content.classList.add('hidden');
    }

    showErrorMessage(error) {
        this.hideMessages();

        this.error.classList.remove('hidden');
        this.error.getElementsByTagName('span')[0].innerText = error;
    }

    showLoader(removeListener) {
        removeListener();

        this.btn.querySelector('.non-loader').classList.add('hidden');
        this.btn.querySelector('.loader').classList.remove('hidden');
        this.btn.setAttribute('disabled', 'disabled');

        this.btn.getElementsByTagName('span')[0].innerText = 'Немого подождите ...';
    }

    hideLoader(addListener) {
        this.btn.querySelector('.non-loader').classList.remove('hidden');
        this.btn.querySelector('.loader').classList.add('hidden');
        this.btn.removeAttribute('disabled');

        this.btn.getElementsByTagName('span')[0].innerText = 'Сохранить изменения';

        addListener();
    }
}
