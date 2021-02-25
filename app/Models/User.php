<?php

namespace App\Models;

use CodeIgniter\Model;

class User extends Model { 

    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['id', 'color', 'avatar'];
    
    public function image_avatar($avatar)
    {
        \Config\Services::image()
            ->withFile(FCPATH. 'upload/users/' . $avatar)
            ->resize(60, 60, false, 'height')
            ->save(FCPATH. 'upload/users/small/' . $avatar);
            
            
            \Config\Services::image()
            ->withFile(FCPATH. 'upload/users/' . $avatar)
            ->resize(160, 160, false, 'height')
            ->save(FCPATH. 'upload/users/' . $avatar);
    }

}     
   