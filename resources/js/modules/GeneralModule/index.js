import GeneralController from "./GeneralController";

document.addEventListener('DOMContentLoaded', _ => {
    const openExtraDropdownMenuBtn = document.querySelectorAll('.open-extra-dropdown-menu-btn');
    const extraDropdownMenu = document.querySelector('.extra-dropdown-menu');

    new GeneralController({
        openExtraDropdownMenuBtn,
        extraDropdownMenu
    });
});
