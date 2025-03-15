<?php namespace App\Pages\feeds\detail;

use App\Pages\MobileBaseController;
use CodeIgniter\API\ResponseTrait;

class PageController extends MobileBaseController 
{
    use ResponseTrait;

    protected $pageTitle    = "Feed Detail";
    protected $pageTemplate = 'feeds/detail/index';

    public function getInit($id)
    {
        $data['id'] = $id;

        // Get post data
		$query = "SELECT `mein_microblogs`.`id`, `medias`, `title`, `content`, 
            `total_like`, `total_comment`, `author` as `author_id`, users.avatar,
            `users`.`name` as `author_name`, `mein_microblogs`.`status` as `status`, 
            `mein_microblogs`.`created_at` as `created_at`, 
            `mein_microblogs`.`published_at` as `published_at`
            FROM `mein_microblogs`
            JOIN `users` ON `users`.`id`=`mein_microblogs`.`author`
            WHERE `mein_microblogs`.`id` = :id:";


        // Get database pesantren
        $db = \Config\Database::connect();

        $data['post'] = $db->query($query, ['id' => $data['id']])->getRowArray();  
        $data['post']['medias'] = json_decode($data['post']['medias'], true);
        
        return $this->respond([
			'response_code'    => 200,
			'response_message' => 'success',
			'data'             => $data
		]);
    }
}
