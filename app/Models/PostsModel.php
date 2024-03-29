<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Libraries\Translit;

class PostsModel extends Model
{
    protected $table = 'posts';
    protected $primaryKey = 'post_id';
    protected $allowedFields = ['post_title', 'post_slug', 'post_content', 'post_user_id', 'post_comments', 'post_ip_int'];
      
    // Посты на главной странице сайта
    public function getPostHome()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('posts AS a');
        $builder->select('a.*, b.id, b.nickname, b.avatar');
        $builder->join("users AS b", "b.id = a.post_user_id");
        $builder->orderBy('a.post_id', 'DESC');

        $result = $builder->get()->getResult();
 
        return $result;
           
    }
    
    // Полная версия поста  
    public function getPost($slug)
    {

        $db = \Config\Database::connect();
        $builder = $db->table('posts AS a');
        $builder->select('a.*, b.id, b.nickname, b.avatar');
        $builder->join("users AS b", "b.id = a.post_user_id");
        $builder->where('a.post_slug', $slug);
        $builder->orderBy('a.post_id', 'DESC');
         
        $result = $builder->get()->getRow();

        return $result;

    }
    
    // Получаем по id (объединить потом) 
    public function getPostId($id)
    {

        $db = \Config\Database::connect();
        $builder = $db->table('posts AS a');
        $builder->select('a.*, b.id, b.nickname, b.avatar');
        $builder->join("users AS b", "b.id = a.post_user_id");
        $builder->where('a.post_id', $id);
        $builder->orderBy('a.post_id', 'DESC');
         
        $result = $builder->get()->getRow();

        return $result;

    }
    
    // Возвращаем количество комментариев +1
    // Опишем пока подробно...
    public function getNumComments($post_id)
    {
        
        $db = \Config\Database::connect();
        $builder = $db->table('posts');
        $builder->where('post_id', $post_id);
        $post = $builder->get()->getRow();
        $post_comments = $post->post_comments;
        return $post_comments + 1;
        
    }


    // Проверка на дубликаты slug
    public function seoSlug($post_title)
    {
        $seo_slug = url_title(Translit::SeoUrl($post_title), '-', TRUE);
        
        $db = \Config\Database::connect();
        $builder = $db->table('posts');
        $builder->where('post_slug', $seo_slug);
        $post = $builder->get()->getRow();
        
        if ($post) {
            return $seo_slug =  $post->post_slug . "-";
        }
        
        return $seo_slug;
        
    } 

    // Проверка на дубликаты slug
    public function PostId()
    {
        
        $db = \Config\Database::connect();
        $builder = $db->table('posts');
        return $db->insertID(); 
        
    } 

    // Страница постов участника
    public function getUsersPosts($slug)
    {
        
        $db = \Config\Database::connect();
        $builder = $db->table('posts AS a');
        $builder->select('a.*, b.id, b.nickname, b.avatar');
        $builder->join("users AS b", "b.id = a.post_user_id");
        $builder->where('b.nickname', $slug);
        $builder->orderBy('a.post_id', 'DESC');     
   
        $result = $builder->get()->getResult();

        return $result;
    } 

    // Количество постов на странице профиля
    public function getUsersPostsNum($slug)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('posts AS a');
        $builder->select('a.*, b.id, b.nickname, b.avatar');
        $builder->join("users AS b", "b.id = a.post_user_id");
        $builder->where('b.id', $slug);
        
        $result = $builder->countAllResults();

        return $result;
    } 
}
 