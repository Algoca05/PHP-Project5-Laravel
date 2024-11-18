document.addEventListener('DOMContentLoaded', function() {
    const modalsContainer = document.getElementById('modals-container');

    const loginModal = `
        <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="loginModalLabel">Iniciar Sesión</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="loginForm">
                            <div class="form-group">
                                <label for="email">Correo Electrónico</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                                <div class="invalid-feedback" id="login-email-error"></div>
                            </div>
                            <div class="form-group">
                                <label for="password">Contraseña</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                                <div class="invalid-feedback" id="login-password-error"></div>
                            </div>
                            <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
                        </form>
                        <p class="mt-3">¿No tienes una cuenta? <a href="#" data-toggle="modal" data-target="#RegisterModal" data-dismiss="modal">Regístrate aquí</a></p>
                    </div>
                </div>
            </div>
        </div>
    `;

    const registerModal = `
        <div class="modal fade" id="RegisterModal" tabindex="-1" role="dialog" aria-labelledby="RegisterModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="RegisterModalLabel">Registrarse</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="registerForm">
                            <div class="form-group">
                                <label for="name">Nombre</label>
                                <input type="text" class="form-control" id="name" name="name" >
                                <div class="invalid-feedback" id="register-name-error"></div>
                            </div>
                            <div class="form-group">
                                <label for="email">Correo Electrónico</label>
                                <input type="email" class="form-control" id="email" name="email" >
                                <div class="invalid-feedback" id="register-email-error"></div>
                            </div>
                            <div class="form-group">
                                <label for="password">Contraseña</label>
                                <input type="password" class="form-control" id="password" name="password" >
                                <div class="invalid-feedback" id="register-password-error"></div>
                            </div>
                            <button type="submit" class="btn btn-primary">Registrarse</button>
                        </form>
                        <p class="mt-3">¿Ya tienes una cuenta? <a href="#" data-toggle="modal" data-target="#loginModal" data-dismiss="modal">Inicia sesión aquí</a></p>
                    </div>
                </div>
            </div>
        </div>
    `;

    modalsContainer.innerHTML = loginModal + registerModal;

    document.getElementById('loginForm').addEventListener('submit', function(event) {
        event.preventDefault();
        const formData = new FormData(event.target);
        fetch('/login', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.errors) {
                if (data.errors.email) {
                    document.getElementById('login-email-error').textContent = data.errors.email[0];
                    document.getElementById('email').classList.add('is-invalid');
                }
                if (data.errors.password) {
                    document.getElementById('login-password-error').textContent = data.errors.password[0];
                    document.getElementById('password').classList.add('is-invalid');
                }
            } else {
                window.location.href = data.redirect;
            }
        });
    });

    document.getElementById('registerForm').addEventListener('submit', function(event) {
        event.preventDefault();
        const formData = new FormData(event.target);
        fetch('/register', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.errors) {
                if (data.errors.name) {
                    document.getElementById('register-name-error').textContent = data.errors.name[0];
                    document.getElementById('name').classList.add('is-invalid');
                }
                if (data.errors.email) {
                    document.getElementById('register-email-error').textContent = data.errors.email[0];
                    document.getElementById('email').classList.add('is-invalid');
                }
                if (data.errors.password) {
                    document.getElementById('register-password-error').textContent = data.errors.password[0];
                    document.getElementById('password').classList.add('is-invalid');
                }
            } else {
                window.location.href = data.redirect;
            }
        });
    });
});
