<?php

namespace App\Models\Model;

use Illuminate\Database\Eloquent\Model;
use Auth;
use \App\Repository\User as User;

class Menu extends Model
{
    public static function setMenuList($sel = '') {
    	$menu = array(
    		array('link'=>'/Calendar', 'word'=>'首頁', 'sel'=>'active', 'sub'=>array()),
    		array('link'=>'/Temple', 'word'=>'佛堂', 'sel'=>'', 'sub'=>array()),
    		array('link'=>'/Personnel', 'word'=>'人事', 'sel'=>'', 'sub'=>array()),
    		// array('link'=>'/Agenda', 'word'=>'法會', 'sel'=>'', 'sub'=>array()),
    		// array('link'=>'/Activity', 'word'=>'班程', 'sel'=>'', 'sub'=>array(
      //           array('link'=>'/CenterActivity', 'word'=>'中心班程'),
    		// 	array('link'=>'/Activity', 'word'=>'當班紀錄'),
    		// 	)),
    		array('link'=>'/BookBorrow', 'word'=>'書籍', 'sel'=>'', 'sub'=>array(
                // array('link'=>'/BookBorrow', 'word'=>'圖書借閱'),
                //array('link'=>'/BookSubscription', 'word'=>'新書訂閱'),
                //array('link'=>'/BookReceive', 'word'=>'書籍請領'),
                )),
    		);
        
        // if(User::UserTypeValidator('MenuClasmanag', Auth::user()->type))
        //     array_push($menu[4]['sub'], array('link'=>'/Clsmanag', 'word'=>'課程維護'));   
        
    	foreach($menu as &$item) {
    		if(('/'.$sel) == $item['link'])
    			$item['sel'] = 'active';
    		else
    			$item['sel'] = '';
    	}
    	unset($item);

    	return $menu;
    }
}
