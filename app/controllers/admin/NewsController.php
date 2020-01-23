<?php

namespace App\Controllers\Admin;

use App\Models\News;
use Igoframework\Core\Base\View;
use Igoframework\Core\Pagination\Paginator;

class NewsController extends BaseController
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
        $this->setVars(compact('news', 'pagination'));
        View::setMeta('Админка | Управление новостями');
    }

    public function createAction() {}

    public function storeAction()
    {
        if (! empty($_POST)) {
            $news = new News();
            $data = $_POST;
//            dd($data);
            $news->load($data);

            if (! $news->validate($data)) {
                $news->getMiniErrors();
                redirect();
            }

            if (empty($news->attributes['date'])) {
                $news->attributes['date'] = $news->getCurrentDate();
            }

            if (! $news->addImage($_FILES) && $_FILES['image']['error'] != 4) {
                $news->getMiniErrors();
                redirect();
            }

            if ($news->save($news->attributes)) {
                $_SESSION['success'] = 'Новость успешно добавлена';
            } else {
                $_SESSION['errors'] = 'Ошибка добавления новости';
            }
            redirect('/admin');
        }
    }

//    public function allowAction()
//    {
//        $id = $this->getId();
//        if ($id) {
//            $comments = new Comments;
//            $comments->update(['status' => 1], $id);
//        }
//        redirect();
//    }
//
//    public function disallowAction()
//    {
//        $id = $this->getId();
//        if ($id) {
//            $comments = new Comments;
//            $comments->update(['status' => 0], $id);
//        }
//        redirect();
//    }

    public function deleteAction()
    {
        $id = (int) $this->route['param'];

        if ($id) {
            $news = new News();
            $item = $news->findOne($id);
            $news->deleteImage($item);
            $news->delete($id);
        }
        redirect();
    }
}