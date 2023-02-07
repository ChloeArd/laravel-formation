<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('register', [RegisterController::class, 'index'])->name('register');
Route::get('login', [LoginController::class, "index"])->name('login');

Route::post('register', [RegisterController::class, "register"])->name('post.register');
Route::post('login', [LoginController::class, "login"])->name('post.login');

Route::get('/profile/{username}', [UserController::class, 'profile'])->name('user.profile');

Route::resource('articles', ArticleController::class);

Route::get('profile/{firstname}/{lastname}', function($firstname = null, $lastname = null) {
//    return view('profile.index')->with(compact('firstname', 'lastname'));

    return view('profile.index', [
        'title'=> "Mon titre",
        'description' => 'Une description',
        'firstname' => $firstname,
        "lastname" => $lastname
    ]);
});

Route::get('test', function () {
    return view('test');
});

Route::get('test2', function () {
    return view('test2')->withTitle('PHP');
});

Route::get("structures", function () {
    $fruits = ["pomme", "orange", "citron", "fraise", "mûre"];
    $data = [
        'number' => 5,
        'fruits' => $fruits
    ];
   return view('structures', $data);
});

//Route::get('articles', function () {
//   $articles = ['Articles A', "Articles B", "Article C"];
//
//   $sort = request()->query('sort');
//
//    switch ($sort) {
//        case 'desc':
//            rsort($articles);
//            break;
//        case 'asc':
//            sort($articles);
//            break;
//        default:
//            break;
//    }
//
//   foreach ($articles as $article) {
//       echo "<p>$article</p>";
//   }
//});