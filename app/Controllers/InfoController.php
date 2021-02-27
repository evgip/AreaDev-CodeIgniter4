<?php

namespace App\Controllers;

class InfoController extends BaseController
{
	public function index()
	{
        
        $this->data['title'] = 'Информация';
        
        return $this->render('info/index');
        
	}
    
    public function stats()
	{
        
        $this->data['title'] = 'Статистика';
        
        return $this->render('info/stats');
        
	}
    
	public function rules()
	{
       
        $this->data['title'] = 'Правила';
        
        return $this->render('info/rules');
        
	} 
    
    
	public function about()
	{
       
        $this->data['title'] = 'О нас';
        
        return $this->render('info/about');
        
	}
    
    public function privacy()
	{
       
        $this->data['title'] = 'Политика конфиденциальности';
        
        return $this->render('info/privacy');
        
	}
    
}
