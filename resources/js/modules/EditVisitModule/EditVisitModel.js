export default class EditVisitModel {
    async editStatus(params, visitId, mode) {
        const apiUrl = require('../../config').default.apiBaseUrl + `/visits/${mode}/updateStatus/${visitId}`;

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

    async move(params, visitId, mode) {
        const apiUrl = require('../../config').default.apiBaseUrl + `/visits/${mode}/move/${visitId}`;

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

    async attachIllness(params, visitId, mode) {
        const apiUrl = require('../../config').default.apiBaseUrl + `/visits/${mode}/attach-illness/${visitId}`;

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

    async editResult(params, visitId, mode) {
        const apiUrl = require('../../config').default.apiBaseUrl + `/visits/${mode}/edit-result/${visitId}`;

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

    async changeDoctor(params, visitId) {
        const apiUrl = require('../../config').default.apiBaseUrl + `/visits/administrator/edit-doctor/${visitId}`;

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

    async changePatient(params, visitId) {
        const apiUrl = require('../../config').default.apiBaseUrl + `/visits/administrator/edit-patient/${visitId}`;

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
