<?php namespace App\Pages\admin\user;

use App\Pages\admin\AdminBaseController;

class PageController extends AdminBaseController 
{
    public function getData()
    {
        $data = [
            'page_title'      => 'Users',
            'page_subtitle'   => 'User registered on this platform',
            'breadcrumbs'     => [
                'Dashboard' => '/admin',
                'Users'     => '/admin/user',
            ],
            
            'welcome_message' => 'Welcome to Heroic!'
        ];

        return $this->respond([
			'response_code'    => 200,
			'response_message' => 'success',
			'data'             => $data
		]);
    }
}
