<?php

/**
 * @Project NUKEVIET 4.x
 * @Author KennyNguyen (nguyentiendat713@gmail.com)
 * @Copyright (C) 2016 KennyNguyen .All rights reserved
 * @Website support https://www.nuke.vn
 * @License GNU/GPL version 2 or any later version
 * @Createdate Thu, 22 Sep 2016 13:09:49 GMT
 */

if ( ! defined( 'NV_IS_MOD_SEARCH' ) ) die( 'Stop!!!' );

$db->sqlreset()
	->select( 'COUNT(*)' )
	->from( NV_PREFIXLANG . '_' . $m_values['module_data'] . '_rows')
	->where('(' . nv_like_logic( 'title', $dbkeyword, $logic ) . ' OR ' . nv_like_logic( 'about_family', $dbkeyword, $logic ) . ') OR ' . nv_like_logic( 'about_wish', $dbkeyword, $logic ) . '	AND status= 1' );

$num_items = $db->query( $db->sql() )->fetchColumn();
if ( $num_items )
{
    $array_cat_alias = array();
    $array_cat_alias[0] = 'other';

    $sql_cat = 'SELECT catid, alias FROM ' . NV_PREFIXLANG . '_' . $m_values['module_data'] . '_cat';
    $re_cat = $db_slave->query($sql_cat);
    while (list($catid, $alias) = $re_cat->fetch(3)) {
        $array_cat_alias[$catid] = $alias;
    }
    $link = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $m_values['module_name'] . '&amp;' . NV_OP_VARIABLE . '=';

	$db->select( 'id, title, alias, catid, about_family, about_wish' )
        ->order('addtime DESC')
		->limit( $limit )
        ->offset(($page - 1) * $limit);		
	$result = $db->query( $db->sql() );
    while (list($id, $tilterow, $alias, $catid, $about_family, $about_wish) = $result->fetch(3)) {
        $content = $about_family . strip_tags($about_wish);
        $url = $link . $array_cat_alias[$catid] . '/' . $alias . $global_config['rewrite_exturl'];
        $result_array[] = array(
            'link' => $url,
            'title' => BoldKeywordInStr($tilterow, $key, $logic),
            'content' => BoldKeywordInStr($content, $key, $logic)
        );
    }
}