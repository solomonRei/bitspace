<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\City;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\Group;
use Illuminate\Session\SessionManager;
use Illuminate\Support\Facades\DB;

class ProfileFilter extends Component
{
    use WithPagination;

    protected $categoryName;

    protected $queryString = [
        'category' => [ 'except' => '' ],
        'city' => [ 'except' => '' ],
        'groups' => [ 'except' => 0 ],
        'withPhoto' => [ 'except' => false ],
        'withReview' => [ 'except' => false ],
        'page' => [ 'except' => 1 ],
    ];

    public $page = 1;

    public $category;

    public $categoryCurrent;

    public $citiesList;

    public $groupsList;

    /**
     * Search params BEGIN
     */
    public $city;

    public $groups;

    public $withPhoto;

    public $withReview;
    /**
     * Search params END
     */


    public function mount()
    {

        if ($this->category && !$this->categoryCurrent = Category::find($this->category)) 
            abort(404);

        if ($this->city && !City::find($this->city)) 
            abort(404);

    }

    public function render()
    {        
        $this->categoryName = $this->categoryCurrent 
            ? $this->categoryCurrent->stringByLang()->name 
            : trans('custom.menu_specialists');

        $users = User::with(['reviews', 'groupName', 'categoryName', 'userStringsByLang', 'city', 'cityName'])
            ->withCount('reviews')
            ->when(isset($this->groups) && !empty($this->groups), function($query) {
                $ids = array_filter($this->groups, function($item) {
                    return $item !== false;
                });
                if ($ids) {
                    return $query->whereIn('group_id', $this->groups);
                }
            })
            ->when(isset($this->city) && $this->city, function($query) {
                return $query->where('city_id', $this->city);
            })
            ->when($this->categoryCurrent, function($query) {
                $query = $query->where('category_id', $this->categoryCurrent->id);
            })
            ->when(isset($this->withPhoto) && $this->withPhoto, function($query) {
                $query = $query->where('ava', '!=', null);
            })
            ->when(isset($this->withReview) && $this->withReview, function($query) {
                $query = $query->having('reviews_count', '>', 0);
            })
            ->isShown()
            ->IsSearched()
            ->paginate(10);

        return view('livewire/profile-filter', [
            'users' => $users,
            'categoryName' => $this->categoryName,
        ]);
    }
}
