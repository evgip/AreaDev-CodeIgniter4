<?php namespace App\Controllers;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;

// https://www.positronx.io/codeigniter-select2-ajax-autocomplete-search-from-database/
// https://makitweb.com/autocomplete-textbox-in-codeigniter-4-with-jquery-ui/
// https://select2.org/placeholders
class AutocompleteTags extends Controller
{

    public function index() {
        return view('home');
    }
    
    public function ajaxSearch()
    {
        helper(['form', 'url']);

        $data = [];

        $db      = \Config\Database::connect();
        $builder = $db->table('tags');   

        $query = $builder->like('tags_name', $this->request->getVar('q'))
                    ->select('tags_id, tags_name')
                    ->limit(10)->get();
                
        $data = $query->getResult();
        
		echo json_encode($data);

    }

}