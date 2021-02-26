<?php

namespace App\Controllers;

use App\Models\Users;
 
class UsersController extends BaseController
{
    
    // Список участников
	public function index()
	{

        $this->data['title'] = 'Профиль';
        
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
        
        $users = $userModel->getUsersAll();
        
        $this->data['all_users'] = $users;
        
       
		return $this->render('users/all');

	}
    
    // Детальная страница пользователя
    public function usersProfile()
	{
        $this->data['title'] = 'Профиль пользователя';
        
        $slug = service('uri')->getSegment(2);
        $userModel = new Users();
        $user = $userModel->getUsersLogin($slug); 
  
        // Покажем 404
        if(!$user) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        
        if(!$user['avatar']) {
            $user['avatar'] = 'noavatar.png';
        }
        
        $this->data['usr_id'] = $user['id'];
        $this->data['usr_nickname'] = $user['nickname'];
        $this->data['usr_color'] = $user['color'];
        $this->data['usr_avatar']   = $user['avatar'];
        
		return $this->render('users/profile');

	}
    
 
}
