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

$aid = $nv_Request->get_int('aid', 'post', 0);

$contents = "NO_" . $aid;
$aid = $db->query("SELECT aid FROM " . NV_PREFIXLANG . "_" . $module_data . "_age_cat WHERE aid=" . intval($aid))->fetchColumn();
if ($aid > 0) {
    nv_insert_logs(NV_LANG_DATA, $module_name, 'log_del_agecat', "sd " . $aid, $admin_info['userid']);
    $query = "DELETE FROM " . NV_PREFIXLANG . "_" . $module_data . "_age_cat WHERE aid=" . $aid;
    if ($db->exec($query)) {
        $query = "DELETE FROM " . NV_PREFIXLANG . "_" . $module_data . "_age WHERE aid=" . $aid;
        $db->query($query);
        nv_fix_age_cat();
        $nv_Cache->delMod($module_name);
        $contents = "OK_" . $aid;
    }
}

include NV_ROOTDIR . '/includes/header.php';
echo $contents;
include NV_ROOTDIR . '/includes/footer.php';
