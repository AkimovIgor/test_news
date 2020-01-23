<?php

namespace App\Controllers\Admin;

use Igoframework\Core\Base\View;
use App\Models\Comments;
use Igoframework\Core\Pagination\Paginator;

class CommentController extends BaseController
{
    public function indexAction()
    {
        $comments = new Comments;
        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
        $perPage = 4;
        $totalCount = $comments->getCount();
        $pagination = new Paginator($currentPage, $perPage, $totalCount);
        $offset = $pagination->getOffset();
        $comments = $comments->getAllForPaginate(null, 'DESC', 'id', $perPage, $offset);
        $this->setVars(compact('comments', 'pagination'));
        View::setMeta('Админка | Управление комментариями');
    }

    public function allowAction()
    {
        $id = $this->getId();
        if ($id) {
            $comments = new Comments;
            $comments->update(['status' => 1], $id);
        }
        redirect();
    }

    public function disallowAction()
    {
        $id = $this->getId();
        if ($id) {
            $comments = new Comments;
            $comments->update(['status' => 0], $id);
        }
        redirect();
    }

    public function deleteAction()
    {
        $id = $this->getId();
        if ($id) {
            $comments = new Comments;
            $comments->delete($id);
        }
        redirect();
    }
}