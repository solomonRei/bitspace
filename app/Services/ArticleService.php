<?php 

namespace App\Services;

use App\Repositories\ArticleRepository;

class ArticleService
{
    protected $articleRepository;

    public function __construct(ArticleRepository $article)
    {
        $this->articleRepository = $article;
    }

    public function getArticleById(int $id)
    {
        return $this->articleRepository->getArticleById($id);
    }
}