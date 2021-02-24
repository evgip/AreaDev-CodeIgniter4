<?php

namespace App\Controllers;

use App\Models\User;
 
class Profile extends BaseController
{
    
    // Покажим профиль самому участнику
	public function index()
	{

        $this->data['title'] = 'Профиль';
        
		return $this->render('user/profile');

	}
    
    // Детальная страница пользователя
    public function user()
	{
        $userModel = new User();
        $id = service('uri')->getSegment(2);
        
        $user = $userModel->find($id);
        
        // Покажем 404
        if(!$user) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        
        $this->data['title'] = 'Профиль пользователя';
        $this->data['id'] = $user['id'];
        $this->data['nickname'] = $nickname;
        
		return $this->render('user/user');

	}
 
}
