<?php

namespace Igoframework\Core\Pagination;

class Paginator
{
    public $currentPage;      // текущая страница
    public $perPage;          // количество записей на одну страницу
    public $totalCount;       // общее количество записей 
    public $countPages;       // количество страниц
    public $countLinks = 2;   // количество ссылок справа и слева от текущей
    public $uri;             // префикс к текущей странице
    public $start;            // стартовое значение для цикла вывода
    public $end;              // конечное значение для цикла вывода

    public function __construct($currentPage, $perPage, $totalCount)
    {
        $this->perPage = $perPage;
        $this->totalCount = $totalCount;
        $this->countPages = $this->getCountPages();
        $this->currentPage = $this->getCurrentPage($currentPage);
        $this->uri = $this->getParams();
        $this->start = $this->getStart();
        $this->end = $this->getEnd();
    }

    public function __toString()
    {
        return $this->getHtml();
    }

    /**
     * Получить количество всех страниц пагинации
     *
     * @return integer
     */
    public function getCountPages()
    {
        return ceil($this->totalCount / $this->perPage) ?: 1;
    }

    /**
     * Получить текущую страницу
     *
     * @param  ineger $page Номер страницы
     *
     * @return integer
     */
    public function getCurrentPage($page)
    {
        $page = (int) hsc($page);
        if (! $page || $page < 1) $page = 1;
        if ($page > $this->countPages) $page = $this->countPages;
        return $page; 
    }

    public function getOffset()
    {
        return $this->currentPage * $this->perPage - $this->perPage;
    }

    public function getStart()
    {
        return (($this->currentPage - $this->countLinks) > 0) ? $this->currentPage - $this->countLinks : 1;
    }

    public function getEnd()
    {
        return (($this->currentPage + $this->countLinks) < $this->countPages) ? $this->currentPage + $this->countLinks : $this->countPages;
    }

    /**
     * Получить строку запроса вместе со списком GET параметров
     *
     * @return string
     */
    public function getParams()
    {
        $url = $_SERVER['REQUEST_URI'];
        $url = explode('?', $url);
        $uri = $url[0] . '?';
        if (isset($url[1]) && $url[1] != '') {
            $params = explode('&', $url[1]);
            foreach ($params as $param) {
                if (! preg_match("#page=#", $param)) {
                    $uri .= "{$param}&amp;";
                }
            }
        }
        return $uri;
    }

    /**
     * Формирование HTML для пагингации
     *
     * @return string
     */
    public function getHtml()
    {
        $prev = '';
        $next = '';
        $startPage = '';
        $endPage = '';
        $pageList = '';

        if ($this->currentPage > 1) {
            $prev = "<li class='page-item'><a class='page-link' href='{$this->uri}page=" . ($this->currentPage - 1) . "'>&lsaquo;</a></li>";
            $startPage = "<li class='page-item'><a class='page-link' href='{$this->uri}page=1'>&laquo;</a></li>";
        }
        if ($this->currentPage < $this->countPages) {
            $next = "<li class='page-item'><a class='page-link' href='{$this->uri}page=" . ($this->currentPage + 1) . "'>&rsaquo;</a></li>";
            $endPage = "<li class='page-item'><a class='page-link' href='{$this->uri}page={$this->countPages}'>&raquo;</a></li>";
        }

        for ($i = $this->start; $i <= $this->end; $i++) {
            $pageList .= "<li class='page-item";
            if ($i == $this->currentPage) $pageList .= " active";
            $pageList .= "'><a class='page-link' href='{$this->uri}page={$i}'>{$i}</a></li>";
        }

        return "<ul class='pagination justify-content-center mb-0'>{$startPage}{$prev}{$pageList}{$next}{$endPage}</ul>";
    }
}