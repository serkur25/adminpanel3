document.getElementById('loginForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;
    const errorMessage = document.getElementById('error-message');

    fetch('giris.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `username=${username}&password=${password}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.href = 'admin-panel.html'; // Admin paneline yönlendirme
        } else {
            errorMessage.textContent = 'Hatalı giriş yaptınız, tekrar deneyiniz.';
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
});
