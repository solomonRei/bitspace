<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuestionsRequest;
use App\Models\City;
use App\Models\Group;
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

        // Get Token & auth user
        if (isset($request->token) && !empty($request->token)) {
            $token = base64_decode(substr($request->token, 8));
            if(mb_detect_encoding($token, ['UTF-8'], true)) {
                if ($user = $this->userService->getUserToken($token)) {
                    if (!auth()->check())
                        $this->userService->doAuth($user['login']);

                        return redirect('/');
//                $this->userService->refreshUser($user);
                }
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

    public function filter(int $category = null, Request $request)
    {
        // $class = 'filters-search-page';
        $categoryCurrent = false;

        if ($category !== null && !$categoryCurrent = $this->categoryService->getCategoryById($category))
            abort(404);

        $this->setMeta('Поиск специалиста', 'Description');

        return view('frontend.search', [
            'categoryCurrent' => $categoryCurrent,
            'cities' => City::list(),
            'groups' => Group::list(),
        ]);
    }

    public function questions(QuestionsRequest $request)
    {
        $validated_data = $request->validated();

        toastr()->success(__('custom.success'));

//        return back();
    }
}
