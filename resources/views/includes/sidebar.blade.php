<h1>Catégories</h1>

{{-- Affiche que les catégories qui ont des articles --}}
@foreach(App\Models\Category::has('articles')->get() as $category)
    <a href="{{ route('category.show', ['category' => $category->slug]) }}" class=" {{ Request::is('category/' . $category->slug) ? 'active' : '' }}">{{ $category->name }}</a>
@endforeach
