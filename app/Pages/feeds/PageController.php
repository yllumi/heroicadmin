<?php namespace App\Pages\feeds;

use App\Pages\PageBaseController;
use CodeIgniter\API\ResponseTrait;

class PageController extends PageBaseController 
{
    use ResponseTrait;

    protected $pageTitle    = "Feeds";

    public function getData()
    {
        // Retrieve extension attributes
		$page = (int)($this->request->getGet('page') ?? 1);
		$status = $this->request->getGet('status') ?? 'publish';
		$perpage = (int)($this->request->getGet('perpage') ?? 15);
		$offset = ($page-1) * $perpage;

        // Get post data
		$query = "SELECT *
            FROM `mahasiswa`
            ORDER BY created_at desc
            LIMIT :offset:, :perpage:";

        // Get database pesantren
        $db = \Config\Database::connect();

        $posts = $db->query($query, [
            'offset' => $offset,
            'perpage' => $perpage
        ])->getResultArray();

		return $this->respond([
			'response_code'    => 200,
			'response_message' => 'success',
			'paginatedData'    => $posts
		]);
    }
}
