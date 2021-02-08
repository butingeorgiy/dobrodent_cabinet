export default class FullSearchModel {
    async search(searchString, mode) {
        const apiUrl = require('../../config').default.apiBaseUrl + `/full-search/${mode}/?q=${searchString}`;

        const response = await fetch(apiUrl);

        if (response.ok) {
            return response.json();
        } else {
            return response.text();
        }
    }
}
