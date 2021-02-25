<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Models\User;
/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */

class BaseController extends Controller
{
	/**
	 * Instance of the main Request object.
	 *
	 * @var IncomingRequest|CLIRequest
	 */
	protected $request;
    protected $data = [];

	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */
	protected $helpers = ['form', 'text', 'cookie'];

	/**
	 * Constructor.
	 *
	 * @param RequestInterface  $request
	 * @param ResponseInterface $response
	 * @param LoggerInterface   $logger
	 */
	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);

		//--------------------------------------------------------------------
		// Preload any models, Libraries, etc, here.
		//--------------------------------------------------------------------
		// E.g.: $this->session = \Config\Services::session();
	}
    
    // Расширяем, для работы с шаблоном
    public function render($views, $template = 'layout')
	{ 
        // временно, 3 переменные которые нужны нам
        if (session()->get('isLoggedIn')) {
            
            $data = $this->inUser();
            $this->data['usr_id']    = $data['id'];
            $this->data['usr_color'] = $data['color'];
            $this->data['usr_role']  = $data['role'];
            
        } else {
           
            $this->data['usr_id']    = 0;       
            $this->data['usr_color'] = 0;
            $this->data['usr_role'] = 0;             
        }
        
        $this->data['uri']     = service('uri')->getSegment(1); 
        $this->data['content'] = view($views, $this->data);

		return view($template, $this->data);

	}    
    
    // Возратим данный участника
    public function inUser()
	{
        $userModel = new User();
        $user_id   = session()->get('id');
        $data      = $userModel->find($user_id);

        if (!$data) { return true; }

        return $data;
    }
}
