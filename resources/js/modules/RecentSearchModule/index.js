import RecentSearchController from "./RecentSearchController";

document.addEventListener('DOMContentLoaded', _ => {
    const linksContainer = document.querySelector('.recent-list');

    if (linksContainer) {
        new RecentSearchController({
            linksContainer
        });
    }
});
