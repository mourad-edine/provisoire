<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}">

</head>
<style>
    body {
        margin: 0;
        padding: 0;
        font-family: 'Montserrat', sans-serif;
        background: url("{{ asset('assets/images/fond2.png') }}") no-repeat center center fixed;
        background-size: cover;
    }

    .login-container {
        display: flex;
        min-height: 100vh;
        justify-content: center;
        align-items: center;
        padding: 1rem;
    }

    .login-card {
        width: 100%;
        max-width: 400px;
        padding: 2rem;
        background-color: rgba(255, 255, 255, 0.97);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
        text-align: center;
        border-radius: 8px;
    }

    .login-header-image {
        width: 110px;
        height: auto;
        margin-bottom: 1rem;
    }

    .login-title {
        font-size: 1.6rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 1.5rem;
    }

    .input-group {
        display: flex;
        align-items: center;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        margin-top: 0.5rem;
        background-color: #fff;
    }

    .input-group i {
        padding: 12px;
        color: #9ca3af;
        font-size: 1rem;
    }

    .input-group input {
        flex: 1;
        border: none;
        padding: 12px;
        border-left: 1px solid #d1d5db;
        font-size: 0.95rem;
        border-radius: 0 6px 6px 0;
    }

    .input-group input:focus {
        outline: none;
        box-shadow: 0 0 5px rgba(99, 102, 241, 0.5);
        border-color: #6366f1;
    }

    .login-button {
        width: 100%;
        background-color: #4f46e5;
        color: white;
        font-weight: 600;
        padding: 12px;
        border-radius: 6px;
        margin-top: 1.5rem;
        cursor: pointer;
        font-size: 1rem;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        transition: background 0.3s ease-in-out;
    }

    .login-button:hover {
        background-color: #4338ca;
    }

    .forgot-password {
        font-size: 0.85rem;
        color: #4f46e5;
        text-decoration: none;
        margin-top: 0.75rem;
        display: block;
    }

    .forgot-password:hover {
        text-decoration: underline;
    }

    .text-red-500 {
        font-size: 0.85rem;
        text-align: left;
        margin-top: 0.25rem;
    }
</style>
<body>
    <div class="login-container">
        <div class="login-card">
            <img src="{{ asset('assets/images/tete.png') }}" alt="Cageot avec bouteille" class="login-header-image">

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-5">
                    <div class="input-group">
                        <i class="fas fa-envelope"></i>
                        <input id="email" class="login-input" type="email" name="email" :value="old('email')" placeholder="Votre email" required autofocus autocomplete="username" />
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="text-red-500" />
                </div>

                <div class="mb-5">
                    <div class="input-group">
                        <i class="fas fa-lock"></i>
                        <input id="password" class="login-input" type="password" name="password" placeholder="Votre mot de passe" required autocomplete="current-password" />
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="text-red-500" />
                </div>

                <div class="mt-6">
                    <button type="submit" class="login-button">
                        <i class="fas fa-sign-in-alt"></i> Connexion
                    </button>
                </div>
            </form>
        </div>
    </div>

</body>

</html>
