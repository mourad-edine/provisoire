
<style>
        .login-container {
            display: flex;
            min-height: 100vh;
            justify-content: center;
            align-items: center;
            background-color: #f3f4f6;
            font-family: 'montserrat';
        }
        .login-card {
            width: 100%;
            max-width: 400px;
            padding: 2rem;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .login-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #374151;
            margin-bottom: 1rem;
        }
        .login-input {
            width: 100%;
            padding: 10px;
            border: 1px solid #d1d5db;
            border-radius: 5px;
            margin-top: 0.5rem;
            transition: border-color 0.3s, box-shadow 0.3s;
        }
        .login-input:focus {
            border-color: #4f46e5;
            box-shadow: 0 0 5px rgba(79, 70, 229, 0.5);
            outline: none;
        }
        .login-button {
            width: 100%;
            background-color: #4f46e5;
            color: white;
            font-weight: bold;
            padding: 10px;
            border-radius: 5px;
            margin-top: 1rem;
            cursor: pointer;
            transition: background 0.3s;
            border: none;
        }
        .login-button:hover {
            background-color: #4338ca;
        }
        .forgot-password {
            font-size: 0.9rem;
            color: #4f46e5;
            text-decoration: none;
            margin-top: 0.5rem;
            display: block;
        }
        .forgot-password:hover {
            text-decoration: underline;
        }
    </style>
    <div class="login-container">
        <div class="login-card">
            <h2 class="login-title">Gestion des Boissons</h2>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div class="mb-5">
                    <x-text-input id="email" class="login-input" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500" />
                </div>

                <!-- Password -->
                <div class="mb-5">
                    <x-text-input id="password" class="login-input" type="password" name="password" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500" />
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between mt-4">
                    
                
                </div>

                <div class="mt-6">
                    <x-primary-button class="login-button">
                        {{ __('Connexion') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>

