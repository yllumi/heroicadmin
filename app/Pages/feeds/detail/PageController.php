<?php namespace App\Pages\feeds\detail;

use App\Pages\MobileBaseController;
use CodeIgniter\API\ResponseTrait;

class PageController extends MobileBaseController 
{
    use ResponseTrait;

    protected $pageTitle    = "Feed Detail";
    protected $pageTemplate = 'feeds/detail/index';

    public function getInit($id)
    {
        $data['id'] = $id;
        
        return $this->respond([
			'response_code'    => 200,
			'response_message' => 'success',
			'data'             => $data
		]);
    }
}
