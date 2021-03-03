<?php

namespace App\Models;
use CodeIgniter\Model;
use App\Models\CommentsModel;

class VotesCommentsModel extends Model
{
    protected $table = 'votes_comm';
    protected $primaryKey = 'votes_comm_id'; 
    protected $allowedFields = ['votes_comm_item_id', 'votes_comm_points', 'votes_comm_ip', 'votes_comm_user_id', 'votes_comm_date'];
    

    // Информация по комментарию по его id
     public function infoComm($comm_id) {

         $db      = \Config\Database::connect();
         $builder = $db->table('comments');
         $builder->select('*');
         $builder->where('comment_id', $comm_id);
         
         $info = $builder->get()->getRow();
 
 		 return $info;
    }

    // Проверяем, голосовал ли пользователь за комментарий
    public function getVoteStatus($comm_id, $uid)
	{
         $db      = \Config\Database::connect();
         $builder = $db->table('votes_comm');
         $builder->select('*');
         $builder->where('votes_comm_item_id', $comm_id); // votes_comm_user_id
         $builder->where('votes_comm_user_id', $uid); 
         $info = $builder->get()->getRow();

         if($info) {
             return $result = 1;
         } else {
         	return false;
         }

	}
}