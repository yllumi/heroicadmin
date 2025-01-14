<?php namespace App\Pages\home;

use App\Controllers\BaseController;

class PageController extends BaseController 
{
    public function getIndex()
    {
        $fieldSchema = [
            'name' => 'Name',
            'form' => 'text',
            'default' => 'John Doe'
        ];
        $TextField = new \App\Libraries\FormFields\text\TextField($fieldSchema);
        $data['input'] = $TextField->renderInput();

        $data['page_title'] = "Dashboard";
        return pageView('home/index', $data);
    }
}
