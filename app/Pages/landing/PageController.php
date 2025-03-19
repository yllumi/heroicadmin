<?php namespace App\Pages\landing;

use App\Controllers\BaseController;

class PageController extends BaseController 
{
    public function getIndex()
    {
        $data = [];
        return pageView('landing/index', $data);
    }
}
