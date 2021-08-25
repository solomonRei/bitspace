<?php
namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use App\Traits\Languages;

class LanguageComposer
{
    use Languages;
    public function compose(View $view)
    {
        $view->with('languages', $this->getLanguages());
    }
}
