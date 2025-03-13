<?php namespace App\Pages\feeds;

use App\Pages\MobileBaseController;
use CodeIgniter\API\ResponseTrait;

class PageController extends MobileBaseController 
{
    use ResponseTrait;

    protected $pageTitle = "Feeds";

    public function getContent()
    {
        $data['name'] = 'Toni Haryanto';
        return pageView('feeds/index', $data);
    }

    public function getDetail()
    {
        $data['name'] = 'Detail Feed';
        $Uri = service('uri');
        $data['slug'] = $Uri->getSegment(2);

        return pageView('feeds/detail', $data);
    }

    public function getContentDetail()
    {
        $data['name'] = 'Detail Feed';

        return pageView('feeds/detail', $data);
    }

    public function getSupply()
    {
        $data['feeds'] = [
            [
                'title' => 'Lorem ipsum dolor sit amet',
                'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla nec purus feugiat, molestie ipsum et, consectetur libero. Nulla facilisi. Nulla nec purus feugiat, molestie ipsum et, consectetur libero. Nulla facilisi.',
                'image' => 'https://via.placeholder.com/500x500.png',
                'date' => '2021-10-10',
            ],
            [
                'title' => 'Lorem ipsum dolor sit amet',
                'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla nec purus feugiat, molestie ipsum et, consectetur libero. Nulla facilisi. Nulla nec purus feugiat, molestie ipsum et, consectetur libero. Nulla facilisi.',
                'image' => 'https://via.placeholder.com/500x500.png',
                'date' => '2021-10-10',
            ],
            [
                'title' => 'Lorem ipsum dolor sit amet',
                'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla nec purus feugiat, molestie ipsum et, consectetur libero. Nulla facilisi. Nulla nec purus feugiat, molestie ipsum et, consectetur libero. Nulla facilisi.',
                'image' => 'https://via.placeholder.com/500x500.png',
                'date' => '2021-10-10',
            ],
            [
                'title' => 'Lorem ipsum dolor sit amet',
                'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla nec purus feugiat, molestie ipsum et, consectetur libero. Nulla facilisi. Nulla nec purus feugiat, molestie ipsum et, consectetur libero. Nulla facilisi.',
                'image' => 'https://via.placeholder.com/500x500.png',
                'date' => '2021-10-10',
            ],
            [
                'title' => 'Lorem ipsum dolor sit amet',
                'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla nec purus feugiat, molestie ipsum et, consectetur libero. Nulla facilisi. Nulla nec purus feugiat, molestie ipsum et, consectetur
                libero. Nulla facilisi.',
                'image' => 'https://via.placeholder.com/500x500.png',
                'date' => '2021-10-10',
            ],
        ];

        return $this->respond([
            'status' => 'success',
            'data' => $data,
        ]);
    }
}
