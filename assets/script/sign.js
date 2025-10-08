// Authentication Logins ...
document.addEventListener('DOMContentLoaded', function () {
  //Signup, Login, header-button, headernav and Admin Login  sections by id...
  const signupSection = document.getElementById('signupSection');
  const loginSection = document.getElementById('loginSection');
  const adminLoginSection = document.getElementById('adminLoginSection');

  // Automatically switch to login if redirected after signup
  const urlParams = new URLSearchParams(window.location.search);
  const view = urlParams.get('view');

  if (signupSection && loginSection && view && adminLoginSection) {
    if (view === 'login') {
      loginSection.classList.add('visible');
      loginSection.classList.remove('hidden');
      adminLoginSection.classList.remove('visible');
      adminLoginSection.classList.add('hidden');
      signupSection.classList.add('hidden');
      signupSection.classList.remove('visible');
    } else if (view === 'signup') {
      loginSection.classList.remove('visible');
      loginSection.classList.add('hidden');
      adminLoginSection.classList.remove('visible');
      adminLoginSection.classList.add('hidden');
      signupSection.classList.remove('hidden');
      signupSection.classList.add('visible');
    } else if (view === 'admin') {
      loginSection.classList.remove('visible');
      loginSection.classList.add('hidden');
      adminLoginSection.classList.add('visible');
      adminLoginSection.classList.remove('hidden');
      signupSection.classList.add('hidden');
      signupSection.classList.remove('visible');
    }
  }
});