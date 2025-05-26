<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.5.0/remixicon.css">

    <link rel="stylesheet" href="{{ asset('css/header.css') }}">


    <title>Responsive dropdown profile menu- Bedimcode</title>
</head>

<body>
    <header class="header">
        <nav class="nav container">
            <a href="{{ route('dashboard')}}" class="nav__logo">
                <img class="logo-image" src=" {{ asset('images/dashboard/logo.png') }}">
                <h2 class="logo-text" style="margin-left: -80px">Mini Game</h2>
            </a>



            <div class="nav__menu" id="nav-menu">
                <ul class="nav__list">
                    <li>
                        <a href="{{ route('dashboard')}}" class="nav__link">Home</a>
                    </li>

                    <li>
                        <a href="{{ route('leaderboard') }}" class="nav__link">Leaderboard</a>
                    </li>

                    <li>
                        <a href="#" class="nav__link">About Us</a>
                    </li>

                    <li>
                        <a href="#" class="nav__link">Products</a>
                    </li>

                    <li>
                        <a href="#" class="nav__link">Contact</a>
                    </li>
                </ul>

                <!-- Close button -->
                <div class="nav__close" id="nav-close">
                    <i class="ri-close-large-line"></i>
                </div>
            </div>

            <div class="nav__actions">
                @auth
                    <!-- Nếu đã đăng nhập -->
                    <div class="dropdown" id="dropdown">
                        <div class="dropdown__profile">
                            <div class="dropdown__names">
                                <h3>{{ Auth::user()->username }}</h3>
                                <span>Player</span>
                            </div>

                            <div class="dropdown__image">
                                <img src="{{ Auth::user()->avatar }}" alt="User Avatar">
                            </div>
                        </div>

                        <div class="dropdown__list">
                            <a href="#" class="dropdown__link">
                                <i class="ri-user-line"></i>
                                <span>Profile</span>
                            </a>

                            <a href="#" class="dropdown__link">
                                <i class="ri-time-line"></i>
                                <span>Activity</span>
                            </a>

                            <a href="#" class="dropdown__link">
                                <i class="ri-bookmark-line"></i>
                                <span>Saved</span>
                            </a>

                            <a href="#" class="dropdown__link">
                                <i class="ri-settings-3-line"></i>
                                <span>Settings</span>
                            </a>

                            <a href="#" class="dropdown__link"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="ri-logout-box-r-line"></i>
                                <span>Logout</span>
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </div>
                @else
                    <!-- Nếu chưa đăng nhập -->
                    <div class="auth-links">
                     <a href="{{ route('login') }}" class="nav__link">Login</a>
                     <span>/</span>
                     <a href="{{ route('register') }}" class="nav__link">Register</a>
                 </div>
                 
                @endauth

                <!-- Toggle button -->
                <div class="nav__toggle" id="nav-toggle">
                    <i class="ri-menu-line"></i>
                </div>
            </div>

        </nav>
    </header>

    <script src="{{ asset('js/header.js') }}"></script>

</body>

</html>
