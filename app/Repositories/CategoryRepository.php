<?php
namespace App\Repositories;

use App\Models\Category;
use App\Traits\Languages;

class CategoryRepository
{
    use Languages;
    protected $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function getCategoryById($id)
    {
        return $this->category->where('id', $id)
            ->with(['categoryStrings' => function ($query) {
                return $query->where('lang_id', $this->getLangId());
            }])
            ->first();
    }

    public function getCategoriesWithRelationships($count=10)
    {
        return $this->category->with(['categoryStrings' => function ($query) {
            return $query->where('lang_id', $this->getLangId());
        }]) ->limit($count)
            ->get();

    }
}
