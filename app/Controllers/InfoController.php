<?php

namespace App\Controllers;

use App\Models\Users;

class InfoController extends BaseController
{
	public function index()
	{
        $this->data['title'] = 'Информация';
        
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
        
        
        return $this->render('info/index');
	}
    
    public function stats()
	{
        $this->data['title'] = 'Статистика';
        
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
        
        
        return $this->render('info/stats');
	}
    
	public function rules()
	{
        $this->data['title'] = 'Правила';
        
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
        
        
        return $this->render('info/rules');
	}
}
