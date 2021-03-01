<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\CommentsModel;
use App\Models\PostsModel;

class CommentsController extends BaseController
{
    use ResponseTrait;
    // get all product
    public function index()
    {

        $model = new CommentsModel();
        $this->data['comments'] = $model->getCommentsAll();
          
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
        $model = new CommentsModel();

        //$data = json_decode(file_get_contents("php://input"));
        
        // Проверим на длину
        if ($this->request->getMethod() === 'post' && $this->validate([
                'comment' => 'required|min_length[3]|max_length[255]'
            ]))
        {
            
            $data = [
                'comment_post_id' => $this->request->getPost('post_id'),
                'comment_content' => $this->request->getPost('comment'),
                'comment_user_id' => session()->get('id'),
            ];
            
            $result = $model->insert($data);
            
            // Получаем id поста
            $post_id = $this->request->getPost('post_id');
            
            // Пересчитываем количество комментариев для поста + 1
            $post_model = new PostsModel();
            $num = $post_model->getNumComments($post_id);

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

    // update product
    public function update2($id = null)
    {
        $model = new CommentsModel();
        $json = $this->request->getJSON();
        if ($json) {
            $data = [
                'article_id' => $json->article_id,
                'comment' => $json->comment,
                'user_id' => $json->user_id,
            ];
        } else {
            $input = $this->request->getRawInput();
            $data = [
                'article_id' => $input['article_id'],
                'comment' => $input['comment'],
                'user_id' => $input['user_id'],
            ];
        }
        // Insert to Database
        $model->update($id, $data);
        $response = [
            'status' => 200,
            'error' => null,
            'messages' => [
                'success' => 'Data Updated'
            ]
        ];
        return $this->respond($response);
    }

    // delete product
    public function delete($id = null)
    {
        $model = new CommentsModel();
        $data = $model->find($id);
        if ($data) {
            $model->delete($id);
            $response = [
                'status' => 200,
                'error' => null,
                'messages' => [
                    'success' => 'Data Deleted'
                ]
            ];

            return $this->respondDeleted($response);
        } else {
            return $this->failNotFound('No Data Found with id ' . $id);
        }
    }
}