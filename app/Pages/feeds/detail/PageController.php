<?php namespace App\Pages\feeds\detail;

use App\Pages\MobileBaseController;
use CodeIgniter\API\ResponseTrait;

class PageController extends MobileBaseController 
{
    use ResponseTrait;

    protected $pageTitle    = "Feed Detail";
    protected $pageTemplate = 'feeds/detail/index';

    public function getData($id)
    {
        $data['id'] = $id;

        // Get mahasiswa data
		$query = "SELECT * FROM `mahasiswa`
            WHERE `id` = :id:";

        // Get database pesantren
        $db = \Config\Database::connect();

        $data['mahasiswa'] = $db->query($query, ['id' => $data['id']])->getRowArray();
        
        return $this->respond([
			'response_code'    => 200,
			'response_message' => 'success',
			'data'             => $data
		]);
    }

    public function postDelete($id)
    {
        // Get database pesantren
        $db = \Config\Database::connect();

        // Delete mahasiswa data
        $db->table('mahasiswa')->delete(['id' => $id]);

        return $this->respondDeleted([
            'response_code'    => 200,
            'response_message' => 'Data deleted successfully'
        ]);
    }
}
