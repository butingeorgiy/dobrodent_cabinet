import FullSearchController from "./FullSearchController";
import FullSearchModel from "./FullSearchModel";

document.addEventListener('DOMContentLoaded', _ => {
    const input = document.querySelector('.global-search-input');
    const loader = document.querySelector('.global-search-loader');
    const container = document.querySelector('.global-search-container');
    const clearBtn = document.querySelector('.global-search-clear-btn');

    if (input && loader && container && clearBtn) {
        new FullSearchController({
            input,
            loader,
            container,
            clearBtn
        }, new FullSearchModel());
    }
});
