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
if (! defined('NV_IS_AJAX')) {
    die('Wrong URL');
}

$sid = $nv_Request->get_int('sid', 'post', 0);
$mod = $nv_Request->get_string('mod', 'post', '');
$new_vid = $nv_Request->get_int('new_vid', 'post', 0);

if (empty($sid)) {
    die('NO_' . $sid);
}
$content = 'NO_' . $sid;

if ($mod == 'weight' and $new_vid > 0) {
    $sql = 'SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_salary_cat WHERE sid=' . $sid;
    $numrows = $db->query($sql)->fetchColumn();
    if ($numrows != 1) {
        die('NO_' . $sid);
    }
    
    $sql = 'SELECT sid FROM ' . NV_PREFIXLANG . '_' . $module_data . '_salary_cat WHERE sid!=' . $sid . ' ORDER BY weight ASC';
    $result = $db->query($sql);
    
    $weight = 0;
    while ($row = $result->fetch()) {
        ++ $weight;
        if ($weight == $new_vid) {
            ++ $weight;
        }
        $sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_salary_cat SET weight=' . $weight . ' WHERE sid=' . $row['sid'];
        $db->query($sql);
    }
    
    $sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_salary_cat SET weight=' . $new_vid . ' WHERE sid=' . $sid;
    $db->query($sql);
    
    $content = 'OK_' . $sid;
}

$nv_Cache->delMod($module_name);

include NV_ROOTDIR . '/includes/header.php';
echo $content;
include NV_ROOTDIR . '/includes/footer.php';