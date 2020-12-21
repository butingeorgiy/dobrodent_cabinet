import Registration from "./modules/Registration";
import ProductSearch from './modules/ProductSearch';

export default class ModulesInit {
    run() {
        (new Registration()).init();
        (new ProductSearch()).init();
    }
}
