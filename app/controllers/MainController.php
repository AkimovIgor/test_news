<?php

namespace App\Controllers;

use App\Models\Comments;
use App\Models\News;
use Igoframework\Core\App;
use Igoframework\Core\Base\View;
use Igoframework\Core\Pagination\Paginator;

class MainController extends BaseController
{
    public function indexAction()
    {
        $news = new News();
        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
        $perPage = 4;
        $totalCount = $news->getCount();
        $pagination = new Paginator($currentPage, $perPage, $totalCount);
        $offset = $pagination->getOffset();
        $news = $news->getAllForPaginate(null, 'DESC', 'id', $perPage, $offset);
//        dd($pagination);
        $this->setVars(compact('news', 'pagination'));
        View::setMeta('Главная');
    }

    public function showAction()
    {
        $newsId = (int) $this->route['param'];
        $news = new News();
        $item = $news->findOne($newsId);
        if (empty($item)) redirect();
        $this->setVars(compact('item'));
        View::setMeta('Просмотр новости ' . $item['title']);
    }
}