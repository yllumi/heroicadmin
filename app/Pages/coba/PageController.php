<?php namespace App\Pages\coba;

use Yllumi\Heroic\Controllers\PageBaseController;
use CodeIgniter\API\ResponseTrait;

class PageController extends PageBaseController 
{
    use ResponseTrait;

    public $data = [
        'page_title' => "My Coba Page"
    ];

    public function getData()
    {
        $this->data['name'] = "Horacio Adams";

        return $this->respond([
			'response_code'    => 200,
			'response_message' => 'success',
			'data'             => $this->data
		]);
    }
}
