<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Movie Database Lookup</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Movie Database Lookup</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <form class="d-flex" method="GET" action="/">
                    {{ csrf_field() }}
                    <input class="form-control me-2" id="search" name="search" type="search" placeholder="Movie Name" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
                </div>
            </div>
        </nav>
        <div class="container">
            @isset($error)
            <div class="row">
                <div class="offset-3 col-6 text-center"><h1 display="display-4">{{ $error }}</h1></div>
            </div>

            @else

            <div class="row">
                <div class="offset-3 col-6 justify-content-center"><h1 display="display-4">{{ $movie->{'title'} }}</h1></div>
            </div>

            <div class="row">
                <div class="offset-3 col-6 justify-content-center"><p>{{ $movie->{'overview'} }}</p></div>
            </div>

            <div class="row">
                <div class="offset-3 col-6"><strong>Release Date:</strong> {{ strlen($movie->{'release_date'}) ? $movie->{'release_date'} : 'Unknown' }}</div>
            </div>

            <div class="row">
                <div class="offset-3 col-6"><strong>Runtime:</strong> {{ $runtime }}</div>
            </div>

            <div class="row">
                <div class="offset-3 col-6"><hr/></div>
            </div>

            <div class="row">
                <div class="offset-3 col-6">
                    <h1 class="display-6">Cast:</h5>

                    <ul>
                        @for ($i = 0; $i < count($cast) && $i < 10; $i++)
                        <li>
                            <strong>{{ $cast[$i]->{'name'} }}</strong>
                            @if (strlen($cast[$i]->{'character'}) > 0)
                                as <em>{{ $cast[$i]->{'character'} }}</em>
                            @endif
                        </li>
                        @endfor

                        @if (count($cast) > 10)
                        <li>
                            <em>More cast available</em>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>

            @endisset
        </div>
    </body>
</html>
