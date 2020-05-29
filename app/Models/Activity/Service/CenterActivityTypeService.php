<?php
namespace App\Models\Activity\Service;

use \App\Models\Activity\Repository\CenterActivityTypeRepository as CenterActivityTypeRepository;
use Auth;
use DB;
use View;
use Redirect;

class CenterActivityTypeService
{
	public static function getData($filter, $page, $limit)
    {
        $data = CenterActivityTypeRepository::getData($filter, $page, $limit);
        $data = json_decode(json_encode($data), true);

        return $data;
    }
    
	public static function getAll()
	{
		$data = CenterActivityTypeRepository::getAll();
		$data = json_decode(json_encode($data), true);

		return $data;
	}
}