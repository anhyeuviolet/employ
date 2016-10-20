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
$mod = $nv_Request->get_string('mod', 'post', '');
$new_vid = $nv_Request->get_int('new_vid', 'post', 0);
$content = 'NO_' . $id;

list($id) = $db->query('SELECT id FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows WHERE id=' . $id)->fetch(3);
if ($id > 0) {
    if ($mod == 'sort' and $new_vid > 0) {
        $sql = 'SELECT id FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows WHERE id!=' . $id . ' ORDER BY sort ASC';
        $result = $db->query($sql);

        $sort = 0;
        while ($row = $result->fetch()) {
            ++$sort;
            if ($sort == $new_vid) {
                ++$sort;
            }
            $sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_rows SET sort=' . $sort . ' WHERE id=' . $row['id'];
            $db->query($sql);
        }

        $sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_rows SET sort=' . $new_vid . ' WHERE id=' . $id ;
        $db->query($sql);

        nv_fix_rows_order();
        $content = 'OK_' . $id;
    } elseif (defined('NV_IS_MODADMIN')) {
        if ($mod == 'inhome' and ($new_vid == 0 or $new_vid == 1)) {
            $sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_rows SET inhome=' . $new_vid . ' WHERE id=' . $id ;
            $db->query($sql);
            $content = 'OK_' . $id;
        } elseif ($mod == 'status' and ($new_vid == 0 or $new_vid == 1)) {
            $sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_rows SET status=' . $new_vid . ' WHERE id=' . $id ;
            $db->query($sql);
            $content = 'OK_' . $id;
        } elseif ($mod == 'job_status' and ($new_vid == 0 or $new_vid == 1)) {
            $sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_rows SET job_status=' . $new_vid . ' WHERE id=' . $id ;
            $db->query($sql);
            $content = 'OK_' . $id;
        }
    }
    $nv_Cache->delMod($module_name);
}

include NV_ROOTDIR . '/includes/header.php';
echo $content;
include NV_ROOTDIR . '/includes/footer.php';