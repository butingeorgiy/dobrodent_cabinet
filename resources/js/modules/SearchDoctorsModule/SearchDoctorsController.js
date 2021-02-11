import EventHandler from "../../EventHandler";
import DoctorsListView from "./DoctorsListView";
import PatientLikeDoctor from "../../mediators/PatientLikeDoctor";
import LikeIconView from "../LikeDoctorModule/LikeIconView";
import ObserveLinksForAddToRecent from "../../mediators/ObserveLinksForAddToRecent";

export default class SearchDoctorsController extends EventHandler {
    constructor(domElements, model) {
        super();

        this.domElements = domElements;
        this.model = model;
        this.mode = location.pathname.split('/')[1];
        this.searchString = domElements.searchInput.value || '';
        this.searchingMore = false;
        this.canShowMore = true;

        this.allowToShowMore = this.allowToShowMore.bind(this);
        this.forbidToShowMore = this.forbidToShowMore.bind(this);
        this.addToFavorite = this.addToFavorite.bind(this);
        this.observeLink = this.observeLink.bind(this);

        this.view = new DoctorsListView(
            domElements.showMoreBtn,
            domElements.searchContainer,
            domElements.loader
        );

        this.changeInput();
        this.showMore();
        this.initObservableLinks();
    }

    changeInput() {
        let timer = null;
        const timerContext = this;
        this.addEvent(this.domElements.searchInput, 'input', _ => {
            clearTimeout(timer);
            this.view.showLoader();
            timer = setTimeout(_ => {
                this.searchString = timerContext.domElements.searchInput.value;
                timerContext.search();
            }, 500);
        });
    }

    addToFavorite(doctorId, node) {
        const view = new LikeIconView(node);

        this.addEvent(node, 'click', _ => {
            PatientLikeDoctor.like(doctorId, view);
        });
    }

    initObservableLinks() {
        this.domElements.observableLinks.forEach(link => {
            if (this.searchString !== '') {
                this.addEvent(link, 'click', _ => {
                    ObserveLinksForAddToRecent.move(this.searchString, 'doctors');
                });
            }
        });
    }

    observeLink(link) {
        if (this.searchString !== '') {
            this.addEvent(link, 'click', _ => {
                ObserveLinksForAddToRecent.move(this.searchString, 'doctors');
            });
        }
    }

    search() {
        this.model.get(0, this.searchString, this.mode)
            .then(result => {
                if (typeof result !== 'string') {
                    if (result.error === true) {
                        console.error(result.message);
                    } else {
                        this.view.clear();
                        this.view.reset(this.allowToShowMore, this.forbidToShowMore);
                        this.view.render(result, this.forbidToShowMore, this.mode, this.addToFavorite, this.observeLink);
                        this.view.hideLoader();
                    }
                } else {
                    console.error(result);
                }
            })
            .catch(error => {
                console.error(error);
            });
    }

    allowToShowMore() {
        this.canShowMore = true;
    }

    forbidToShowMore() {
        this.canShowMore = false;
    }

    showMore() {
        const showMoreListener = _ => {
            if (
                ((this.domElements.showMoreBtn.getBoundingClientRect().top - document.documentElement.clientHeight) < 0)
                && this.searchingMore === false
                && this.canShowMore === true
            ) {
                this.searchingMore = true;
                this.view.showLoader();

                this.model.get(this.view.getOffset(), this.searchString, this.mode)
                    .then(result => {
                        if (typeof result !== 'string') {
                            if (result.error === true) {
                                console.error(result.message);
                            } else {
                                this.view.render(result, this.forbidToShowMore, this.mode, this.addToFavorite, this.observeLink);
                                this.view.hideLoader();
                                this.searchingMore = false;
                            }
                        } else {
                            console.error(result);
                        }
                    })
                    .catch(error => {
                        console.error(error);
                    });
            }
        };

        this.addEvent(window, 'scroll', showMoreListener);
    }
}
