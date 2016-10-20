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

$location_id = $nv_Request->get_int('location_id', 'post', 0);

$contents = "NO_" . $location_id;
$location_id = $db->query("SELECT location_id FROM " . NV_PREFIXLANG . "_" . $module_data . "_location WHERE location_id=" . intval($location_id))->fetchColumn();
if ($location_id > 0) {
    nv_insert_logs(NV_LANG_DATA, $module_name, 'log_del_location', "sd " . $location_id, $admin_info['userid']);
    $query = "DELETE FROM " . NV_PREFIXLANG . "_" . $module_data . "_location WHERE location_id=" . $location_id;
    if ($db->exec($query)) {
        $query = "DELETE FROM " . NV_PREFIXLANG . "_" . $module_data . "_location_id WHERE location_id=" . $location_id;
        $db->query($query);
        nv_fix_location();
        $nv_Cache->delMod($module_name);
        $contents = "OK_" . $location_id;
    }
}

include NV_ROOTDIR . '/includes/header.php';
echo $contents;
include NV_ROOTDIR . '/includes/footer.php';
