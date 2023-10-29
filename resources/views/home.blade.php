<!doctype html>
<html lang="en" data-bs-theme="auto">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.118.2">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Panel zarządzania</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/dashboard/">



    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">
    <link href="{{ asset('dist/css/bootstrap.min.css') }}" rel="stylesheet">


    <!-- Custom styles for this template -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
</head>

<body>



    <header class="navbar sticky-top bg-light  flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6" href="#">Panel zarządzania</a>

        <div class="dropdown">
            <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
                aria-expanded="false">
                {{ auth()->user()->name }}
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                <li>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                        Wyloguj
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>

        </div>
    </header>



    <div class="container">
        <div class="row">
            <main class="col-md-12 ms-sm-auto col-lg-12 px-md-4">
                <div class="row mt-4">
                    <div class="col-7 mt-3">
                        <form class="row g-3" method="POST" action="{{ route('save.settings') }}">
                            @csrf
                            <div class="col-auto">
                                <label for="fan_active_under_value">Próg aktywacji czujnika w %</label>
                                <input type="number" class="form-control" id="fan_active_under_value"
                                    name="fan_active_under_value"
                                    value="{{ auth()->user()->settings->fan_active_under_value }}"
                                    placeholder="Podaj liczbę od 0 do 70" data-toggle="tooltip" data-placement="bottom"
                                    title="Wiatrak zostanie włączony przy temperaturze niższej od temperatury rosy o podaną wartość procentową.">
                            </div>
                            <div class="col-auto">
                                <label for="frequency_seconds">Częstotliwość odświeżania danych w sekundach</label>
                                <input type="number" class="form-control" id="frequency_seconds"
                                    name="frequency_seconds" placeholder="Podaj ilość sekund"
                                    value="{{ auth()->user()->settings->frequency_seconds }}">
                            </div>
                            <div class="col-auto">
                                <button type="submit" id="save" class="btn btn-primary mb-3 mt-4">Zapisz
                                    ustawienia</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-5">
                        <div class="card">
                            <div class="card-header">
                                Twój token
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-10">
                                        <blockquote class="blockquote mb-0">
                                            <p>{{ auth()->user()->token->token }}</p>
                                        </blockquote>
                                    </div>
                                    <div class="col-2">
                                        <button id="copyButton" class="btn btn-primary">
                                            <i class="bi bi-clipboard"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Wykres temperatury i wilgotności</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">

                        <select class="form-select" id="period">
                            <option selected value="1">Ostatni dzień</option>
                            <option value="7">Ostatni tydzień</option>
                            <option value="30">Ostatni miesiąc</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="chart-container" style="width: 100%;">
                            <canvas class="w-100" id="myChart" width="900" height="300"></canvas>
                        </div>
                    </div>
                </div>

                <h2>Ostatnie pomiary</h2>
                <div class="table-responsive small">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th scope="col">Data pomiaru</th>
                                <th scope="col">Wilgotność</th>
                                <th scope="col">Temperatura</th>
                                <th scope="col">Temperatura punktu rosy</th>
                                <th scope="col">Wiatrak włączony</th>
                            </tr>
                        </thead>
                        <tbody id="results">
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>
    @vite(['resources/js/home.js'])
    <script src="{{ asset('dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/chart.js/Chart.min.js') }}"></script>
</body>

</html>
