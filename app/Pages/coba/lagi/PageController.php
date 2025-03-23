<?php namespace App\Pages\coba\lagi;

use Yllumi\Heroic\Controllers\PageBaseController;
use CodeIgniter\API\ResponseTrait;

class PageController extends PageBaseController 
{
    use ResponseTrait;

    public $data = [
        'page_title' => "Coba Lagi Page"
    ];

    public function getData()
    {
        $this->data['name'] = "Saige Dibbert";

        return $this->respond([
			'response_code'    => 200,
			'response_message' => 'success',
			'data'             => $this->data
		]);
    }
}
