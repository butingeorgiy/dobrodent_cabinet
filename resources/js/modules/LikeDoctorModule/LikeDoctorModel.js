export default class LikeDoctorModel {
    static async like(params) {
        const apiUrl = require('../../config').default.apiBaseUrl + `/doctors/patient/add-to-favorite`;

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
