<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ForgotController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ResetController;
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

Route::get('/', [ArticleController::class, "index"]);

Route::get('register', [RegisterController::class, 'index'])->name('register');
Route::get('login', [LoginController::class, "index"])->name('login');
Route::get('logout', [LogoutController::class, 'logout'])->name('logout');
Route::get('forgot', [ForgotController::class, 'index'])->name('forgot');

Route::get('user/edit', [UserController::class, 'edit'])->name('user.edit');
Route::post('user/store', [UserController::class, 'store'])->name('post.user');

Route::post('comment/{article}', [CommentController::class, 'store'])->name('post.comment');

Route::get("reset/{token}", [ResetController::class, "index"])->name("reset");
Route::post('reset', [ResetController::class, 'reset'])->name("post.reset");

Route::post('register', [RegisterController::class, "register"])->name('post.register');
Route::post('login', [LoginController::class, "login"])->name('post.login');
Route::post('forgot', [ForgotController::class, "login"])->name('post.forgot');

Route::get('/profile/{user}', [UserController::class, 'profile'])->name('user.profile');

Route::resource('articles', ArticleController::class)->except('index');

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
