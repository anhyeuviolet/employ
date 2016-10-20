<?php

/**
 * @Project NUKEVIET 4.x
 * @Author KennyNguyen (nguyentiendat713@gmail.com)
 * @Copyright (C) 2016 KennyNguyen .All rights reserved
 * @Website support https://www.nuke.vn
 * @License GNU/GPL version 2 or any later version
 * @Createdate Thu, 22 Sep 2016 13:09:49 GMT
 */

if (! defined('NV_IS_FILE_ADMIN')) {
    die('Stop!!!');
}

$location_id = $nv_Request->get_int('location_id', 'post', 0);
$mod = $nv_Request->get_string('mod', 'post', '');
$new_vid = $nv_Request->get_int('new_vid', 'post', 0);
$content = 'NO_' . $location_id;

list($location_id) = $db->query('SELECT location_id FROM ' . NV_PREFIXLANG . '_' . $module_data . '_location WHERE location_id=' . $location_id)->fetch(3);
if ($location_id > 0) {
        if ($mod == 'status' and ($new_vid == 0 or $new_vid == 1)) {
            $sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_location SET status=' . $new_vid . ' WHERE location_id=' . $location_id ;
            $db->query($sql);
            $content = 'OK_' . $location_id;
        }
    }
    $nv_Cache->delMod($module_name);

include NV_ROOTDIR . '/includes/header.php';
echo $content;
include NV_ROOTDIR . '/includes/footer.php';