<?php

namespace App\Controllers;

use App\Models\VotesCommentsModel;
use App\Models\CommentsModel;
// use App\Models\PostsModel; пока не надо, но понадобится для общей кармы поста

class VotesCommController extends BaseController
{

   // Голосование за комментарий
    public function votes($comm_id)
    {

        // Проверяем
        if (!$comm_id)
        {
            return false;
        }

        // Авторизировались или нет
        if (!session()->get('isLoggedIn'))
        {
            return false;
        }  
        
        // id того, кто госует за комментарий
        $user_id = session()->get('id');

        // Информация об комментарии
        $model = new VotesCommentsModel();
        $comm_info = $model->infoComm($comm_id);
        
        // Польщователь не должен голосовать за свой комментарий
        if ($user_id == $comm_info->comment_user_id) {
           return false;
        }    
                      
        //Проверяем, голосовал ли пользователь за комментарий
        $up = $model->getVoteStatus($comm_info->comment_id, $user_id);   
        
        if($up == 1) {
            
            // далее удаление строки в таблице голосования за комментарии
            // $db      = \Config\Database::connect();
            // $builder = $db->table('votes_comm');
            // $builder->where('votes_comm_item_id', $comm_info->comment_id);
            // $builder->where('votes_comm_user_id', $user_id);
            // $builder->delete();
            // далее уменьшаем на -1 количество комментариев в самом комментарии
            // см. код ниже. А пока:
            
            return false;
            
        } else {
         
           $request = \Config\Services::request();

           $model->save([
                'votes_comm_item_id' => $comm_id,
                'votes_comm_points'  => 1,
                'votes_comm_ip'      => $request->getIPAddress(),
                'votes_comm_user_id' => $user_id,
                'votes_comm_date'    => date("Y-m-d H:i:s"),
            ]);
           
            // Получаем количество votes комментария    
            $votes_num = $comm_info->comment_votes;

            $votes_data = [
                 'comment_votes' => $votes_num + 1,
            ];
      
            // Записываем новое значение Votes в строку комментария по id
            $comm_model = new CommentsModel();
            $comm_model->update($comm_id, $votes_data); 
          
             $data = array();

             // Read new token and assign in $data['token']
             $data['token'] = csrf_hash();
          
            return false;
        } 
    }
}