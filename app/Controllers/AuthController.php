<?php

// Мы используем подход: 
// * @package    SimpleAuth
// * @author     GeekLabs - Lee Skelding 
// * @license    https://opensource.org/licenses/MIT	MIT License
// * @link       https://github.com/GeekLabsUK/SimpleAuth

namespace App\Controllers;

use App\Models\Users;
use App\Models\AuthModel;
use App\Libraries\AuthLibrary;

class AuthController extends BaseController
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
		// Редирект
		return redirect()->to('login');
	}

    // Логин
	public function login()
	{
		
        if (session()->get('isLoggedIn'))
		{
			return redirect()->to('/');
		}
        
        // Установлен ли Cookie
		$this->Auth->checkCookie();
 
		// Если пост запрос то:
		if ($this->request->getMethod() == 'post') {

			// Установка правил
			$rules = [
				'email' => 'required|valid_email',
				'password' => 'required|min_length[8]|max_length[255]|validateUser[email,password]',
			];

			// Проверка правил
			$errors = [
				'password' => [
					'validateUser' => 'Email or Password do not match',
				]
			];

			if (!$this->validate($rules, $errors)) {

				$data['validation'] = $this->validator;

				$this->Auth->loginlogFail($this->request->getVar('email'));

			} else {				

				// Получить e-mail и запомнить меня
				$email = $this->request->getVar('email');
				$rememberMe = $this->request->getVar('rememberme');			

				// В библиотеку
				$this->Auth->Loginuser($email, $rememberMe);
             
				return redirect()->to($this->Auth->autoRedirect());
				
			}
		}

        $this->data['config'] = $this->config;
        
        $this->data['title'] = 'Вход';
        
		return $this->render('users/login');
	}

    // Регистрация
	public function register()
	{
        
        if (session()->get('isLoggedIn'))
		{
			return redirect()->to('profile');
		}
        
		// Если это пост запрос то:
		if ($this->request->getMethod() == 'post') {
  
			// Установить правила
			$rules = [
				'nickname' => 'required|alpha_numeric_space|min_length[3]|max_length[25]',
				'name' => 'required|min_length[3]|max_length[25]',
				'email' => 'required|valid_email|is_unique[users.email]',
				'password' => 'required|min_length[8]|max_length[255]',
				'password_confirm' => 'matches[password]',
			];

			// Проверка
			if (!$this->validate($rules)) {
				$data['validation'] = $this->validator;
			} else {

				// Набор пользовательских данных
				$userData = [
					'nickname' => $this->request->getVar('nickname'),
					'name' => $this->request->getVar('name'),
					'email' => $this->request->getVar('email'),
					'password' => $this->request->getVar('password'),					
				];				

				// В библиотеку
				$result = $this->Auth->RegisterUser($userData);	
				
				// Результат проверки
				if($result){

					return redirect()->to('/login');

				}
				
			}
		}
        
        $this->data['title'] = 'Регистрация';
        
		return $this->render('users/register');

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
        $userModel = new Users();
        $id = session()->get('id');
        $user = $userModel->getUsersId($id);
        
		// Если запрос то начинаем изменения, или показ шаблона
		if ($this->request->getMethod() == 'post') {
         
			// Настроим правила
			$rules = [
                'nickname' => 'required|alpha_numeric_space|min_length[3]|max_length[25]',
                'name'     => 'required|min_length[3]|max_length[25]',
                'email'    => 'required|valid_email',
			];
 
			// Установим доп. правила если пароль меняется
			if ($this->request->getPost('password') != '') {
				$rules['password'] = 'required|min_length[8]|max_length[255]';
				$rules['password_confirm'] = 'matches[password]';
			}
            if ($this->request->getPost('about') != '') {
                $rules['about']    = 'required|min_length[3]|max_length[255]';
            }
			// Проверка правил
			if (!$this->validate($rules)) {
				$data['validation'] = $this->validator;
			} else {

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
               
                // Для записи
                $user = [
                    'id'       => $this->Session->get('id'),
                    'nickname' => $this->request->getVar('nickname'),
                    'avatar'   => $data['avatar'],
                    'name'     => $this->request->getVar('name'),
                    'about'    => $this->request->getVar('about'),
                    'email'    => $this->request->getVar('email'),
                    'role'	   => $this->Session->get('role')
                ];
            
				// Если пароль остается пустым не меняем его
				if ($this->request->getPost('password') != '') {
					$user['password'] = $this->request->getVar('password');
				}
                
                // Если пароль остается пустым не меняем его
				if ($this->request->getPost('about') != '') {
					$user['about']    = $this->request->getVar('about');
				}

				// Зайдем в библиотеку
				$this->Auth->editProfile($user);

				return redirect()->to('setting');
			}
		}
        
        if(!$user['avatar']) {
            $user['avatar'] = 'noavatar.png';
        }  
        
        $this->data['title'] = 'Настройки';
        
		return $this->render('users/setting');

	}

    // forgot
	public function forgotPassword()
	{
		if ($this->request->getMethod() == 'post') {

			// Настройка правил
			$rules = [
				'email' => 'required|valid_email|validateExists[email]',
			];

			// Настройка ошибок
			$errors = [
				'email' => [
					'validateExists' => lang('Auth.noUser'),
				]
			];

			// Проверки
			if (!$this->validate($rules, $errors)) {
				$data['validation'] = $this->validator;
			}

			// Валидация
			else {			

				// Переход в билиотеку
				$this->Auth->ForgotPassword($this->request->getVar('email'));
				
			}
		}

        $this->data['title'] = 'Восстановление';
        
		return $this->render('users/forgotpassword');

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
		// Если это пост запрос, то:
		if ($this->request->getMethod() == 'post') {

			// Установить правила
			$rules = [
				'password' => 'required|min_length[8]|max_length[255]',
				'password_confirm' => 'matches[password]',
			];

			// Проверка правил
			if (!$this->validate($rules)) {
				$data['validation'] = $this->validator;
			} else {
				
				// Правила пряняты
				$user = [
					'id' => $id,
					'password' => $this->request->getVar('password'),
					'reset_expire' => NULL, // Сброс срока действия
					'reset_token' => NULL, // Очистить старый токен
				];

				// Переход в библиотеку
				$this->Auth->updatepassword($user);			

				return redirect()->to('/login');
			}
		}

		// Установить id пользователя для просмотра, т.к. нет данных для доступа
		$data = [
			'id' => $id,
		];
		
		echo view('users/resetpassword', $data);
	 
	}

	public function lockscreen()
	{
		$result = $this->Auth->lockScreen();

        if ($result) {
            if ($this->request->getMethod() == 'post') {

                // Правила
                $rules = [
                    'email' => 'required|valid_email',
                    'password' => 'required|min_length[8]|max_length[255]|validateUser[email,password]',
                ];

                // Проверка правил
                $errors = [
                    'password' => [
                        'validateUser' => 'Wrong Password',
                    ]
                ];

                if (!$this->validate($rules, $errors)) {
                    $data['validation'] = $this->validator;
                } else {

					// Получить email и запомнить
					$email = $this->request->getVar('email');
					$rememberMe = $this->request->getVar('rememberme');	

                    // Войти в систему с помощью e-mail
                    $this->Auth->Loginuser($email, $rememberMe);

					// Редирект
					return redirect()->to($this->Auth->autoRedirect());
                }
            }

        $this->data['title'] = 'lockscreen';
        
		return $this->render('users/lockscreen');

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
