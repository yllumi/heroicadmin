<?php namespace App\Pages;

use App\Controllers\BaseController;

class MobileBaseController extends BaseController 
{
	public $data;

	// This method handle GET request
	public function getIndex()
	{
        $this->data['title'] = 'HeroicAdmin';
		$this->data['page_title'] = 'Beranda';
		$this->data['themeURL'] = base_url('mobilekit') .'/'; 
        $this->data['themePath'] = 'mobilekit/'; 
        $this->data['version'] = "1.0.0";

		return pageView('mobileLayout', $this->data);
	}

}