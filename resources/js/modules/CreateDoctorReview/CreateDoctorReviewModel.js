export default class CreateDoctorReviewModel {
    async create(params) {
        const apiUrl = require('../../config').default.apiBaseUrl + `/doctor-reviews/patient/create`;

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
