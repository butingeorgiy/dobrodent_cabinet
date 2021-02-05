export default class EditPatientModel {
    async save(patientId, params) {
        const apiUrl = require('../../config').default.apiBaseUrl + `/patients/${patientId}/update`;

        const response = await fetch(apiUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(params)
        });

        if (response.ok) {
            return response.json();
        } else {
            return response.text();
        }
    }
}
