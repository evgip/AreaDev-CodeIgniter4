<?php
namespace App\Models;

use CodeIgniter\Model;
use App\Libraries\Parsedown;
use App\Models\VotesCommentsModel;

use CodeIgniter\I18n\Time;
$myTime = new Time('now', 'Europe/Moscow', 'ru_RU');
 

class CommentsModel extends Model
{
    protected $table = 'comments';
    protected $primaryKey = 'comment_id'; 
    protected $allowedFields = ['comment_post_id', 'comment_on', 'comment_after', 'comment_content', 'comment_user_id', 'comment_votes', 'comment_ip'];
    
    // Все комментарии
    public function getCommentsAll()
    {
        
        $Parsedown = new Parsedown(); 
        $Parsedown->setSafeMode(true); // безопасность
        
        $db = \Config\Database::connect();
        $builder = $db->table('comments AS a');
        $builder->select('a.*, b.id, b.nickname, b.avatar, c.post_id, c.post_title, c.post_slug');
        $builder->join("users AS b", "b.id = a.comment_user_id");
        $builder->join("posts AS  c", "a.comment_post_id = c.post_id");
        $builder->orderBy('a.comment_id', 'DESC');

        $query = $builder->get();

        $result = Array();
        foreach($query->getResult()as $ind => $row){
             
            if(!$row->avatar ) {
                $row->avatar  = 'noavatar.png';
            } 

            $row->avatar = $row->avatar;
         
            $row->content = $Parsedown->text($row->comment_content);
            $row->date = Time::parse($row->comment_date, 'Europe/Moscow')->humanize();
            $result[$ind] = $row;
         
        }
    
        return $result;
           
    }
    
    // Получаем комментарии в посте
    public function getCommentsPost($post_id)
    {
        $Parsedown = new Parsedown(); 
        $Parsedown->setSafeMode(true); // безопасность
        
        $db = \Config\Database::connect();
        $builder = $db->table('comments AS a');
        
        $builder->select('a.*, b.id, b.nickname, b.avatar');
        $builder->join("users AS b", "b.id = a.comment_user_id");
        $builder->where('a.comment_post_id', $post_id);
        //$builder->orderBy('a.comment_id', 'DESC');
         
        $query = $builder->get();

        // Для комменатрия голосовал или нет
        // Переносим в запрос выше (избавляемся от N+1)
        $comm_vote_status = new VotesCommentsModel();
         
        $result = Array();
        foreach($query->getResult()as $ind => $row){
            
            if(!$row->avatar ) {
                $row->avatar  = 'noavatar.png';
            } 
 
            $row->comment_on = $row->comment_on;
            $row->avatar     = $row->avatar;
            $row->content    = $Parsedown->text($row->comment_content);
            $row->date       = Time::parse($row->comment_date, 'Europe/Moscow')->humanize();
            $row->after      = $row->comment_after;
            $row->del        = $row->comment_del;
            $row->comm_vote_status = $comm_vote_status->getVoteStatus($row->comment_id, session()->get('id'));
            $result[$ind]    = $row;
         
        }

        $result = $this->buildTree(0, 0, $result);
        
        return $result;
    
    }

    // Для дерева
     private function buildTree($comment_on , $level, $comments, $tree=array()){
        $level++;
        foreach($comments as $comment){
            if ($comment->comment_on ==$comment_on ){
                $comment->level = $level-1;
                $tree[] = $comment;
                $tree = $this->buildTree($comment->comment_id, $level, $comments, $tree);
            }
        }
		return $tree;
    }   
    
    // Комментарии участника
    public function getUsersComments($slug)
    {
        $Parsedown = new Parsedown(); 
        $Parsedown->setSafeMode(true); // безопасность
        
        $db = \Config\Database::connect();
        $builder = $db->table('comments AS a');
        $builder->select('a.*, b.id, b.nickname, b.avatar, c.post_id, c.post_title, c.post_slug');
        $builder->join("users AS b", "b.id = a.comment_user_id");
        $builder->join("posts AS  c", "a.comment_post_id = c.post_id");
        $builder->where('b.nickname', $slug);
        $builder->orderBy('a.comment_id', 'DESC');

        $query = $builder->get();

        $result = Array();
        foreach($query->getResult()as $ind => $row){
             
            if(!$row->avatar ) {
                $row->avatar  = 'noavatar.png';
            } 

            $row->avatar = $row->avatar;
         
            $row->content = $Parsedown->text($row->comment_content);
            $row->date = Time::parse($row->comment_date, 'Europe/Moscow')->humanize();
            $result[$ind] = $row;
         
        }
    
        return $result;
    } 
   
    // Комментарии участника на странице профиля
    public function getUsersCommentsNum($slug)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('comments AS a');
        $builder->select('a.*, b.id, b.nickname, b.avatar');
        $builder->join("users AS b", "b.id = a.comment_user_id");
        $builder->where('b.nickname', $slug);
        
        $result = $builder->countAllResults();

        return $result;
    }        
}