<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show(Category $category) { // Les articles de la catégorie
        $articles = $category->articles()->withCount("comments")->latest()->paginate(5); // latest() -> dernier

    $data = [
        'title' => $category->name,
        'description' => "Les articles de la catégorie " . $category->name,
        'category' => $category,
        "articles" => $articles
    ];
    }
}
