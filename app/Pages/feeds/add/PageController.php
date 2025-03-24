<?php

namespace App\Pages\feeds\add;

use Yllumi\Heroic\Controllers\PageBaseController;
use CodeIgniter\API\ResponseTrait;

class PageController extends PageBaseController
{
    use ResponseTrait;

    protected $pageTitle    = "Add new feed";

    public function postInsert()
    {
        $postData = $this->request->getPost();

        // Set validation rules for nama dan nim
        $validation = \Config\Services::validation();
        $validation->setRules([
            'nama' => 'required|min_length[2]|max_length[255]',
            'nim'  => 'required|numeric|min_length[8]|max_length[12]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->respond([
                'response_code'    => 400,
                'response_message' => 'Validation error',
                'model_messages'   => $validation->getErrors(),
            ]);
        }

        $db = \Config\Database::connect();
        $result = $db->table('mahasiswa')->insert($postData);

        return $this->respond([
            'response_code'    => 200,
            'response_message' => 'success',
            'data'    => ['result' => $result, 'id' => $db->insertID()]
        ]);
    }
}
