<?php

namespace App\Models;

use CodeIgniter\Model;

class PostsModel extends Model
{
    protected $table = 'posts';
 
    protected $allowedFields = ['post_title', 'post_slug', 'post_content', 'post_user_id'];

    public function getPost($slug = false)
    {
        if ($slug === false)
        {
            return $this->findAll();
        }

        return $this->asArray()
                    ->where(['post_slug' => $slug])
                    ->first();
    }

}
 