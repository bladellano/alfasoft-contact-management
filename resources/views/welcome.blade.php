<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Multi Contact Management</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <style>
            body {
                font-family: 'Figtree', sans-serif;
                margin: 0;
                padding: 0;
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
                background: linear-gradient(135deg, #32b4e4 0%, #015c94 100%);
            }
            .container {
                text-align: center;
                padding: 40px;
                background: white;
                border-radius: 10px;
                box-shadow: 0 10px 40px rgba(0,0,0,0.2);
                max-width: 600px;
            }
            h1 {
                color: #333;
                margin-bottom: 20px;
                font-size: 2rem;
            }
            p {
                color: #666;
                margin-bottom: 30px;
                line-height: 1.6;
            }
            a {
                display: inline-block;
                padding: 12px 30px;
                margin: 10px;
                background-color: #015c94;
                color: white;
                text-decoration: none;
                border-radius: 5px;
                font-weight: 600;
                transition: background-color 0.3s;
            }
            a:hover {
                background-color: #013a63;
            }
            .btn-logout {
                display: inline-block;
                padding: 12px 30px;
                margin: 10px;
                background-color: #dc3545;
                color: white;
                text-decoration: none;
                border-radius: 5px;
                font-weight: 600;
                border: none;
                cursor: pointer;
                font-family: 'Figtree', sans-serif;
                font-size: 1rem;
                transition: background-color 0.3s;
            }
            .btn-logout:hover {
                background-color: #c82333;
            }
            .auth-links {
                margin-top: 20px;
            }
            .logo {
                max-width: 200px;
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <img src="https://www.alfasoft.pt/assets/images/logo.png" alt="Alfasoft Logo" class="logo">
            <h1>Multi Contact Management Web Application</h1>
            <p>Manage your contacts efficiently with country code validation and detailed information.</p>

            <div class="auth-links">
                <a href="{{ route('people.index') }}">View People</a>

                @auth
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn-logout">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}">Login</a>
                @endauth
            </div>
        </div>
    </body>
</html>
