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
        
        // Кто голосовал
        $user_id = session()->get('id');

        // Информация об комментарии
        $model = new VotesCommentsModel();
        $post_info = $model->infoComm($comm_id);

        // Вы не можете голосовать за свой ответ
        if ($user_id == $post_info->comment_user_id) {
           // return false;
        }
         
       $request = \Config\Services::request();

       $model->save([
            'votes_comm_item_id' => $comm_id,
            'votes_comm_points'  => 1,
            'votes_comm_ip'      => $request->getIPAddress(),
            'votes_comm_user_id' => $user_id,
            'votes_comm_date'    => date("Y-m-d H:i:s"),
        ]);
       
        // Получаем количество votes комментария    
        $votes_num = $post_info->comment_votes;

        $votes_data = [
                'comment_votes' => $votes_num + 1,
        ];
  
        // Записываем новое значение Votes в строку комментария по id
        $comm_model = new CommentsModel();
        $comm_model->update($comm_id, $votes_data); 
      
        return false;
    }
}