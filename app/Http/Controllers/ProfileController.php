<?php

namespace App\Http\Controllers;

use App\Services\FileService;
use Illuminate\Http\Request;

use App\Traits\MetaTags;

//use App\Contracts\BitspaceContract as BitspaceService;
use App\Services\UserService;

class ProfileController extends Controller
{
    use MetaTags;

    protected $userService;
    protected $fileService;

    public function __construct(UserService $userService, FileService $fileService)
    {
        $this->userService = $userService;
        $this->fileService = $fileService;
    }

    public function index()
    {

        $class = 'personal-info-page';

        $this->setMeta(trans('custom.my_profile'), 'Description');

        return view('frontend.profile.index', compact('class'));
    }

    public function profileShow($id)
    {
        $class = 'profile-page';

        $user = $this->userService->getUser($id);
        $reviews = $this->userService->getReviews($id);
        $files = $this->fileService->getByUser(false, 1, $id);

        $this->setMeta('', 'Description');

        return view('frontend.profile', compact('class', 'user', 'reviews', 'files'));
    }
}
