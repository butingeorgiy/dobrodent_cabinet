export default class Registration {
    init() {
        if (location.pathname !== '/registration') {
            return null
        }

        console.log('Registration module initiated');
    }
}
