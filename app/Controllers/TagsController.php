<?php

namespace App\Controllers;

use App\Models\TagsModel;

class TagsController extends BaseController
{

    // Все теги сайта
    public function index()
    {
        $model = new TagsModel();

            $this->data = [
                'tags'  => $model->getTagsHome(),
                'title' => 'Теги сайта',
            ];

        return $this->render('tags/all');
    }

    // Посты по тегу
    public function tagPosts()
    {
        $model = new TagsModel();
        $slug = service('uri')->getSegment(2);

        $posts = $model->getTagsPosts($slug);

        // Покажем 404
        if(!$posts) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $this->data = [
            'posts'  => $posts,
            'title'  => 'Посты по тегу',
        ];

        return $this->render('tags/tagposts');
    }

    // Все теги сайта
    public function tagForma()
    {
        $model = new TagsModel();

        $data = [
            'tags'  => $model->getTagsHome(),
        ];

        return view('tags/formtag', $data);
    }

}
