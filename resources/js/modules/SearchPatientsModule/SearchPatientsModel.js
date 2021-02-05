export default class SearchPatientsModel {
    async get(offset, string, mode) {
        const apiUrl = require('../../config').default.apiBaseUrl + `/patients/${mode}/${offset}/?q=${string}`;

        console.log(apiUrl);

        const response = await fetch(apiUrl);

        if (response.ok) {
            return response.json();
        } else {
            return response.text();
        }
    }
}
