<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Libraries\Parsedown; 
 
use CodeIgniter\I18n\Time;
$myTime = new Time('now', 'Europe/Moscow', 'ru_RU');

class PostsModel extends Model
{
    protected $table = 'posts';
    protected $allowedFields = ['post_title', 'post_slug', 'post_content', 'post_user_id'];
    
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
            'title'    => $post->post_title,
            'content'  => $Parsedown->text($post->post_content),
            'date'     => Time::parse($post->post_date, 'Europe/Moscow')->humanize(),
            'nickname' => $post->nickname,
            'avatar'   => $post->avatar            
        ];
 
        return $data;


    }

}
 