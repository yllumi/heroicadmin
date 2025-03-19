<?php namespace App\Pages\admin;

use App\Pages\PageBaseController;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class AdminBaseController extends PageBaseController 
{
    use ResponseTrait;

    public $data = [];

	protected $pageTitle = 'Admin';

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

		$this->data['themeURL'] = base_url('admin') .'/'; 
        $this->data['themePath'] = 'admin/';
    }

    public function getIndex()
    {
        return pageView('admin/layout', $this->data);
    }

}
