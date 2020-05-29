<?php
namespace App\Support;

class PageSupport
{
	public static function getPageArrayStructure($route, $pageCount, $currentPage, $linkParam)
	{
		$page = array();
		for($i=1; $i<=$pageCount; $i++) {
            if($i <= $currentPage+5 && $i > $currentPage-5) {
                $active = $currentPage==$i ? 'active' : '';
                array_push($page, array(
                    'link'=>$route.'?'.
                    		$linkParam.
                            '&page='.$i,
                    'count'=>$i,
                    'active'=>$active
                    ));
            }
            else if($i == $currentPage+6 || $i == $currentPage-6) {
                array_push($page, array(
                    'link'=>$route.'?'.
                    		$linkParam.
                            '&page='.$i,
                    'count'=>'...',
                    'active'=>''
                    ));
            }
        }

        return $page;
	}
}