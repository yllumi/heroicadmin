<?php namespace App\Pages\admin\user\detail;

use App\Pages\AdminBaseController;

class PageController extends AdminBaseController 
{
    public function getTemplate($param = null)
    {
        $data['id'] = $param;

        // Get detail mahasiswa
                // Get post data
		$query = "SELECT *
            FROM `mahasiswa`
            WHERE id = :id:";

        // Get database pesantren
        $db = \Config\Database::connect();

        $data['user'] = $db->query($query, [
            'id' => $data['id']
        ])->getRowArray();

        return pageView('admin/user/detail/template', $data);
    }
}
