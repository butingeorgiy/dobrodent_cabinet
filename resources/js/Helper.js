export default class Helper {
    static strLimit(str, limit = 100, endSign = '...') {
        let slicedStr = str.slice(0, limit);

        if (str.length > limit) {
            slicedStr += endSign;
        }

        return slicedStr;
    }

    static parseDateToString(dateObj) {
        let year = dateObj.getFullYear(),
            month = dateObj.getMonth() + 1,
            day = dateObj.getDate();

        if (month < 10) {
            month = '0' + month;
        }

        if (day < 10) {
            day = '0' + day;
        }

        return year + '-' + month + '-' + day;
    }

    static parseTimeToString(dateObj) {
        let hours = dateObj.getHours(),
            minutes = dateObj.getMinutes();

        if (minutes < 10) {
            minutes = '0' + minutes;
        }

        return hours + ':' + minutes;
    }
}
