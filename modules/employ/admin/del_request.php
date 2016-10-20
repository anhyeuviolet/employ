<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 2-10-2010 18:49
 */

if( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

$rid = $nv_Request->get_int( 'id', 'post', 0 );
$checkss = $nv_Request->get_string( 'checkss', 'post' );

$contents = "NO_" . $rid;
$id = $db->query( "SELECT id FROM " . NV_PREFIXLANG . "_" . $module_data . "_request WHERE id=" . intval( $rid ) )->fetchColumn();
if( $id > 0 and $checkss == md5( $id . session_id() . $global_config['sitekey'] ) )
{
	nv_insert_logs( NV_LANG_DATA, $module_name, 'log_del_request', "id " . $id, $admin_info['userid'] );
	$query = "DELETE FROM " . NV_PREFIXLANG . "_" . $module_data . "_request WHERE id=" . $id;
	if( $db->exec( $query ) )
	{
		$nv_Cache->delMod( $module_name );
		$contents = "OK_" . $id;
	}
}

if( defined( 'NV_IS_AJAX' ) )
{
	include NV_ROOTDIR . '/includes/header.php';
	echo $contents;
	include NV_ROOTDIR . '/includes/footer.php';
}
else
{
	Header( 'Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=request' );
	die();
}