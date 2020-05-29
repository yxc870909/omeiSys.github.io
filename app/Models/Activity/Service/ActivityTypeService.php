<?php
namespace App\Models\Activity\Service;

use \App\Models\Activity\Repository\ActivityTypeRepository as ActivityTypeRepository;
use Auth;
use DB;
use View;
use Redirect;

class ActivityTypeService
{
    public static function getData($filter, $page, $limit)
    {
        $data = ActivityTypeRepository::getData($filter, $page, $limit);
        $data = json_decode(json_encode($data), true);

        return $data;
    }

	public static function getActivityType($request)
	{
		$tabs = ActivityTypeRepository::getAll();
		$tabs = json_decode(json_encode($tabs), true);

        if(isset($request['tab']) && $request['tab'])
            $tab = $request['tab'];
        else if(count($tabs) > 0)
            $tab = $tabs[0]['title'];
        else
            $tab = '';

        $tmp = array();
        foreach($tabs as $item) {
            array_push($tmp, array(
                'id'=>$item['id'],
                'title'=>$item['title'],
                'active'=>$tab==$item['title'] ? 'active' : ''
                ));
        }
        $tabs = $tmp;

        return $tabs;
	}

	public static function getAll()
	{
		$data = ActivityTypeRepository::getAll();
		$data = json_decode(json_encode($data), true);

		return $data;
	}
}