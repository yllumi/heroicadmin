<?php namespace App\Pages;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class PageBaseController extends BaseController 
{
	public $data = [];

	protected $pageTitle = 'Page Title';
	protected $pageTemplate;

	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

		$this->data['page_title'] = $this->pageTitle;
		$this->data['themeURL'] = base_url('mobilekit') .'/'; 
        $this->data['themePath'] = 'mobilekit/'; 
    }

	// Render shell template
	public function getIndex()
	{
		return pageView('layout', $this->data);
	}

	// Render inner template
	public function getTemplate()
    {
		// Set $pageTemplate automatically based on folder path
		$classPathDir = dirname((new \ReflectionClass(static::class))->getFileName());
		$this->pageTemplate = str_replace(APPPATH .'Pages/', '', $classPathDir) . '/template';
		
        return pageView(trim($this->pageTemplate,'/'), $this->data);
    }

}
