<?php namespace App\Pages;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class BasePageController extends BaseController 
{
	use ResponseTrait;

	// This method handle GET request
	public function getIndex()
	{
		$this->data['page_title'] = 'Beranda';

		return pageView('layout', $this->data);
	}

}