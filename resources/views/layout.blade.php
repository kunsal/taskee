<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Olakunle Salami">
    <title>{{ $appName }} · @yield('title', 'A smart todo app')</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <style>
        .logo {
            color: #057aff;
            font-size: 20px;
            font-weight: bold;
        }
        .nav-item {
            margin: auto 10px;
            font-weight: bold;
            color: #057aff
        }
    </style>
    <!-- Custom styles for this template -->
    @stack('page-css')
</head>
<body class="text-center">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand logo" href="/">{{ $appName }}</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse">
              <ul class="navbar-nav mr-auto">

              </ul>

              <ul class="navbar-nav my-2 my-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}">Home <span class="sr-only">(current)</span></a>
                    </li>
                @auth
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('tasks/create') }}">Create Task </a>
                </li>
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ auth()->user()->name }}
                  </a>
                  <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="{{ url('tasks') }}">My Tasks</a>
                    <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="{{ url('logout') }}">Logout</a>
                  </div>
                </li>
                @else
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('user/login') }}">Login</a>
                </li>
                <li class="nav-item">
                        <a class="nav-link btn btn-primary btn-sm" style="color: #fff" href="{{ url('user/register') }}">Register</a>
                    </li>
                @endauth
              </ul>
            </div>
        </nav>
        <div class="row">
            <div class="col-md-12">
                @yield('content')
            </div>
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

    @stack('page-js')
</body>
</html>

