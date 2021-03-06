<?php
namespace App\Repository;
class CenterActivity
{
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
        
        return $years;
	}
}