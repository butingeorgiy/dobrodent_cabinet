import EventHandler from "../../EventHandler";
import LikeIconView from "./LikeIconView";
import LikeDoctorModel from "./LikeDoctorModel";

export default class LikeDoctorController extends EventHandler {
    constructor(domElements) {
        super();

        this.domElements = domElements;

        if (
            (/\/patient\/doctors\/\d/.test(location.pathname) || location.pathname === '/patient/doctors') &&
            domElements.likeButtons.length !== 0
        ) {
            this.addListenerToLikeDoctor();
        }
    }

    addListenerToLikeDoctor() {
        this.domElements.likeButtons.forEach(btn => {
            const view = new LikeIconView(btn);

            this.addEvent(btn, 'click', _ => {
                let doctorId = location.pathname.split('/')[3];

                if (!doctorId) {
                    doctorId = btn.getAttribute('data-doctor-id');
                }

                LikeDoctorController.like(doctorId, view);
            });
        });
    }

    static like(doctorId, view) {
        if (view.canLike) {
            view.canLike = false;

            LikeDoctorModel.like({doctor_id: doctorId})
                .then(result => {
                    if (typeof result !== 'string') {
                        if (result.error === true) {
                            console.error(result.message);
                        } else {
                            view.toggle();
                        }
                    } else {
                        console.error(result);
                    }
                    view.canLike = true;
                })
                .catch(error => {
                    console.error(error);
                    view.canLike = true;
                });
        }
    }
}
