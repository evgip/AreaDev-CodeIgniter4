<?php

namespace App\Libraries;

class Translit
{
    public static function SeoUrl($str, $is_cyr = false){

        $str    = str_replace(' ', '-', mb_strtolower(trim($str)));
        $string = rtrim(preg_replace ('/[^a-zA-Zа-яёА-ЯЁ0-9\-]/iu', '-', $str), '-');

        while(mb_strstr($string, '--')){ $string = str_replace('--', '-', $string); }

		if(!$is_cyr){
			$ru_en = array(
							'а'=>'a','б'=>'b','в'=>'v','г'=>'g','д'=>'d',
							'е'=>'e','ё'=>'yo','ж'=>'zh','з'=>'z',
							'и'=>'i','й'=>'i','к'=>'k','л'=>'l','м'=>'m',
							'н'=>'n','о'=>'o','п'=>'p','р'=>'r','с'=>'s',
							'т'=>'t','у'=>'u','ф'=>'f','х'=>'h','ц'=>'c',
							'ч'=>'ch','ш'=>'sh','щ'=>'sch','ъ'=>'','ы'=>'y',
							'ь'=>'','э'=>'ye','ю'=>'yu','я'=>'ja'
						  );

			foreach($ru_en as $ru=>$en){
				$string = preg_replace('/(['.$ru.']+?)/iu', $en, $string);
			}
		}

        if (!$string){ $string = 'untitled'; }
        if (is_numeric($string)){ $string .= 'untitled'; }
        
        // Длина URL адреса
        $length = 45;
        if(!$length){
            return $string;
        } else {
            return mb_substr($string, 0, $length);
        }

	}
}