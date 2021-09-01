<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Tag;
use Illuminate\Http\Request;
use App\Traits\MetaTags;

class BlogController extends Controller
{
    use MetaTags;

    public function index()
    {
        $class = 'blog-page';

        $articles = Article::with(['content', 'tagsByLang', 'photos'])
            ->latest()
            ->paginate(10);

        $tags = Tag::withCount('articles')
            ->byLang()
            ->withArticles()
            ->limit(20)
            ->get();

        $latest = Article::with('content')
            ->latest()
            ->limit(3)
            ->get();

        $this->setMeta('Блог', 'Description');

        return view('frontend.blog.index', [
            'articles' => $articles,
            'tags' => $tags,
            'latest' => $latest,
            'class' => $class
        ]);
    }

    public function show($id)
    {
        $class = 'blog-page';

        $article = Article::where('id', $id)
            ->with(['content', 'tagsByLang', 'photos'])
            ->firstOrFail();

        $tags = Tag::withCount('articles')
            ->byLang()
            ->withArticles()
            ->limit(20)
            ->get();

        $latest = Article::with('content')
            ->latest()
            ->limit(3)
            ->get();

        $this->setMeta('Запись', 'Description');

        return view('frontend.blog.show', [
            'article' => $article,
            'tags' => $tags,
            'latest' => $latest,
            'class' => $class
        ]);
    }

    public function tag(string $slug)
    {
        $class = 'blog-page';

        $tag = Tag::where('slug', $slug)
            ->with(['articles', 'articles.content'])
            ->firstOrFail();

        $articles = $tag->articles()->paginate(10);

        $tags = Tag::withCount('articles')
            ->byLang()
            ->withArticles()
            ->limit(20)
            ->get();

        $latest = Article::with('content')
            ->latest()
            ->limit(3)
            ->get();

        $this->setMeta('Блог', 'Description');

        return view('frontend.blog.tag', [
            'tag' => $tag,
            'articles' => $articles,
            'tags' => $tags,
            'latest' => $latest,
            'class' => $class
        ]);
    }
}
