<?php namespace App\Pages\intro;

use App\Pages\BasePageController;

class PageController extends BasePageController {
    
    public function getContent()
    {
        return pageView('intro/index', $this->data);
    }

}