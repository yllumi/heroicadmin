<?php namespace App\Pages\logout;

use App\Pages\BasePageController;
use CodeIgniter\API\ResponseTrait;

class PageController extends BasePageController 
{
    use ResponseTrait;
    
    public function getIndex()
    {
        return pageView('logout/index', $this->data);
    }

    public function getRemoveSession()
    {
        $_SESSION = [];
    }

}