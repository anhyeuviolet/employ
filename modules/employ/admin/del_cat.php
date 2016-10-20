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

$catid = $nv_Request->get_int('catid', 'post', 0);
$contents = 'NO_' . $catid;

list ($catid, $parentid, $title) = $db->query('SELECT catid, parentid, title FROM ' . NV_PREFIXLANG . '_' . $module_data . '_cat WHERE catid=' . $catid)->fetch(3);
if ($catid > 0) {
    if ((defined('NV_IS_MODADMIN'))) {
		$check_rows = $db->query('SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows WHERE catid=' . $catid)->fetchColumn();
		nv_insert_logs(NV_LANG_DATA, $module_name, $lang_module['delcatandrows'], $title, $admin_info['userid']);
		
		$sql = $db->query('SELECT id, catid, listcatid FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows WHERE catid=' . $catid);
		while ($row = $sql->fetch()) {
			if ($row['catid'] == $row['listcatid']) {
				nv_del_content_module($row['id']);
			} else {
				$arr_catid_old = explode(',', $row['listcatid']);
				$arr_catid_i = array(
					$catid
				);
				$arr_catid_news = array_diff($arr_catid_old, $arr_catid_i);
				if ($catid == $row['catid']) {
					$row['catid'] = $arr_catid_news[0];
				}
				$db->query("UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_rows SET catid=" . $row['catid'] . ", listcatid = '" . implode(',', $arr_catid_news) . "' WHERE id =" . $row['id']);
			}
		}
		$db->query('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_cat WHERE catid=' . $catid);
		
		nv_fix_cat_order();
		$contents = 'OK_' . $parentid;
		$nv_Cache->delMod($module_name);
    } else {
        $contents = 'ERR_CAT_' . $lang_module['delcat_msg_cat_permissions'];
    }
}

if (defined('NV_IS_AJAX')) {
    include NV_ROOTDIR . '/includes/header.php';
    echo $contents;
    include NV_ROOTDIR . '/includes/footer.php';
} else {
    Header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=job');
    die();
}