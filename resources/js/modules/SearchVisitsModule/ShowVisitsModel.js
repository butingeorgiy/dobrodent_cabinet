export default class ShowVisitsModel {
    async get(offset, params, mode = 'patient') {
        let getParams = '?';

        for (let key in params) { getParams += `${key}=${params[key]}&`; }

        const apiUrl = require('../../config').default.apiBaseUrl + `/visits/${mode}/${offset}/${getParams}`;

        const response = await fetch(apiUrl);

        if (response.ok) {
            return response.json();
        } else {
            return response.text();
        }
    }
}
