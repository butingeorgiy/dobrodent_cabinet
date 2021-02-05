import SearchDoctorsController from "./SearchDoctorsController";
import SearchDoctorsModel from "./SearchDoctorsModel";

document.addEventListener('DOMContentLoaded', _ => {
    const searchInput = document.querySelector('.doctors-search-input');
    const loader = document.querySelector('.doctors-search-loader');
    const searchContainer = document.querySelector('.doctors-search-container');
    const showMoreBtn = document.querySelector('.show-more-doctors-btn');
    const observableLinks = document.querySelectorAll('.observable-link');

    if (searchInput && loader && searchContainer && showMoreBtn) {
        new SearchDoctorsController({
            searchInput,
            loader,
            searchContainer,
            showMoreBtn,
            observableLinks
        }, new SearchDoctorsModel());
    }
});
