import EventHandler from "../../EventHandler";
import FullSearchView from "./FullSearchView";
import ObserveLinksForAddToRecent from "../../mediators/ObserveLinksForAddToRecent";

export default class FullSearchController extends EventHandler {
    constructor(domElements, model) {
        super();

        this.domElements = domElements;
        this.model = model;
        this.mode = location.pathname.split('/')[1];
        this.searchString = '';

        this.observeLink = this.observeLink.bind(this);

        this.view = new FullSearchView(
            domElements.loader,
            domElements.container,
            domElements.container.parentElement,
            domElements.input.parentElement
        );

        this.changeInput();
        this.clear();
    }

    observeLink(link) {
        if (this.searchString.replace(/\s/g, '') !== '') {
            this.addEvent(link, 'click', _ => {
                ObserveLinksForAddToRecent.move(this.searchString, 'global');
            });
        }
    }

    clear() {
        this.addEvent(this.domElements.clearBtn, 'click', _ => {
            this.domElements.input.value = '';
            this.view.hideLoader();
            this.view.hideContainer();
            this.domElements.clearBtn.classList.add('hidden');
        });
    }

    changeInput() {
        let timer = null;
        const timerContext = this;
        this.addEvent(this.domElements.input, 'input', _ => {
            clearTimeout(timer);
            this.searchString = this.domElements.input.value;
            if (this.domElements.input.value.replace(/\s/g, '') === '') {
                this.view.hideLoader();
                this.view.hideContainer();
                this.domElements.clearBtn.classList.add('hidden');
                return false;
            }
            this.view.showLoader();
            timer = setTimeout(_ => {
                timerContext.search();
            }, 500);
        });
    }

    search() {
        this.model.search(this.searchString, this.mode)
            .then(result => {
                if (typeof result !== 'string') {
                    if (result.error === true) {
                        console.error(result.message);
                    } else {
                        this.view.render(result, this.observeLink, this.mode);
                        this.view.showContainer();
                        this.domElements.clearBtn.classList.remove('hidden');
                    }
                } else {
                    console.error(result);
                }
            })
            .catch(error => {
                console.error(error);
            });
    }
}
