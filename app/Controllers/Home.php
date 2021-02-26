<?php

namespace App\Controllers;

class Home extends BaseController
{
	public function index()
	{
        
        $this->data['title'] = 'Главная';
        
		return $this->render('home');
        
	}
}
