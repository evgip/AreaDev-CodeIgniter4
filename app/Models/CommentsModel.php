<?php
namespace App\Models;

use CodeIgniter\Model;

class CommentsModel extends Model
{
    protected $table = 'comments';
    protected $primaryKey = 'comment_id'; 
    protected $allowedFields = ['comment_post_id', 'comment_on', 'comment_after', 'comment_content', 'comment_user_id', 'comment_votes', 'comment_ip'];
    
    // Все комментарии
    public function getCommentsAll($num)
    {
       
        return $this
                ->table('comments')
                ->select('comments.*, b.id, b.nickname, b.avatar, c.post_id, c.post_title, c.post_slug')
                ->join('users AS b', 'b.id = comments.comment_user_id')
                ->join('posts AS  c', 'comments.comment_post_id = c.post_id')
                ->orderBy('comments.comment_id', 'DESC')
                ->paginate($num);
 
    }
    
    // Получаем комментарии в посте
    public function getCommentsPost($post_id)
    {
        
        $db = \Config\Database::connect();
        $builder = $db->table('comments AS a');
        $builder->select('a.*, b.id, b.nickname, b.avatar');
        $builder->join("users AS b", "b.id = a.comment_user_id");
        $builder->where('a.comment_post_id', $post_id);
        
        // Далее передадим параметр и используем в сотрировки
        // $builder->orderBy('a.comment_id', 'DESC');
         
        $result = $builder->get()->getResult();

        return $result;
    
    }

    // Страница комментариев участника
    public function getUsersComments($slug)
    {
        
        $db = \Config\Database::connect();
        $builder = $db->table('comments AS a');
        $builder->select('a.*, b.id, b.nickname, b.avatar, c.post_id, c.post_title, c.post_slug');
        $builder->join("users AS b", "b.id = a.comment_user_id");
        $builder->join("posts AS  c", "a.comment_post_id = c.post_id");
        $builder->where('b.nickname', $slug);
        $builder->orderBy('a.comment_id', 'DESC');

        $result = $builder->get()->getResult();

        return $result;
    } 
   
    // Количество комментариев на странице профиля
    public function getUsersCommentsNum($slug)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('comments AS a');
        $builder->select('a.*, b.id, b.nickname, b.avatar');
        $builder->join("users AS b", "b.id = a.comment_user_id");
        $builder->where('b.id', $slug);
        
        $result = $builder->countAllResults();

        return $result;
    }        
}