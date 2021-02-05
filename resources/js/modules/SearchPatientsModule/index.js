import SearchPatientsController from "./SearchPatientsController";
import SearchPatientsModel from "./SearchPatientsModel";

document.addEventListener('DOMContentLoaded', _ => {
    const searchInput = document.querySelector('.patients-search-input');
    const loader = document.querySelector('.patients-search-loader');
    const searchContainer = document.querySelector('.patients-search-container');
    const showMoreBtn = document.querySelector('.show-more-patients-btn');
    const observableLinks = document.querySelectorAll('.observable-link');

    if (searchInput && loader && searchContainer && showMoreBtn) {
        new SearchPatientsController({
            searchInput,
            loader,
            searchContainer,
            showMoreBtn,
            observableLinks
        }, new SearchPatientsModel());
    }
});
