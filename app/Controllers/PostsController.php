<?php

namespace App\Controllers;

use App\Models\PostsModel;
use CodeIgniter\Controller;
use App\Libraries\Translit;

class PostsController extends BaseController
{

    public function index()
    {
        $model = new PostsModel();

        $this->data = [
            'posts'  => $model->getPost(),
            'title' => 'Посты',
        ];

        return $this->render('home');
    }
    
 
 
    public function view($slug = NULL)
    {
        $model = new PostsModel();

        $this->data['posts'] = $model->getPost($slug);

        if (empty($this->data['posts']))
        {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Не удается найти пост: '. $slug);
        }

        $this->data['title'] = $this->data['posts']['post_title'];

      
        return $this->render('posts/view');
     
    } 
    
    
    // Добавление поста
    public function create()
    {
        $model = new PostsModel();

        $this->data['title'] = 'Добавление новости';
 
        if ($this->request->getMethod() === 'post' && $this->validate([
                'post_title' => 'required|min_length[3]|max_length[255]',
                'post_content'  => 'required',
            ]))
        {
            

            $model->save([
                'post_title' => $this->request->getPost('post_title'),
                'post_slug'  => url_title(Translit::SeoUrl($this->request->getPost('post_title')), '-', TRUE),
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