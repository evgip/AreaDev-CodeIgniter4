<?php

namespace App\Controllers;

use App\Models\PostsModel;
use App\Models\TagsModel;
use App\Models\CommentsModel;
use App\Models\VotesCommentsModel;
use CodeIgniter\Controller;
use App\Libraries\Parsedown;

use CodeIgniter\I18n\Time;
$myTime = new Time('now', 'Europe/Moscow', 'ru_RU');

class PostsController extends BaseController
{

    public function index()
    {
        
        $model_tags = new TagsModel(); 
        $model_post = new PostsModel();
        
        $posts = $model_post->getPostHome();
 
        $result = Array();
        foreach($posts as $ind => $row){
             
            if(!$row->avatar ) {
                $row->avatar  = 'noavatar.png';
            } 
 
            $row->tags    = $model_tags->getTagsPost($row->post_id);
            $row->avatar  = $row->avatar;
            $row->title   = $row->post_title;
            $row->slug    = $row->post_slug;
            $row->date    = Time::parse($row->post_date, 'Europe/Moscow')->humanize();
            $result[$ind] = $row;
         
        }
        // Показываем количество комментариев
        //$userCommNum = new CommentsModel();
   
        $this->data['posts'] = $result;
        $this->data['title'] = 'Посты';
        
        return $this->render('home');
    }
    
    // Полный пост
    public function view($slug = NULL)
    {

        $Parsedown = new Parsedown(); 
        $Parsedown->setSafeMode(true); // безопасность
        
        $model_post = new PostsModel();
        $model_comm = new CommentsModel();
        $model_tags = new TagsModel(); 

        // Получим пост
        $post = $model_post->getPost($slug);
        
        if (empty($post))
        {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Не удается найти пост: '. $slug);
        }
        
        if(!$post->avatar ) {
            $post->avatar  = 'noavatar.png';
        }
        
        $data = [
            'id'        => $post->post_id,
            'title'     => $post->post_title,
            'content'   => $Parsedown->text($post->post_content),
            'date'      => Time::parse($post->post_date, 'Europe/Moscow')->humanize(),
            'nickname'  => $post->nickname,
            'avatar'    => $post->avatar,
            'post_comm' => $post->post_comments,  
            'tags'      => $model_tags->getTagsPost($post->post_id),            
        ];
        
        $this->data['posts'] = $data;
        
        // Получим комментарии
        $comm = $model_comm->getCommentsPost($this->data['posts']['id']);
        
        // Для комменатрия голосовал или нет
        // Переносим в запрос выше (избавляемся от N+1)
        $comm_vote_status = new VotesCommentsModel();
         
        $result = Array();
        foreach($comm as $ind => $row){
            
            if(!$row->avatar ) {
                $row->avatar  = 'noavatar.png';
            } 
 
            $row->comment_on = $row->comment_on;
            $row->avatar     = $row->avatar;
            $row->content    = $Parsedown->text($row->comment_content);
            $row->date       = Time::parse($row->comment_date, 'Europe/Moscow')->humanize();
            $row->after      = $row->comment_after;
            $row->del        = $row->comment_is_delete;
            $row->comm_vote_status = $comm_vote_status->getVoteStatus($row->comment_id, session()->get('id'));
            $result[$ind]    = $row;
         
        }

        $this->data['comments'] = $this->buildTree(0, 0, $result);
        
        $this->data['title'] = $this->data['posts']['title'];

        return $this->render('posts/view');
        
    } 
    
    // Добавление поста
    public function create()
    {

        // Авторизировались или нет
        if (!session()->get('isLoggedIn'))
		{
			return redirect()->to('/');
		}  
        
        $model_post = new PostsModel();

        $this->data['title'] = 'Добавление поста';
 
        if ($this->request->getMethod() === 'post' && $this->validate([
                'post_title' => 'required|min_length[3]|max_length[255]',
                'post_content'  => 'required',
                'tag'  => 'required',
            ]))
        {
            // Получаем title
            $post_title = $this->request->getPost('post_title');
            
            // Получаем id тега
            $tag_id = $this->request->getPost('tag');
           
            $model_post->save([
                'post_title'    => $this->request->getPost('post_title'),
                'post_slug'     => $model_post->seoSlug($post_title),
                'post_ip_int'   => $this->request->getIPAddress(), 
                'post_content'  => $this->request->getPost('post_content'),
                'post_user_id'  => session()->get('id'),
            ]);
             
            // Получаем id добавленного поста 
            $post_id = $model_post->PostId();
            
            // Добавляем теги
            $model_tag =  new TagsModel();
            $model_tag->TagsAddPosts($tag_id, $post_id);
        
            return redirect()->to('/');

        }
        else
        {
            return $this->render('posts/add');
        }
    }
    
    // Изменить поста
    public function edit()
    {

        // Авторизировались или нет
        if (!session()->get('isLoggedIn'))
		{
			return redirect()->to('/');
		}  
        
        $model_post = new PostsModel();

        $this->data['title'] = 'Изменение поста';
 
        if ($this->request->getMethod() === 'post' && $this->validate([
                'post_title' => 'required|min_length[3]|max_length[255]',
                'post_content'  => 'required',
                'tag'  => 'required',
            ]))
        {
            
            // Получаем id добавленного поста 
            $post_id = service('uri')->getSegment(3);
            
            // Получим пост
            $post = $model_post->getPostId($post_id);
            
            // Редактировать может только автор
            if ($post->post_user_id != session()->get('id')) {
                return redirect()->to('/');
            }

            // Получаем id тега
            $tag_id = [];
            $tag_id = $this->request->getPost('tag');
           
            $edit_data = [
                'post_title'    => $this->request->getPost('post_title'),
                'post_slug'     => $post->post_slug,
                'post_content'  => $this->request->getPost('post_content'),
                'post_date'     => $post->post_date,
                'edit_date'     =>  date( 'Y-m-d H:i:s'),
            ];
             
            $model_post->update($post_id, $edit_data);
            
            // Добавляем теги
            // $model_tags =  new TagsModel();
            // $model_tags->TagsAddPosts($tag_id, $post_id);
        
            return redirect()->to('/');

        }
        else
        {
            
            // получаем id поста    
            $post_id = service('uri')->getSegment(3);   
                
            // Получим пост
            $post = $model_post->getPostId($post_id);
     
            // Редактировать может только автор
            if ($post->post_user_id != session()->get('id')) {
                 return redirect()->to('/');
            }
     
            $model_tags =  new TagsModel();
     
            $data = [
                'id'        => $post->post_id,
                'title'     => $post->post_title,
                'content'   => $post->post_content,
                'tag'       => $model_tags->getTagsPost($post->post_id),
            ];
            
            $this->data['post'] = $data;   
            
            return $this->render('posts/edit');
            
        }
        
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
    
    // Посты участника
     public function userPosts()
    {
        
        $model_tags = new TagsModel(); 
        $model_post = new PostsModel();
        
        $slug  = service('uri')->getSegment(2);
        
        $posts  = $model_post->getUsersPosts($slug); 
        
        // Покажем 404
        if(!$posts) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        
        $result = Array();
        foreach($posts as $ind => $row){
             
            if(!$row->avatar ) {
                $row->avatar  = 'noavatar.png';
            } 
 
            $row->tags    = $model_tags->getTagsPost($row->post_id);
            $row->avatar  = $row->avatar;
            $row->title   = $row->post_title;
            $row->slug    = $row->post_slug;
            $row->date    = Time::parse($row->post_date, 'Europe/Moscow')->humanize();
            $result[$ind] = $row;
         
        }
 
        $this->data['yes_uri'] = 1; 
        $this->data['uri_post'] = service('uri')->getSegment(2);        
         
        // Показываем количество комментариев
        //$userCommNum = new CommentsModel();
        $this->data['posts']   = $result;
        
        $this->data['title']   = 'Посты   ' . $slug;
        return $this->render('posts/postsuser');
    }
    
    // post_is_delete 0/1
    public function delete($id)
    {

    }
    
}