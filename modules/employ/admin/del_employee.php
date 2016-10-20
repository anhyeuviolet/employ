<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 2-10-2010 18:49
 */

if (! defined('NV_IS_FILE_ADMIN')) {
    die('Stop!!!');
}

$id = $nv_Request->get_int('id', 'post', 0);
$checkss = $nv_Request->get_string('checkss', 'post', '');
$listid = $nv_Request->get_string('listid', 'post', '');
$contents = 'NO_' . $id;

if ($listid != '' and NV_CHECK_SESSION == $checkss) {
    $del_array = array_map('intval', explode(',', $listid));
} elseif (md5($id . NV_CHECK_SESSION) == $checkss) {
    $del_array = array( $id );
}
if (! empty($del_array)) {
    $sql = 'SELECT id, listcatid, admin_id, title, alias, status FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows WHERE id IN (' . implode(',', $del_array) . ')';
    $result = $db->query($sql);
    $del_array = $no_del_array = array();
    $artitle = array();
    while (list($id, $listcatid, $admin_id, $title, $alias, $status) = $result->fetch(3)) {
        $check_permission = false;
        if (defined('NV_IS_MODADMIN')) {
            $check_permission = true;
        }
        if ($check_permission) {
            $contents = nv_del_content_module($id);
            $artitle[] = $title;
            $del_array[] = $id;
        } else {
            $no_del_array[] = $id;
        }
    }
    $count = sizeof($del_array);
    if ($count) {
        nv_insert_logs(NV_LANG_DATA, $module_name, $lang_module['permissions_del_content'], implode(', ', $artitle), $admin_info['userid']);
    }
    if (! empty($no_del_array)) {
        $contents = 'ERR_' . $lang_module['error_no_del_content_id'] . ': ' . implode(', ', $no_del_array);
    }
	nv_fix_rows_order();
}

include NV_ROOTDIR . '/includes/header.php';
echo $contents;
include NV_ROOTDIR . '/includes/footer.php';
