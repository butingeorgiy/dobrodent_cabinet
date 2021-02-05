import EventHandler from "../../EventHandler";

export default class RecentSearchController extends EventHandler {
    constructor(domElements) {
        super();

        this.domElements = domElements;

        this.renderRecentLinks();
    }

    renderRecentLinks() {
        const mode = location.pathname.split('/')[2];
        const links = JSON.parse(localStorage.getItem('recent') || '[]')[mode] || [];

        if (links.length !== 0) {
            this.domElements.linksContainer.innerHTML = '';
        }

        links.forEach(link => {
            this.domElements.linksContainer.innerHTML += `
                <a href="/${location.pathname.split('/')[1]}/${mode}/?q=${link}" class="mr-1 mb-1 py-1 px-2 border border-gray-500 rounded text-sm text-gray-500">${link}</a>
            `;
        });
    }

    static addToRecent(query, mode) {
        let allLinks = JSON.parse(localStorage.getItem('recent') || '{}');
        let modeLinks = allLinks[mode] || [];
        let hasQ = false;

        modeLinks.forEach(link => {
            if (link === query) {
                hasQ = true;
            }
        });

        if (!hasQ) {
            modeLinks.push(query);

            if (modeLinks.length > 10) {
                modeLinks.shift();
            }

            allLinks[mode] = modeLinks;

            localStorage.setItem('recent', JSON.stringify(allLinks));
        }
    }
}
