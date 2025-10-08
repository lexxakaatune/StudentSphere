import { handleToggling } from "../BaseScript/Functions.js";

export function initUserProfile() {
  const deleteForm = document.getElementById('deleteForm'),
  deleteBtn = document.getElementById('deleteBtn'),
  updateSection = document.getElementById('updateSection'),
  updateBtn = document.getElementById('updateBtn');

  //Manual toggling for deleteform and update section
    if (deleteBtn) {
      deleteBtn.addEventListener('click', () => {
        const confirmed = confirm("This will delete all your information, if you want a temporary out, you should logout instead. Still want to delete?");
        if (confirmed) {
          handleToggling(deleteBtn, deleteForm, updateSection, 'delete', 'delete');
        }
      });      
    }
    if (updateBtn) {
      handleToggling(updateBtn, updateSection, deleteForm, 'update', 'update');
    }
}