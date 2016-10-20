<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 2-9-2010 14:43
 */

if( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );


$page_title = $lang_module['request'];

$xtpl = new XTemplate( 'request.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file );
$xtpl->assign( 'LANG', $lang_module );
$xtpl->assign( 'GLANG', $lang_global );
$request_id = $nv_Request->get_int( 'request_id', 'get', 0 );
$page = $nv_Request->get_int( 'page', 'get', 1 );
$per_page = 20;
$base_url = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op;

if ( $request_id > 0)
{
	$sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_request WHERE id=' . $request_id;
	$result = $db->query( $sql );			
	$single = $result->fetch( );
	
	$single['cus_request'] = nv_unhtmlspecialchars($single['cus_request']);
	$single['create_time'] = nv_date("H:i d/m/Y", $single['create_time']);

	$xtpl->assign( 'ROW', $single );
	$xtpl->parse( 'single' );
	$contents = $xtpl->text( 'single' );
}
else
{
	$num = $db->query( 'SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_request' )->fetchColumn();
	if( $num > 0 )
	{
		$ae = 0;
		$sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_request ORDER BY create_time DESC LIMIT ' . ( $page - 1 ) * $per_page . ',' . $per_page ;

		$result = $db->query( $sql );
		while( $data = $result->fetch( ) )
		{
			$data['create_time'] = nv_date("H:i d/m/Y", $data['create_time']);
			$data['link'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op . '&request_id=' . $data['id'];
			++$ae;
			$data['num'] = $ae;
			$data['checkss'] = md5( $data['id'] . session_id() . $global_config['sitekey'] );
			$data['delete'] = "<em class=\"fa fa-trash-o fa-lg\">&nbsp;</em> <a href=\"javascript:void(0);\" onclick=\"nv_del_request(" . $data['id'] . ", '" . $data['checkss'] . "')\">" . $lang_global['delete'] . "</a>";
			$xtpl->assign( 'ROW', $data );
			$xtpl->parse( 'list.data.row' );
		}
		
		$generate_page = nv_generate_page( $base_url, $num, $per_page, $page );
		if( ! empty( $generate_page ) )
		{
			$xtpl->assign( 'GENERATE_PAGE', $generate_page );
			$xtpl->parse( 'list.data.generate_page' );
		}
		$xtpl->parse( 'list.data' );
	}
	else
	{
		$xtpl->parse( 'list.empty' );
	}
	
	$xtpl->parse( 'list' );
	$contents = $xtpl->text( 'list' );
}

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme( $contents );
include NV_ROOTDIR . '/includes/footer.php';