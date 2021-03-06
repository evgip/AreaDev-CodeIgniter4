<?php

namespace App\Controllers;

use App\Libraries\Parsedown;
use App\Models\CommentsModel;
use App\Models\PostsModel;

use CodeIgniter\I18n\Time;
$myTime = new Time('now', 'Europe/Moscow', 'ru_RU');

class CommentsController extends BaseController
{

    public function index()
    {
        
        $Parsedown = new Parsedown(); 
        $Parsedown->setSafeMode(true); // безопасность
        
        $model = new CommentsModel();
        
        $pager = \Config\Services::pager();
       
        // Добавим пагинацию
        $comm =  $model->getCommentsAll(20);
 
        $result = Array();
        foreach($comm  as $ind => $row){
             
            if(!$row['avatar']) {
                $row['avatar'] = 'noavatar.png';
            } 

            $row['avatar'] = $row['avatar'];
         
            $row['content'] = $Parsedown->text($row['comment_content']);
            $row['date'] = Time::parse($row['comment_date'], 'Europe/Moscow')->humanize();
            $result[$ind] = $row;
         
        }
    
        $this->data = [
            'comments' => $result,
            'pager' => $model->pager
        ];
    
        // Просто тестирование функции вызова
        // set_message('Действие выполнено успешно!');
        
        $this->data['title'] = 'Комментарии';
        return $this->render('comments/all');
    }

    // get single product
    public function show($id = null)
    {
        $model = new CommentsModel();
        $data = $model->getWhere(['id' => $id])->getResult();
        if ($data) {
            return $this->respond($data);
        } else {
            return $this->failNotFound('No Data Found with id ' . $id);
        }
    }

    // create a product
    public function create()
    {
        // Авторизировались или нет
        if (!session()->get('isLoggedIn'))
		{
			return redirect()->to($_SERVER['HTTP_REFERER']);
		}
        
        $model = new CommentsModel();

        // $data = json_decode(file_get_contents("php://input"));
        
        // Проверим на длину
        if ($this->request->getMethod() === 'post' && $this->validate([
                'comment' => 'required|min_length[3]|max_length[2000]'
            ]))
        {
            
            $data = [
                'comment_post_id' => $this->request->getPost('post_id'),
                'comment_ip'      => $this->request->getIPAddress(),
                'comment_on'      => $this->request->getPost('comm_id'),
                'comment_content' => $this->request->getPost('comment'),
                'comment_user_id' => session()->get('id'),
            ];
            
     
            // записываем покммент
            $result = $model->insert($data);
            
            // Получаем id поста
            $post_id = $this->request->getPost('post_id');   
            
            // Есть следом или нет (для сложного поведения в шаблоне, т.к. данных на что 
            // этот комментрий недостаточно. Важно знать есть, что-то далее, чтобы избежать js)
            $after_data = [
                'comment_after' => 1,
            ];
            $model->update($data['comment_on'], $after_data);
            
            // Пересчитываем количество комментариев для поста + 1
            $post_model = new PostsModel();
            $num = $post_model->getNumComments($post_id); // + 1
            $num_data['post_comments'] = $num;
            $post_model->update($post_id, $num_data);


            if($result){
                return redirect()->to($_SERVER['HTTP_REFERER']);
            } 

        }
        else
        {
           return redirect()->to($_SERVER['HTTP_REFERER']); 
        }

    }

    // Вызовем форму ответа
    public function addform($id)
	{
        
        // Получаем id поста
        $post_id = $this->request->getPost('post_id'); 
        
        $data = [
        'comm_id' => $id,
        'post_id' => $post_id,
        'auth' => session()->get('isLoggedIn'),
        ]; 
        
      return view('comments/addform', $data);
    }


    public function userComments()
    {
        
        $Parsedown = new Parsedown(); 
        $Parsedown->setSafeMode(true); // безопасность
        
        $slug  = service('uri')->getSegment(2);
        $model = new CommentsModel();
        $comm  = $model->getUsersComments($slug); 
        
        // Покажем 404
        if(!$comm) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        
        $result = Array();
        foreach($comm as $ind => $row){
             
            if(!$row->avatar ) {
                $row->avatar  = 'noavatar.png';
            } 

            $row->avatar = $row->avatar;
         
            $row->content = $Parsedown->text($row->comment_content);
            $row->date = Time::parse($row->comment_date, 'Europe/Moscow')->humanize();
            $result[$ind] = $row;
         
        }
        
        $this->data['comments'] = $result;
        
        $this->data['title'] = 'Комментарии ' . $slug;
        return $this->render('comments/commuser');
    }

    //  comment_is_delete 0/1 
    public function delete($id)
    {

    }
}