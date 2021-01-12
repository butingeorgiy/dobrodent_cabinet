import DropdownMenuController from "./DropdownMenuController";

document.addEventListener('DOMContentLoaded', _ => {
    const openDropdownMenuBtn = document.querySelector('#openDropdownMenuBtn');
    const menu = document.getElementsByTagName('nav')[0];

    new DropdownMenuController({
        openDropdownMenuBtn,
        menu
    });
});


