<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Libraries\Parsedown; 
 
use CodeIgniter\I18n\Time;
$myTime = new Time('now', 'Europe/Moscow', 'ru_RU');

class PostsModel extends Model
{
    protected $table = 'posts';
    protected $primaryKey = 'post_id';
    protected $allowedFields = ['post_title', 'post_slug', 'post_content', 'post_user_id', 'post_comments'];
      
    
    // Посты на главной странице сайта
    public function getPostHome()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('posts AS a');
        $builder->select('a.*, b.id, b.nickname, b.avatar');
        $builder->join("users AS b", "b.id = a.post_user_id");
        $builder->orderBy('a.post_id', 'DESC');

        $query = $builder->get();

        $result = Array();
        foreach($query->getResult()as $ind => $row){
             
            if(!$row->avatar ) {
                $row->avatar  = 'noavatar.png';
            } 

            $row->avatar = $row->avatar;
            $row->title = $row->post_title;
            $row->slug = $row->post_slug;
            $row->date = Time::parse($row->post_date, 'Europe/Moscow')->humanize();
            $result[$ind] = $row;
         
        }
    
        return $result;
           
    }
    
    // Полная версия поста  
    public function getPost($slug)
    {
        $Parsedown = new Parsedown(); 
        $Parsedown->setSafeMode(true); // безопасность
        
        $db = \Config\Database::connect();
        $builder = $db->table('posts AS a');
        $builder->select('a.*, b.id, b.nickname, b.avatar');
        $builder->join("users AS b", "b.id = a.post_user_id");
        $builder->where('a.post_slug', $slug);
        $builder->orderBy('a.post_id', 'DESC');
         
        $post = $builder->get()->getRow();

        if(!$post->avatar ) {
            $post->avatar  = 'noavatar.png';
        }
        
        $data = [
            'id'        => $post->post_id,
            'title'     => $post->post_title,
            'content'   => $Parsedown->text($post->post_content),
            'date'      => Time::parse($post->post_date, 'Europe/Moscow')->humanize(),
            'nickname'  => $post->nickname,
            'avatar'    => $post->avatar,
            'post_comm' => $post->post_comments,            
        ];
 
        return $data;

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

}
 