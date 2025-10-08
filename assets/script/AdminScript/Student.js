import { handleToggling } from "../BaseScript/Functions.js";

export function initStudents() {
  const adminUpdateBtn = document.querySelectorAll('.adminUpdateBtn'),
  adminUpdateSection = document.getElementById('adminUpdateSection');

  adminUpdateBtn.forEach(btn => {
    handleToggling(btn, adminUpdateSection, undefined, 'update', 'update');
  });  
}