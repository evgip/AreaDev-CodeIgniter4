<?php

namespace App\Models;

use CodeIgniter\Model;

class Users extends Model { 

    protected $table = 'users';
        
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['id', 'color', 'avatar', 'name'];    
        
        
    public function getUsersLogin($slug = false)
    {
        if ($slug === false)
            return $this->findAll();
        else
            return $this->asArray()->where(['nickname' => $slug])->first();
    }
    
    public function getUsersId($id = false)
    {
        if ($id === false)
            return $this->findAll();
        else
            return $this->asArray()->where(['id' => $id])->first();
    }
 
 
    public function getUsersAll()
    {
        return $this->findAll();
    }
    
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
   