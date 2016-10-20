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

$sid = $nv_Request->get_int('sid', 'post', 0);

$contents = "NO_" . $sid;
$sid = $db->query("SELECT sid FROM " . NV_PREFIXLANG . "_" . $module_data . "_salary_cat WHERE sid=" . intval($sid))->fetchColumn();
if ($sid > 0) {
    nv_insert_logs(NV_LANG_DATA, $module_name, 'log_del_salarycat', "sid " . $sid, $admin_info['userid']);
    $query = "DELETE FROM " . NV_PREFIXLANG . "_" . $module_data . "_salary_cat WHERE sid=" . $sid;
    if ($db->exec($query)) {
        $query = "DELETE FROM " . NV_PREFIXLANG . "_" . $module_data . "_salary WHERE sid=" . $sid;
        $db->query($query);
        nv_fix_salary_cat();
        $nv_Cache->delMod($module_name);
        $contents = "OK_" . $sid;
    }
}

include NV_ROOTDIR . '/includes/header.php';
echo $contents;
include NV_ROOTDIR . '/includes/footer.php';
