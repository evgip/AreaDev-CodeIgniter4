<?php

namespace App\Controllers;

use App\Models\PostsModel;
use App\Models\CommentsModel;
use CodeIgniter\Controller;

use CodeIgniter\I18n\Time;
$myTime = new Time('now', 'Europe/Moscow', 'ru_RU');

class PostsController extends BaseController
{

    public function index()
    {
        $model = new PostsModel();
   
        $this->data = [
            'posts'  => $model->getPostHome(),
            'title' => 'Посты',
        ];

        return $this->render('home');
    }
    
    // Полный пост
    public function view($slug = NULL)
    {
        $post_model = new PostsModel();
        $comm_model = new CommentsModel();

        $this->data['posts'] = $post_model->getPost($slug);
        
        $this->data['comments'] = $comm_model->getCommentsPost($this->data['posts']['id']);
        
        if (empty($this->data['posts']))
        {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Не удается найти пост: '. $slug);
        }

        $this->data['title'] = $this->data['posts']['title'];

        return $this->render('posts/view');
        
    } 
    
    // Добавление поста
    public function create()
    {
        
        // Авторизировались или нет
        if (!session()->get('isLoggedIn'))
		{
			return redirect()->to('/');
		}  
        
        $model = new PostsModel();

        $this->data['title'] = 'Добавление новости';
 
        if ($this->request->getMethod() === 'post' && $this->validate([
                'post_title' => 'required|min_length[3]|max_length[255]',
                'post_content'  => 'required',
            ]))
        {
            
            $post_title = $this->request->getPost('post_title');
            
            $model->save([
                'post_title'    => $this->request->getPost('post_title'),
                'post_slug'     => $model->seoSlug($post_title),
                'post_ip_int'   => $this->request->getIPAddress(), 
                'post_content'  => $this->request->getPost('post_content'),
                'post_user_id'  => session()->get('id'),
            ]);

            return $this->render('posts/success');

        }
        else
        {
            return $this->render('posts/add');
        }
    }
}