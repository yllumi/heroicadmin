<?php namespace App\Pages\admin\user;

use App\Pages\AdminBaseController;

class PageController extends AdminBaseController 
{
    public function getData($page = 1)
    {
        // Retrieve extension attributes
		$perpage = (int)($this->request->getGet('perpage') ?? 2);
		$offset = ($page-1) * $perpage;

        // Get post data
		$query = "SELECT *
            FROM `mahasiswa`
            ORDER BY created_at desc
            LIMIT :offset:, :perpage:";

        // Get database pesantren
        $db = \Config\Database::connect();

        $data['users'] = $db->query($query, [
            'offset' => $offset,
            'perpage' => $perpage
        ])->getResultArray();

		return $this->respond([
			'response_code'    => 200,
			'response_message' => 'success',
			'paginatedData'    => $data['users'],
            'page'             => $page
		]);
    }
}
