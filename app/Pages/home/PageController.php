<?php namespace App\Pages\home;

use App\Controllers\BaseController;

class PageController extends BaseController 
{
    public function getIndex()
    {
        $data = [];
        return pageView('home/index', $data);
    }
}
