<?php namespace App\Pages\sample_mobile;

use App\Pages\MobileBaseController;

class PageController extends MobileBaseController 
{
    public function getContent()
    {
        $data = [];
        return pageView('sample_mobile/index', $data);
    }
}
