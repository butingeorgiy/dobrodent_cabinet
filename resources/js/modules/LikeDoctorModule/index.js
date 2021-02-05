import LikeDoctorController from "./LikeDoctorController";

document.addEventListener('DOMContentLoaded', _ => {
    const likeButtons = document.querySelectorAll('.like-doctor-btn');

    new LikeDoctorController({
        likeButtons
    });
});
