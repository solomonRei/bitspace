<?php
namespace App\Http\ViewComposers;

use App\Services\UserService;
use Illuminate\Contracts\View\View;
use App\Traits\Languages;

class UserComposer
{
    use Languages;

    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function compose(View $view)
    {
        $data = [];
        if ($user = $this->userService->getAuthenticated()) {
            if ($userString = $user->userStrings()->first())
                $data = $userString->getUsersString($this->getLangId(), $user->id);
        }

        $view->with('userAuth', $data);
    }
}
