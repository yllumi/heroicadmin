<?php namespace App\Pages\feeds\detail;

use App\Pages\PageBaseController;
use CodeIgniter\API\ResponseTrait;

class PageController extends PageBaseController 
{
    use ResponseTrait;

    protected $pageTitle    = "Feed Detail";

    public function getData($id)
    {
        $data['id'] = $id;

        // Get mahasiswa data
		$query = "SELECT * FROM `mahasiswa`
            WHERE `id` = :id:";

        // Get database pesantren
        $db = \Config\Database::connect();

        $data['mahasiswa'] = $db->query($query, ['id' => $data['id']])->getRowArray();

        // Get post data
		$query2 = "SELECT *
        FROM `mahasiswa`
        ORDER BY created_at desc";

        $data['list'] = $db->query($query2)->getResultArray();
        
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
