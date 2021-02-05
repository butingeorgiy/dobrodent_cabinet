export default class VisitModel {
    async create(date, mode) {
        const apiUrl = require('../../config').default.apiBaseUrl + `/visits/${mode}/create`;

        const response = await fetch(apiUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(date)
        });

        if (response.ok) {
            return response.json();
        } else {
            return response.text();
        }
    }
}
