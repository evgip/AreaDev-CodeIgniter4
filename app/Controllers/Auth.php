<?php

// Мы используем подход: 
// * @package    SimpleAuth
// * @author     GeekLabs - Lee Skelding 
// * @license    https://opensource.org/licenses/MIT	MIT License
// * @link       https://github.com/GeekLabsUK/SimpleAuth

namespace App\Controllers;

use App\Models\User;
use App\Models\AuthModel;
use App\Libraries\AuthLibrary;

class Auth extends BaseController
{
	public function __construct()
	{
		$this->AuthModel =	new AuthModel();
		$this->Session = session();		
		$this->Auth = new AuthLibrary(); 
		$this->config = config('Auth');
	}

	public function index()
	{
		// DIRECT TO LOGIN FORM
		return redirect()->to('login');
	}

    // Логин
	public function login()
	{
		
        if (session()->get('isLoggedIn'))
		{
			return redirect()->to('profile');
		}
        
 
        // CHECK IF COOKIE IS SET
		$this->Auth->checkCookie();
 
		// IF ITS A POST REQUEST DO YOUR STUFF ELSE SHOW VIEW
		if ($this->request->getMethod() == 'post') {

			//SET RULES
			$rules = [
				'email' => 'required|valid_email',
				'password' => 'required|min_length[8]|max_length[255]|validateUser[email,password]',
			];

			//VALIDATE RULES
			$errors = [
				'password' => [
					'validateUser' => 'Email or Password do not match',
				]
			];

			if (!$this->validate($rules, $errors)) {

				$data['validation'] = $this->validator;

				$this->Auth->loginlogFail($this->request->getVar('email'));

			} else {				

				// GET EMAIL & REMEMBER ME FROM POST
				$email = $this->request->getVar('email');
				$rememberMe = $this->request->getVar('rememberme');			

				// PASS TO LIBRARY
				$this->Auth->Loginuser($email, $rememberMe);

				return redirect()->to($this->Auth->autoRedirect());
				
			}
		}

        $this->data['config'] = $this->config;
        
        $this->data['title'] = 'Вход';
        
		return $this->render('user/login');
	}

    // Регистрация
	public function register()
	{
        
        if (session()->get('isLoggedIn'))
		{
			return redirect()->to('profile');
		}
        
		// IF ITS A POST REQUEST DO YOUR STUFF ELSE SHOW VIEW
		if ($this->request->getMethod() == 'post') {
  
			// SET RULES
			$rules = [
				'nickname' => 'required|min_length[3]|max_length[25]',
				'name' => 'required|min_length[3]|max_length[25]',
				'email' => 'required|valid_email|is_unique[users.email]',
				'password' => 'required|min_length[8]|max_length[255]',
				'password_confirm' => 'matches[password]',
			];

			//VALIDATE RULES
			if (!$this->validate($rules)) {
				$data['validation'] = $this->validator;
			} else {

				// SET USER DATA
				$userData = [
					'nickname' => $this->request->getVar('nickname'),
					'name' => $this->request->getVar('name'),
					'email' => $this->request->getVar('email'),
					'password' => $this->request->getVar('password'),					
				];				

				// PASS TO LIBRARY
				$result = $this->Auth->RegisterUser($userData);	
				
				// CHECK RESULT
				if($result){

					return redirect()->to('/login');

				}
				
			}
		}
        
        $this->data['title'] = 'Регистрация';
        
		return $this->render('user/register');

	}

    // Активируем
	public function resendactivation($id)
	{

		$this->Auth->ResendActivation($id);		

		return redirect()->to('/login');		

	}


	// Активируем аккаунт
	public function activateUser($id, $token)
	{
	
		$this->Auth->activateuser($id, $token);		

		return redirect()->to('/');
	}

	// Настройки профиля
	public function setting()
	{
 
		// Если запрос то начинаем изменения, или показ шаблона
		if ($this->request->getMethod() == 'post') {
         
			// Настроим правила
			$rules = [
				//'nickname' => 'required|min_length[3]|max_length[25]',
				'name' => 'required|min_length[3]|max_length[25]',
				'email' => 'required|valid_email',
			];

			// Установим доп. правила если пароль меняется
			if ($this->request->getPost('password') != '') {
				$rules['password'] = 'required|min_length[8]|max_length[255]';
				$rules['password_confirm'] = 'matches[password]';
			}

			// Проверка правил
			if (!$this->validate($rules)) {
				$data['validation'] = $this->validator;
			} else {

				// Для записи исключить ник
				$user = [
					'id' => $this->Session->get('id'),
					// 'nickname' => $this->request->getVar('nickname'),
					'name' => $this->request->getVar('name'),
					'email' => $this->request->getVar('email'),
					'role'	=> $this->Session->get('role')
				];
                
                $userModel = new User();

                // Записываем фото
                $image = $this->request->getFile('image');
                if ($image && $image->isValid() && ! $image->hasMoved())
                {
                    $ext = $image->getRandomName();
                    $avatar = $user['id'].'.'.$ext;
               
                    $p = $image->move(FCPATH.'upload/users/', $avatar);
                    
                    // Формируем превью
                    $userModel->image_avatar($avatar);
               
                    $data = [
                        'avatar' => $avatar
                    ];
         
                    // Добавляем в базу
                    $userModel->update($user['id'], $data);
                    
                } 

				// Если пароль остается пустым не меняем его
				if ($this->request->getPost('password') != '') {
					$user['password'] = $this->request->getVar('password');
				}

				// Зайдем в библиотеку
				$this->Auth->editProfile($user);

				return redirect()->to('setting');
			}
		}
		
        $this->data['title'] = 'Настройки';
        
		return $this->render('user/setting');

	}

    // Поменяем цвет страницы
    public function color($color)
    {
        // Если мы не вошли в систему. Насколько спасает маршрут и права там?
        if (!session()->get('isLoggedIn'))
		{
			return true;
		}
        
        $userModel = new User();
        $color = $this->request->getPost('color');

        $id = session()->get('id'); 
      
        $data = [
            'color' => $color
        ];
         
        $userModel->update($id, $data);
     
    }
    
    // forgot
	public function forgotPassword()
	{
		if ($this->request->getMethod() == 'post') {

			// SET UP RULES
			$rules = [
				'email' => 'required|valid_email|validateExists[email]',
			];

			// SET UP ERRORS
			$errors = [
				'email' => [
					'validateExists' => lang('Auth.noUser'),
				]
			];

			// CHECK VALIDATION
			if (!$this->validate($rules, $errors)) {

				$data['validation'] = $this->validator;
			}

			// VALIDATED
			else {			

				// PASS TO LIBRARY
				$this->Auth->ForgotPassword($this->request->getVar('email'));
				
			}
		}

        $this->data['title'] = 'Восстановление';
        
		return $this->render('user/forgotpassword');

	}

	// Восстановления пароля
	public function resetPassword($id, $token)
	{

		$id = $this->Auth->resetPassword($id, $token);
		
		$this->updatepassword($id);
		
	}

    // Изменяем пароль
	public function updatepassword($id)
	{
		// IF ITS A POST REQUEST DO YOUR STUFF ELSE SHOW VIEW
		if ($this->request->getMethod() == 'post') {

			//SET RULES
			$rules = [
				'password' => 'required|min_length[8]|max_length[255]',
				'password_confirm' => 'matches[password]',
			];

			// VALIDATE RULES
			if (!$this->validate($rules)) {
				$data['validation'] = $this->validator;
			} else {
				
				// RULES PASSED
				$user = [
					'id' => $id,
					'password' => $this->request->getVar('password'),
					'reset_expire' => NULL, // RESET EXPIRY 
					'reset_token' => NULL, // CLEAR OLD TOKEN 
				];

				// PASS TO LIBRARY
				$this->Auth->updatepassword($user);			

				return redirect()->to('/login');
			}
		}

		// SET USER ID TO PASS TO VIEW AS THERE IS NO SESSION DATA TO ACCESS
		$data = [
			'id' => $id,
		];
		
		echo view('header');
		echo view('user/resetpassword', $data);
		echo view('footer');
	}

	public function lockscreen()
	{
		$result = $this->Auth->lockScreen();

        if ($result) {
            if ($this->request->getMethod() == 'post') {

            //SET RULES
                $rules = [
                'email' => 'required|valid_email',
                'password' => 'required|min_length[8]|max_length[255]|validateUser[email,password]',
            ];

                //VALIDATE RULES
                $errors = [
                'password' => [
                    'validateUser' => 'Wrong Password',
                ]
            ];

                if (!$this->validate($rules, $errors)) {
                    $data['validation'] = $this->validator;
                } else {

					// GET EMAIL & REMEMBER ME FROM POST
					$email = $this->request->getVar('email');
					$rememberMe = $this->request->getVar('rememberme');	

                    // LOG USER IN USING EMAIL
                    $this->Auth->Loginuser($email, $rememberMe);

					// REDIRECT 
					return redirect()->to($this->Auth->autoRedirect());
                }
            }

        $this->data['title'] = 'lockscreen';
        
		return $this->render('user/lockscreen');

		}
		else {
            return redirect()->to('/');
        }
	}

	// Выход
	public function logout()
	{
		$this->Auth->logout();

		return redirect()->to('/');
	}

	
}
