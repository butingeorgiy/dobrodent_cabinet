export default class SearchDoctorsModel {
    async get(offset, string, mode) {
        const apiUrl = require('../../config').default.apiBaseUrl + `/doctors/${mode}/search/${offset}/?q=${string}`;

        const response = await fetch(apiUrl);

        if (response.ok) {
            return response.json();
        } else {
            return response.text();
        }
    }
}
