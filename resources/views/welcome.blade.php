<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Project Management</title>
    <link rel="stylesheet" href="{{asset('css/bootstrap.css')}}">
</head>
<style>
    body {
        padding-top: 56px;
        margin-bottom: 100px;
    }

    footer {
        position: fixed;
        width: 100%;
        bottom: 0;
        background-color: #343a40;
        color: white;
        padding: 10px 0;
    }
</style>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="#">Project Management</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                @auth
                    <li class="nav-item active">
                        <a class="nav-link" href="{{ url('/projects') }}">{{ __('Go to projects') }}</a>
                    </li>
                @else
                    <li class="nav-item active">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item active">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @endauth
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contact</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <header class="jumbotron">
        <h1 class="display-4">Welcome to Project Management</h1>
        <p class="lead">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam at odio nec lacus vestibulum
            dignissim. Integer nec velit risus. Suspendisse potenti.</p>
        <a class="btn btn-primary btn-lg" href="#" role="button">Get Started!</a>
    </header>

    <div class="row mt-5">
        <div class="col-md-6">
            <h2>About Us</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam at odio nec lacus vestibulum
                dignissim.</p>
        </div>
        <div class="col-md-6">
            <h2>Our Services</h2>
            <ul>
                <li>Project Planning</li>
                <li>Resource Management</li>
                <li>Task Tracking</li>
                <li>Reporting</li>
            </ul>
        </div>
    </div>
</div>

<footer class="py-4">
    <div class="container text-center">
        <p>&copy; 2024 Project Management. All rights reserved.</p>
    </div>
</footer>
</body>
</html>

