<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Changement de mot de passe</title>
    
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.all.min.js"></script>
    
    <link href="assets/vendors/base/vendors.bundle.css" rel="stylesheet" type="text/css" />
    <link href="assets/demo/default/base/style.bundle.css" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="assets/app/media/img/logos/OPTIMAID1.png" />
    
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2ecc71;
            --bg-light: #f4f6f7;
            --text-dark: #2c3e50;
            --sidebar-width: 250px;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            background-color: var(--background-color);
            line-height: 1.6;
            color: var(--text-color);
        }

        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            padding: 20px;
        }

        .modal-content {
            background-color: white;
            border-radius: 16px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            padding: 2.5rem;
            width: 100%;
            max-width: 500px;
            animation: slideIn 0.3s ease-out;
            position: relative;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .modal-title {
            text-align: center;
            color: var(--primary-color);
            margin-bottom: 1.5rem;
            font-size: 1.75rem;
            font-weight: 700;
        }

        .password-input-container {
            position: relative;
            margin-bottom: 1rem;
        }

        .password-input-container label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #4b5563;
        }

        .password-input-container input {
            width: 100%;
            padding: 12px 45px 12px 15px;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .password-input-container input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
        }

        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            background: none;
            border: none;
            font-size: 1.2rem;
            color: #6b7280;
            transition: color 0.3s ease;
        }

        .password-toggle:hover {
            color: var(--primary-color);
        }

        .error-message {
            color: var(--error-color);
            margin-top: 0.5rem;
            font-size: 0.875rem;
            animation: shake 0.3s;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }

        .password-requirements {
            margin-top: 1rem;
            font-size: 0.875rem;
            color: #6b7280;
            background-color: #f9fafb;
            padding: 1rem;
            border-radius: 8px;
        }

        .password-requirements ul {
            padding-left: 1.5rem;
        }

        .submit-button {
            width: 100%;
            padding: 12px;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            margin-top: 1rem;
        }

        .submit-button:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .submit-button:active {
            transform: translateY(0);
            box-shadow: none;
        }
    </style>
</head>
<body>
    <div class="modal-overlay">
        <div class="modal-content">
            <h2 class="modal-title">
                Changement de mot de passe obligatoire
            </h2>
            
            <form class="m-form m-form--fit m-form--label-align-right" action="{{ route('changePassword') }}" method="POST" enctype="multipart/form-data" style="max-height: 80vh; overflow-y: auto;">
    
                @csrf
                <div class="m-portlet__body">
                    <!-- Hidden Input for User ID -->
                    <input class="form-control m-input" name="id" type="hidden" value="{{ auth()->user()->id }}">
                     <!-- Alert for Old Password Error -->
        @if ($errors->has('passwordnote'))
        <div class="alert alert-danger" role="alert">
            {{ $errors->first('passwordnote') }}
        </div>
        @endif
        

        
                        <!-- Old Password Field -->
                        <div class="form-group m-form__group">
                            <label for="old_password">Ancien mot de passe</label>
                            <input class="form-control m-input" id="old_password" type="password" name="old_password"  required>
                        </div>

                        <!-- New Password Field -->
                        <div class="form-group m-form__group">
                            <label for="password">Nouveau mot de passe</label>
                            <input class="form-control m-input" id="password" type="password" name="password" placeholder="Entrez le nouveau mot de passe" required minlength="8" pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}" title="Le mot de passe doit contenir au moins 8 caractères, une lettre majuscule, une lettre minuscule, un chiffre et un caractère spécial.">
                        </div>

                        <!-- Confirm Password Field -->
                        <div class="form-group m-form__group">
                            <label for="password_confirmation">Confirmer le mot de passe</label>
                            <input class="form-control m-input" id="password_confirmation" type="password" name="confirmPassword" placeholder="Confirmez le nouveau mot de passe" required>
                            <div id="confirmation-feedback" style="color: red; display: none;">Les mots de passe ne correspondent pas.</div>
                        </div>
                </div>

                <!-- Password Requirements -->
                <div class="password-requirements">
                  
                    <p>Votre mot de passe doit contenir :</p>
                    <ul>
                        
                        <li>Une lettre majuscule</li>
                        <li>Une lettre minuscule</li>
                        <li>Un chiffre</li>
                        <li>Un caractère spécial (@,$,!,%,*,?,&)</li>
                        <li>Au moins 8 caractères</li>
                    </ul>
                </div>
                

    <!-- Submit Button -->
            <div class="m-portlet__foot m-portlet__foot--fit">
                <div class="m-form__actions text-end">
                    <button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom">Modifier</button>
                </div>
            </div>
</form>

<script>
    // Password validation
    document.getElementById('password').addEventListener('input', function () {
        const password = this.value;
        const requirements = [
            /[A-Z]/.test(password),
            /[a-z]/.test(password),
            /\d/.test(password),
            /[@$!%*?&]/.test(password),
            password.length >= 8
        ];
        
        const listItems = document.querySelectorAll('.password-requirements li');
        requirements.forEach((req, index) => {
            listItems[index].style.color = req ? 'green' : 'red';
        });
    });

    // Password confirmation validation
    const passwordField = document.getElementById('password');
    const confirmPasswordField = document.getElementById('password_confirmation');
    const feedback = document.getElementById('confirmation-feedback');

    confirmPasswordField.addEventListener('input', function () {
        const password = passwordField.value;
        const confirmPassword = this.value;

        if (password !== confirmPassword) {
            feedback.style.display = 'block';
            this.setCustomValidity('Les mots de passe ne correspondent pas.');
        } else {
            feedback.style.display = 'none';
            this.setCustomValidity('');
        }
    });
</script>

        </div>
    </div>

    <script>
        function togglePasswordVisibility(inputId, toggleElement) {
            const input = document.getElementById(inputId);
            input.type = input.type === 'password' ? 'text' : 'password';
            toggleElement.innerHTML = input.type === 'password' ? '👁️' : '👁️‍🗨️';
        }

        
    </script>
    <script>
	document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('formpassword').addEventListener('submit', function (e) {
        const password = document.getElementById('password').value;
        const passwordError = document.getElementById('nomError');

        // Définir les règles du mot de passe
        const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

        if (!passwordRegex.test(password)) {
            e.preventDefault(); // Empêcher l'envoi du formulaire
            passwordError.textContent = 
                "Le mot de passe doit contenir au moins 8 caractères, " +
                "une majuscule, une minuscule, un chiffre et un caractère spécial.";
        } else {
            passwordError.textContent = ''; // Supprimer les erreurs si tout est correct
        }
    });
});

            </script>
</body>
</html>