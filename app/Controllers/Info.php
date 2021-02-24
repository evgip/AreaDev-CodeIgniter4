<?php

namespace App\Controllers;

class Info extends BaseController
{
	public function index()
	{
        $this->data['title'] = 'Информация';
        
        return $this->render('info/index');
	}
}
