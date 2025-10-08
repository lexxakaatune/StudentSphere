import { initHeader } from "./BaseScript/Header.js";
import { initHomepage } from "./UserScript/Homepage.js";
import { initUserProfile } from "./UserScript/userProfile.js";
import { initStudents } from "./AdminScript/Student.js";

//Page header function ....
initHeader();

document.addEventListener('DOMContentLoaded', () => {
  const urlParams = new URLSearchParams(window.location.search);
  const page = urlParams.get('page');
  const view = urlParams.get('view');
  /* const page = document.body.dataset.page;
  console.log(page); */

  switch (page) {
    case 'profile':
      initUserProfile();
      break;

    case 'admin':
      if (view === 'overviews') {
        initOverviews();
      } else if (view === 'students') {
        initStudents();
      }
      initUserProfile();
      break;

    default:
      initHomepage();
      break;
  }
});


