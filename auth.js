document.getElementById('signupForm')?.addEventListener('submit', function(event) {
    event.preventDefault();
    const username = document.getElementById('newUsername').value;
    const password = document.getElementById('newPassword').value;
    localStorage.setItem(username, password);
    alert('Sign up successful! You can now login.');
    window.location.href = 'login.html';
});

document.getElementById('loginForm')?.addEventListener('submit', function(event) {
    event.preventDefault();
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;
    const storedPassword = localStorage.getItem(username);
    if (storedPassword === password) {
        alert('Login successful!');
        window.location.href = 'main.html';
    } else {
        alert('Invalid username or password.');
    }
});
