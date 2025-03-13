<?php namespace App\Pages;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class MobileBaseController extends BaseController 
{
	public $data = [];

	protected $pageTitle = 'Page Title';

	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

		$this->data['page_title'] = $this->pageTitle;
		$this->data['themeURL'] = base_url('mobilekit') .'/'; 
        $this->data['themePath'] = 'mobilekit/'; 
        $this->data['version'] = "1.0.0";
    }

	// Render shell template
	public function getIndex()
	{
		return pageView('mobileLayout', $this->data);
	}

	// Render inner template
	public function get_content()
    {
		$Uri = service('uri');
        $parentUriSegments = $Uri->getSegments();
        array_pop($parentUriSegments);
        $parentUri = implode($parentUriSegments);

        return pageView($parentUri . '/index');
    }

}
