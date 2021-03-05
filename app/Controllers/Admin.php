<?php

namespace App\Controllers;

class Admin extends BaseController
{
	public function index()
	{

			$this->data['title'] = 'Админка';

		return $this->render('dmin/index');

	}

}
