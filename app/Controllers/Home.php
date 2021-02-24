<?php

namespace App\Controllers;
use App\Models\User;

class Home extends BaseController
{
	public function index()
	{
        $this->data['title'] = 'Главная';
        $this->data['do']    = 'home';
         
        $userModel = new User();
        $user      =  $userModel->first($id);
        
        $this->data['color'] = $user['color'];
        
		return $this->render('home');
	}
}
