<?php

namespace App\Controllers;
use App\Models\Users;


class AdminController extends BaseController
{
	public function index()
	{
        $model_user =  new Users();
        $this->data['all_users'] = $model_user->getUsersAll();
        
		$this->data['title'] = 'Админка';

		return $this->render('admin/index');

	}

}
