import DoctorNoteController from "./DoctorNoteController";

document.addEventListener('DOMContentLoaded', _ => {
   const textarea = document.querySelector('.doctor-note');

   if (textarea) {
       new DoctorNoteController({
           textarea
       });
   }
});
