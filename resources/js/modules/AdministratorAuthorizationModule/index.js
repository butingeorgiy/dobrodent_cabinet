import AdministratorAuthorizationController from "./AdministratorAuthorizationController";

document.addEventListener('DOMContentLoaded', _ => {
    if (location.pathname === '/administrator/login') {
        const phoneInput = document.querySelector('#administratorPhone');

        new AdministratorAuthorizationController({ phoneInput });
    }
});
