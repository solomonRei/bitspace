<?php

namespace App\Http\Controllers;

use App\Services\ReviewService;
use Illuminate\Http\Request;

use App\Traits\MetaTags;
//use App\Contracts\BitspaceContract as BitspaceService;

use App\Services\UserService;
use App\Services\CityService;
use App\Services\CategoryService;


class IndexController extends Controller
{
    use MetaTags;

    protected $userService;
    protected $cityService;
    protected $categoryService;
    protected $reviewService;

    public function __construct(UserService $userService, CityService $cityService, CategoryService $categoryService, ReviewService $reviewService)
    {
        $this->userService = $userService;
        $this->cityService = $cityService;
        $this->categoryService = $categoryService;
        $this->reviewService = $reviewService;
    }

    public function index(Request $request)
    {
        if (isset($request->token) && !empty($request->token)) {
            if ($user = $this->userService->checkUser($request->token)) {
                if (!auth()->check())
                    $this->userService->doAuth($user['login']);

                $this->userService->refreshUser($user);
            }
        }

        $cities = $this->cityService->getCitiesName();
        $categories = $this->categoryService->getCategoriesName(10);
        $reviews = $this->reviewService->getCommentsLast(5);

        $allCategoriesPeople = $this->userService->getPeople(5);

        $usersCategories = $categories->map(function ($e){
            return [
                'category' => $e->id,
                'users' =>  $this->userService->getPeopleCategory($e->id, 5)
            ];
        });



        $this->setMeta('Главная', 'Description');


        return view('frontend.index', compact('cities', 'categories', 'reviews', 'allCategoriesPeople', 'usersCategories'));
    }

    public function filter(int $category, Request $request)
    {
        $class = 'filters-search-page';

        if ($category === 127) $users = $this->userService->getPeoplePagination(1);
        else $users = $this->userService->getPeopleCategoryPagination($category, 5);

        if(!$categoryCurrent = $this->categoryService->getCategoryById($category)) abort(404);


        $cities = $this->cityService->getCitiesName();


        $this->setMeta('Главная', 'Description');

        return view('frontend.search', compact('class', 'users', 'cities' ,'categoryCurrent'));
    }
}
