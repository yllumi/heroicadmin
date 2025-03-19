<?php namespace App\Pages\admin;

use App\Pages\AdminBaseController;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class PageController extends AdminBaseController 
{
    use ResponseTrait;

    protected $pageTitle = 'Admin';
	protected $pageTemplate = 'admin/template';

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

		$this->data['author'] = "Toni Haryanto";
    }

    public function getData()
    {
        $data = [
            'page_title'      => 'Dashboard',
            'page_subtitle'   => 'Summary and shortcut',
            'breadcrumbs'     => [
                'Dashboard' => '/admin'
            ],
            
            'welcome_message' => 'Welcome to Heroic!'
        ];

        return $this->respond([
			'response_code'    => 200,
			'response_message' => 'success',
			'data'             => $data
		]);
    }
    
    public function getInlineWidget()
    {
        $data = [
            'widget_title'    => 'Just another fucking widget!',
        ];

        return $this->respond([
			'response_code'    => 200,
			'response_message' => 'success',
			'data'             => $data
		]);
    }
    
    public function getEmbedWidget($slug = '')
    {
        $data = [
            'widget_title'  => 'This is embedded widget!',
            'slug'          => $slug
        ];

        return $this->respond([
			'response_code'    => 200,
			'response_message' => 'success',
			'data'             => $data
		]);
    }
}
