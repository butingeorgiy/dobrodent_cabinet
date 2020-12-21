export  default class ProductSearch {
    init() {
        if (location.pathname !== '/') {
            return null;
        }

        console.log('ProductSearch module initiated');
    }
}
