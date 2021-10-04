<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function() {

    if (strlen(request('search')) < 1) {
        return view('welcome', [
            'error' => 'Movie title must be provided'
        ]);
    }

    $search = urlencode(request('search'));

    $movie_search_url = 'https://api.themoviedb.org/3/search/movie?api_key=' . config('myconfig.moviedb-api-key') . '&query=' . $search;

    $search_response = Http::get($movie_search_url);

    if ($search_response->status() == 401) {
        return view('welcome', [
            'error' => 'Failed to connect to 3rd party API, check API Key'
        ]);
    }

    if ($search_response->status() != 200) {
        return view('welcome', [
            'error' => 'Bad response from API: ' . $search_response->status()
        ]);
    }

    $search_data = json_decode($search_response);

    if (count($search_data->{'results'}) < 1) {
        return view('welcome', [
            'error' => 'No movies found'
        ]);
    }

    $first_result = array_shift($search_data->{'results'});

    $movie_detail_url = 'https://api.themoviedb.org/3/movie/' . $first_result->{'id'} . '?api_key=' . config('myconfig.moviedb-api-key');

    $movie_detail_response = Http::get($movie_detail_url);

    $movie_details = json_decode($movie_detail_response);

    $runtime = '';

    if (floor($movie_details->{'runtime'} / 60) > 0) {
        $runtime = floor($movie_details->{'runtime'} / 60) . ' hour' . (floor($movie_details->{'runtime'} / 60) > 1 ? 's' : '');
    }

    if ($movie_details->{'runtime'} % 60 != 0) {
        if (strlen($runtime) > 0 ) {
            $runtime .= ', ';
        }

        $runtime .= ($movie_details->{'runtime'} % 60) . ' minute' . ($movie_details->{'runtime'} % 60 > 1 ? 's' : '');
    }

    $movie_credits_url = 'https://api.themoviedb.org/3/movie/' . $first_result->{'id'} . '/credits?api_key=' . config('myconfig.moviedb-api-key');
    
    $movie_credits_response = Http::get($movie_credits_url);

    $cast = json_decode($movie_credits_response)->{'cast'};

    return view('welcome', [
        'movie' => $movie_details,
        'cast' => $cast,
        'runtime' => $runtime,
    ]);
});
