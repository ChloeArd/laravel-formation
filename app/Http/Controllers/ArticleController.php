<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleRequest;
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
     * @return Response
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
     * @return Response
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
     * @param ArticleRequest $request
     * @return Response
     */
    public function store(ArticleRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['category_id'] = request('category', null);
         Auth::user()->articles()->create($validatedData);

//        $article = Article::user()->articles()->create(request()->validate([
//            'title' => ['required', 'max:20', 'unique:articles,title'],
//            'content' => ['required'],
//            'category' => ['sometimes', 'nullable', 'exists:categories,id']
//        ]
////        [
////            'title.required' => "Il n'y a pas de titre !", // Permet d'afficher nous meme un message d'erreur pour required
////            'title.max' => "Trop long !",
////            'content.required' => "C'est requis ! "
////        ]
//        ));
//
//        $article->category_id = request('category', null);
//        $article->save();

//        $article = Article::create([
//            'user_id' => auth()->id(),
//            "title" => request("title"),
//            "slug" => Str::slug(request("slug")),
//            "content" => request('content'),
//            "category_id" => request("category", null)
//        ]);

//        $article = new Article;
//        $article->user_id = Auth::id();
//        $article->category_id = request('category', null);
//        $article->title = request('title');
//        $article->slug = Str::slug($article->title); // string
//        $article->content = request('content');
//        $article->save();

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
            'article' => $article,
            'comments' => $article->comments()->orderByDesc('created_at')->get()
        ];

        return view('article.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Article $article
     * @return void
     */
    // Affichage du formulaire d'edition avec les données de l'article
    public function edit(Article $article)
    {
        // Vérifie si l'utilisateur connecté est celui qui a créer l'article sinon erreur 403
        abort_if(auth()->id() != $article->user_id, 403 );

        $data = [
            'title' => $description = "Mise à jour de " . $article->title,
            'description' => $description,
            'article' => $article,
            'categories' => Category::get()
        ];

        return view('article.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    // Mise à jour de l'article en BDD
    public function update(ArticleRequest $request, Article $article)
    {
        $validatedData = $request->validated();
        $validatedData['category_id'] = request('category', null);

        $article = Auth::user()->articles()->updateOrCreate(['id' => $article->id], $validatedData); // si il trouve l'article il le met a jour sinon il le crée

        $success = "Article modifié";
        return redirect()->route('article.edit', ['article' => $article->slug])->withSuccess($success);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    // Supprimer un article
    public function destroy(Article $article)
    {
        abort_if(auth()->id() != $article->user_id, 403);

        $article->delete();

        $success = "Article supprimé !";

        return back()->withSuccess($success);
    }
}
