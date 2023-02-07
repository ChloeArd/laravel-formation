<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ArticleController extends Controller
{

    public function __construct() {
        $this->middleware('auth')->except("index", "show");
    }

    protected $perPage = 12;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Afficher tous les articles
        $articles = Article::orderByDesc('id')->paginate(5); // en avoir que 5
        //$articles = Article::findOrFail(2); // article avec id = 2
        //$articles = Article::where('title', 'hello world')->first();
        //$articles = Article::orderByDesc('id')->take(15)->get(); // permet de prendre 15 articles
        //$articles = Article::orderByDesc('id')->skip(10)->take(15)->get(); // permet de prendre 15 articles et de skiper les 10 premiers
        //$count = Article::count();

        $data = [
            'title' => 'Les articles du blog - ' . config('app.name'),
            'description' => 'Retrouver tous les articles de ' . config('app.name'),
            'articles' => $articles
        ];

        return view('article.index', $data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::get();

        $articles = Article::all();

        foreach ($articles as $article) {
            dump($article->category->name);
        }

        $data = [
            'title' => $description = "Ajouter un nouvel article",
            'description' => $description,
            'categories' => $categories
        ];
        return view('article');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'title' => ['required', 'max:20', 'unique:articles, title'],
            'content' => ['required'],
            'category' => ['sometimes', 'nullable', 'exists:categories, id']
        ]);

        $article = new Article;
        $article->user_id = Auth::id();
        $article->category_id = request('category', null);
        $article->title = request('title');
        $article->slug = Str::slug($article->title);
        $article->content = request('content');
        $article->save();

        $success = "Article ajouté";
        return back()->withSuccess($success);
    }

    /**
     * Display the specified resource.
     *
     * @param Article $article
     * @return void
     */
    public function show(Article $article)
    {
        $data = [
            'title' => $article->title . " - " . config('app.name'),
            'description' => $article->title . ". " . Str::words($article->content, 10),
            'article' => $article
        ];

        return view('article.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
