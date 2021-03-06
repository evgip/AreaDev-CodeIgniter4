<?php

namespace App\Controllers;

use App\Models\Users;
use App\Models\CommentsModel;
use App\Models\PostsModel;
 
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
        
        if(!$user['avatar']) {
                $user['avatar'] = 'noavatar.png';
        }

        $this->data['id']           = $user['id'];
        $this->data['nickname']     = $user['nickname'];
        $this->data['name']         = $user['name'];
        $this->data['avatar']       = $user['avatar'];
        $this->data['about']        = $user['about'];
        $this->data['created_at']   = $user['created_at'];
        
        // Показываем количество комментариев
        $userCommNum = new CommentsModel();
        $this->data['comm_num_user']     = $userCommNum->getUsersCommentsNum($user['id']);
        
        // Показываем количество постов
        $userPostNum = new PostsModel();
        $this->data['post_num_user']     = $userPostNum->getUsersPostsNum($user['id']);
        
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
