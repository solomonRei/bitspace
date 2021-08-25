<?php

namespace App\Services;
use App\Repositories\CategoryRepository;

class CategoryService
{
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getCategoriesName(int $count)
    {
        return $this->categoryRepository->getCategoriesWithRelationships($count);
    }

    public function getCategoryById(int $id)
    {
        return $this->categoryRepository->getCategoryById($id);
    }

}
