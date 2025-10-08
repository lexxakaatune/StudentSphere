import { handleToggling } from "./Functions.js";

//header.js
export function initHeader() {
  document.addEventListener('DOMContentLoaded', () => {
    const headerNav = document.getElementById('headerNav'),
    headerLinks = document.querySelectorAll('.header__li_a'),
    headerButton = document.getElementById('headerButton');

    //Manual toggling
    if (headerButton) {
      handleToggling(headerButton, headerNav, undefined, '❌', 'Menu');
    }

    //add active to active links
    const currentURL = window.location.href;
    headerLinks.forEach(link => {
      if (link.href === currentURL) {
        link.classList.add('active');
      }
    }); 

  });
}