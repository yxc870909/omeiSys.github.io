<?php
namespace App\Support;

class Comment
{
	public static function is_json($string)
	{
		return ((is_string($string) &&
            (is_object(json_decode($string)) ||
            is_array(json_decode($string))))) ? true : false;
	}

    public static function JsonToArray($data, $field)
    {
        foreach($data as &$item) {
            foreach($field as $f) {
                $item[$f] = json_decode($item[$f],true);
            }            
        }
        unset($item);

        return $data;
    }

    public static function getYear_DDL($data, $request)
    {
        $years['word'] = '';
        $years['data'] = array();
        $ary = array();
        if(count($data) > 0) {
            foreach($data as $item)
                $ary[] = date('Y', strtotime($item['add_date']));
            $ary = array_unique($ary);

            foreach($ary as $item) {
                array_push($years['data'], array(
                    'word'=>$item.'年',
                    'value'=>$item,
                    'active'=>''
                ));             
            }
            
            foreach($years['data'] as &$item) {
                if(isset($item['value'])) {
                    if($item['value'] == $request) {
                        $item['active'] = 'active';
                        $years['word'] = $item['value'].'年';
                    }    
                }
                
            }
            unset($item);
            if($years['word'] == '') {
                $years['word'] = $years['data'][0]['word'];
                $years['data'][0]['active'] = 'active';
            }
        }
        else {
            $years['word'] = date('Y').'年';
            array_push($years['data'], array(
                'word'=>date('Y').'年',
                'value'=>date('Y'),
                'active'=>'active'
            ));
        }
        
        return $years;
    }

    public static function getrank($len) {
        $alphabet = 'abcdefghijklmnopqrstuvwxyz';
        $numeral = '0123456789';
        $code = $alphabet.$numeral;
        $activation_code = '';
        for ($i = 0; $i < $len; $i++) {
            $activation_code .= $code[mt_rand(0, strlen($code) - 1)];
        }

        return $activation_code;
    }
}