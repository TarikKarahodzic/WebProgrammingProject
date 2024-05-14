document.addEventListener("DOMContentLoaded", function() {
    const containerEl = document.getElementById('containerLogin');
    const registerBtn = document.getElementById('register');
    const loginBtn = document.getElementById('login');

    registerBtn.addEventListener('click', () =>
        containerEl.classList.add('active')
    );

    loginBtn.addEventListener('click', () =>
        containerEl.classList.remove('active')
    );
});
