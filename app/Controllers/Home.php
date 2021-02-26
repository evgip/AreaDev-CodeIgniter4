<?php

namespace App\Controllers;

use App\Models\Users;

class Home extends BaseController
{
	public function index()
	{
        $this->data['title'] = 'Главная';
        
        $userModel = new Users();
        $id = session()->get('id');
     
        $user = $userModel->getUsersId($id);
          
        if($user)  {         
            if(!$user['avatar']) {
                $user['avatar'] = 'noavatar.png';
            }
            $this->data['usr_id']       = $user['id'];
            $this->data['usr_avatar']   = $user['avatar'];
            $this->data['usr_nickname'] = $user['nickname'];
            $this->data['usr_color']    = $user['color'];
        }
 
		return $this->render('home');
	}
}
