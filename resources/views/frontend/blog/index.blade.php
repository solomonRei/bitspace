@extends('layouts.frontend.app')
@section('content')
    <div class="blog-block">
    <div class="container">
        <div class="block-container">
            <div class="wrapper">
                <div class="main-content">
                    <div class="title medium center-md">
                        Блог
                    </div>
                    <div class="mt-20 center-md" id="breadcrumbs">
                        <ul>
                            <li>
                                <a href="#">
                                    Главная
                                </a>
                            </li>
                            <li>
                                Блог
                            </li>
                        </ul>
                    </div>
                    <div class="articles-list mt-40">
                        <div class="article">
                            <div class="article_tag">
                                Удаленные занятия
                            </div>
                            <div class="article-image">
                                <img src="/images/pages/index/intro-img.jpg">
                            </div>
                            <div class="article_info">
                                <div class="article_title">
                                    Логопедическая работа с детьми 4-5 лет с общим недоразвитием речи
                                </div>
                                <div class="article_text">
                                    В статье раскрываются особенности логопедической работы с детьми 4–5 лет. Представление теоретические аспекты нормально-развивающейся речи ребёнка 4–5 лет.
                                </div>
                                <a href="#" class="button dark-outline">
                                    Подробнее
                                </a>
                            </div>
                        </div>
                        <div class="article">
                            <div class="article_tag">
                                Удаленные занятия
                            </div>
                            <div class="article-image">
                                <img src="images/pages/articles/article.jpg" alt="">
                            </div>
                            <div class="article_info">
                                <div class="article_title">
                                    Логопедическая работа с детьми 4-5 лет с общим недоразвитием речи
                                </div>
                                <div class="article_text">
                                    В статье раскрываются особенности логопедической работы с детьми 4–5 лет. Представление теоретические аспекты нормально-развивающейся речи ребёнка 4–5 лет.
                                </div>
                                <a href="#" class="button dark-outline">
                                    Подробнее
                                </a>
                            </div>
                        </div>
                        <div class="article">
                            <div class="article_tag">
                                Удаленные занятия
                            </div>
                            <div class="article-image">
                                <img src="images/pages/articles/article.jpg" alt="">
                            </div>
                            <div class="article_info">
                                <div class="article_title">
                                    Логопедическая работа с детьми 4-5 лет с общим недоразвитием речи
                                </div>
                                <div class="article_text">
                                    В статье раскрываются особенности логопедической работы с детьми 4–5 лет. Представление теоретические аспекты нормально-развивающейся речи ребёнка 4–5 лет.
                                </div>
                                <a href="#" class="button dark-outline">
                                    Подробнее
                                </a>
                            </div>
                        </div>
                        <div class="pagination default">
                            <ul>
                                <li class="prev-button">
                                    <a href="#"></a>
                                </li>
                                <li class="active">
                                    <a href="#">
                                        1
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        2
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        3
                                    </a>
                                </li>
                                <li>
                                    ...
                                </li>
                                <li>
                                    <a href="#">
                                        15
                                    </a>
                                </li>
                                <li class="next-button">
                                    <a href="#"></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="sidebar">
                    <div class="sidebar_tags">
                        <div class="title medium center-md">
                            Теги
                        </div>
                        <ul class="tags_list">
                            <li>
                                <a href="#">
                                    Удаленные занятия
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    Английский язык
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    Работа
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="sidebar_previews-articles mt-40">
                        <div class="title medium center-md">
                            Последние статьи
                        </div>
                        <ul class="previews-articles_list">
                            <li>
                                <a href="" class="preview-article">
                                    <div class="preview-article_image">
                                        <img src="images/pages/index/intro-img.jpg">
                                    </div>
                                    <div class="preview-article_title">
                                        Преподавательская работа с детьми 4-5 лет
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="" class="preview-article">
                                    <div class="preview-article_image">
                                        <img src="images/pages/index/intro-img.jpg">
                                    </div>
                                    <div class="preview-article_title">
                                        Преподавательская работа с детьми 4-5 лет
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="" class="preview-article">
                                    <div class="preview-article_image">
                                        <img src="images/pages/index/intro-img.jpg">
                                    </div>
                                    <div class="preview-article_title">
                                        Преподавательская работа с детьми 4-5 лет
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
