import RecentSearchController from "../modules/RecentSearchModule/RecentSearchController";

export default class ObserveLinksForAddToRecent {
    static move(query, mode) {
        RecentSearchController.addToRecent(query, mode);
    }
}
