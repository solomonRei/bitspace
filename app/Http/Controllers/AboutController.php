<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\About;
use App\Traits\Languages;
use App\Traits\MetaTags;

class AboutController extends Controller
{
    use Languages, MetaTags;

    public function index()
    {

        $class = 'about-us-page';

        $this->setMeta('Главная', 'Description');

        $data = About::where('lang_id',  $this->getLangId())->first();

        return view('frontend.about', compact('class', 'data'));
    }
}
