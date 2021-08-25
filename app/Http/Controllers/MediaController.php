<?php

namespace App\Http\Controllers;

use App\Services\FileService;
use Illuminate\Http\Request;

use App\Traits\MetaTags;
use App\Traits\Languages;

class MediaController extends Controller
{
    use MetaTags, Languages;

    protected $mediaService;
    private $class = 'personal-info-page';

    public function __construct(FileService $mediaService)
    {
        $this->mediaService = $mediaService;
    }

    public function showUser()
    {
        $class = $this->class;
        $this->setMeta(trans('custom.profile_settings'), 'Description');

        return view('frontend.profile.media', compact('class'));
    }
}
