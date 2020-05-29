<?php
namespace App\Models\Agenda\Service;

use \App\Models\Agenda\Repository\AgendaRepository as AgendaRepository;
use \App\Models\Category\Service\CategoryService as CategoryService;

class AgendaService
{
	public static function getPageCount($filter = 1, $type = '', $val = '')
	{
		$pageCount = AgendaRepository::getPageCount($filter, $type, $val)/15;
		//無條件進位
        return ceil($pageCount);
	}

	public static function getDataByMember($filter, $val, $page, $limt)
	{
		$data = AgendaRepository::getDataByMember($filter, $val, $page, $limt);
		$data = json_decode(json_encode($data), true);

		if(count($data) > 0) {
            $hash = CategoryService::getHashTable(array('area','cls_type'));

            foreach($data as &$item) {
                $item['area'] = $hash['area'][$item['area']]['word'];
                $item['type'] = $hash['cls_type'][$item['type']]['word'];
                $item['add_date'] = date_format(date_create($item['add_date']), 'Y-m-d');
            }
            unset($item);
        }

		return $data;
	}

	public static function getAgendaData($filter, $page, $limt)
	{
		$data = AgendaRepository::getAgendaData($filter, $page, $limt);
		$data = json_decode(json_encode($data), true);

		if(count($data) > 0) {
            $hash = CategoryService::getHashTable(array('area','cls_type'));

            foreach($data as &$item) {
                $item['area'] = $hash['area'][$item['area']]['word'];
                $item['type'] = $hash['cls_type'][$item['type']]['word'];
                $item['add_date'] = date_format(date_create($item['add_date']), 'Y-m-d');
            }
            unset($item);
        }

		return $data;
	}
}