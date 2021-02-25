<?php

namespace App\Controllers;
use App\Models\User;

class Home extends BaseController
{
	public function index()
	{
        $this->data['title'] = 'Главная';
 
        if (session()->get('isLoggedIn'))
		{ 
            $userModel = new User();
            $user      =  $userModel->first($id);
            $this->data['color'] = $user['color'];
        } else {
            $this->data['color'] = 0;
        }
        
		return $this->render('home');
	}
}
