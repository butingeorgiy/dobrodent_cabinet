export default class Helper {
    static strLimit(str, limit = 100, endSign = '...') {
        let slicedStr = str.slice(0, limit);

        if (str.length > limit) {
            slicedStr += endSign;
        }

        return slicedStr;
    }
}
