export default class PatientRegistrationModel {
    async requestForCheckPhone(phone) {
        const apiUrl = require('../../config').default.apiBaseUrl + `/patients/is-exist/phone/${phone}`;

        const response = await fetch(apiUrl, {
            method: 'POST'
        });

        if (response.ok) {
            return response.json();
        } else {
            return response.text();
        }
    }
}
