<?php

use models\admin\Article;
use models\admin\Book;

spl_autoload_register();

if (isset($_GET['route'])) {
    switch ($_GET['route']) {
        case 'articles':
            $model = new Article();
            $array_list = $model->index();
            include_once('article/index.php');
            break;

        case 'article':
            $model = new Article();
            if (isset($_GET['id']) && !empty($_GET['id'])) {
                if ($article = $model->view($_GET['id'])) {
                    include_once('article/view.php');
                }
            } 
            $model = new Article();
            $array_list = $model->index();
            include_once('article/index.php');
            break;
        case 'article_update':
            $model = new Article();
            if (isset($_GET['id']) && !empty($_GET['id'])) {
                if ($article = $model->view($_GET['id'])) {
                    include_once('article/update.php');
                }
            } 
            $model = new Article();
            $array_list = $model->index();
            include_once('article/index.php');
            break;
        case 'book_create':
            $model = new Book();
            include_once('book/create.php');
            break;
        default:
            # code...
            break;
    }
}

$article = new Article;
$article->create([
    'title' => 'New Title',
    'author' => 'New Author',
    'date_added' => 'Date Added55',
    'description' => 'Description55',
]);