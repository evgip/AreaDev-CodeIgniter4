<?php

namespace App\Controllers;

use App\Models\Users;
 
class UsersController extends BaseController
{
    
    // Список участников
	public function index()
	{
        $userModel = new Users();
        $this->data['all_users'] = $userModel->getUsersAll();
        
        $this->data['title'] = 'Список участников';
        
		return $this->render('users/all');

	}
    
    // Детальная страница пользователя
    public function usersProfile()
	{
        
        $slug = service('uri')->getSegment(2);
        $userModel = new Users();
        $user = $userModel->getUsersLogin($slug); 
  
        // Покажем 404
        if(!$user) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        
        $this->data['title'] = 'Профиль пользователя';
        
		return $this->render('users/profile');

	}
    
    // Поменяем цвет страницы
    public function color($color)
	{
        if($color == 1) {
          delete_cookie('color', 0);
          set_cookie('color', 1);
        } else {
          delete_cookie('color', 1);
          set_cookie('color', 0);
        }
        return true;
    }
}
