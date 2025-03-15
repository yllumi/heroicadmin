<?php namespace App\Pages\feeds\add;

use App\Pages\MobileBaseController;
use CodeIgniter\API\ResponseTrait;

class PageController extends MobileBaseController 
{
    use ResponseTrait;

    protected $pageTitle    = "Add new feed";
    protected $pageTemplate = 'feeds/add/index';

    public function getInit()
    {
        $data = [];

        return $this->respond([
			'response_code'    => 200,
			'response_message' => 'success',
			'paginatedData'    => $data
		]);
    }

    public function postInsert()
    {
        $postData = $this->request->getPost();

        $db = \Config\Database::connect();
        $result = $db->table('mahasiswa')->insert($postData);

        return $this->respond([
			'response_code'    => 200,
			'response_message' => 'success',
			'data'    => ['result' => $result, 'id' => $db->insertID()]
		]);
    }
}
