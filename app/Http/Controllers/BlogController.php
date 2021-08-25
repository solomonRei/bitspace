<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\MetaTags;

class BlogController extends Controller
{
    use MetaTags;

    public function index()
    {
        $class = 'blog-page';

        $this->setMeta('Блог', 'Description');

        return view('frontend.blog.index', compact('class'));
    }
}
