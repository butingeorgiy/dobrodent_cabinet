import LikeDoctorController from "../modules/LikeDoctorModule/LikeDoctorController";
import LikeIconView from "../modules/LikeDoctorModule/LikeIconView";

export default class PatientLikeDoctor {
    static like(doctorId, view) {
        LikeDoctorController.like(doctorId, view);
    }
}
