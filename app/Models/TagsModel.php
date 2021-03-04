<?php

namespace App\Models;

use CodeIgniter\Model;

use CodeIgniter\I18n\Time;
$myTime = new Time('now', 'Europe/Moscow', 'ru_RU');

class TagsModel extends Model
{
    protected $table = 'tags';
    protected $primaryKey = 'tags_id';
    protected $allowedFields = ['tags_name', 'tags_description', 'tags_tip', 'tags_slug'];
      
    // Все теги сайта
    public function getTagsHome()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tags');
        $builder->select('*');
        $builder->orderBy('tags_id', 'DESC');

        $query = $builder->get();

        $result = Array();
        foreach($query->getResult()as $ind => $row){

            $row->name        = $row->tags_name;
            $row->slug        = $row->tags_slug;
            $row->description = $row->tags_description;
            $row->tip         = $row->tags_tip;
            $result[$ind]          = $row;
         
        }
    
        return $result;
 
    }
    
    // Все теги сайта
    public function getTagsPost($post_id)
    {
       
        $db = \Config\Database::connect();
        $builder = $db->table('tags AS a');
        $builder->select('a.*, b.taggings_tag_id, b.taggings_post_id');
        $builder->join("taggings AS b", "b.taggings_tag_id = a.tags_id");
        $builder->where('b.taggings_post_id', $post_id); 
        $result = $builder->get()->getResult();
         
        return $result;
           
    }  
    
    // Списки постов по тегу
    public function getTagsPosts($slug)
    {
     
        $db = \Config\Database::connect();
        $builder = $db->table('tags AS a');
        $builder->select('a.*, b.taggings_tag_id, b.taggings_post_id, c.*, d.id, d.nickname, d.avatar');
        $builder->join("taggings AS b", "b.taggings_tag_id = a.tags_id");
        $builder->join("posts AS c", "c.post_id = b.taggings_post_id");
        $builder->join("users AS d", "d.id = c.post_user_id");
        $builder->where('a.tags_slug', $slug); 
        $query = $builder->get(); 
        
        $result = Array();
        foreach($query->getResult()as $ind => $row){
             
            if(!$row->avatar ) {
                $row->avatar  = 'noavatar.png';
            } 
            $row->avatar = $row->avatar;
            $row->date = Time::parse($row->post_date, 'Europe/Moscow')->humanize();
            $result[$ind] = $row;
         
        }
    
        return $result;
           
    }
    
    
    // Добавление тега после добавление поста
    public function TagsAddPosts($tag_id, $post_id)
    {
     
        $db = \Config\Database::connect();
        
        /*  https://www.codeigniter.com/user_guide/database/query_builder.html?highlight=active%20record#inserting-data
            $data = [
                [
                        'taggings_tag_id'   => $tag_id,
                        'taggings_post_id ' => $post_id
                ],
                [
                        'taggings_tag_id'   => $tag_id,
                        'taggings_post_id ' => $post_id
                ],
            ];

            $builder->insertBatch($data);
        */
        
        $data = [
            'taggings_tag_id'   => $tag_id,
            'taggings_post_id ' => $post_id
        ];

        $db->table('taggings')->insert($data);
    
        return false;
           
    }
    
    
}
 