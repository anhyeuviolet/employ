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
$page_title = $lang_module['salary'];

$error = '';
$savecat = 0;
list ($location_id, $title, $alias, $type) = array(
    0,
    '',
    '',
    ''
);

$savecat = $nv_Request->get_int('savecat', 'post', 0);
if (! empty($savecat)) {
    $location_id = $nv_Request->get_int('location_id', 'post', 0);
    $title = $nv_Request->get_title('title', 'post', '', 1);
    $alias = $nv_Request->get_title('alias', 'post', '');
    $alias = ($alias == '') ? change_alias($title) : change_alias($alias);
    $type = $nv_Request->get_title('type', 'post', 0);
	
    if (empty($title)) {
        $error = $lang_module['error_name'];
    }
	elseif ($location_id == 0) {
        $weight = $db->query("SELECT max(weight) FROM " . NV_PREFIXLANG . "_" . $module_data . "_location")->fetchColumn();
        $weight = intval($weight) + 1;
        
        $sql = "INSERT INTO " . NV_PREFIXLANG . "_" . $module_data . "_location (title, alias, weight, status, type) VALUES (:title , :alias, :weight, 1, :type)";
        $data_insert = array();
        $data_insert['title'] = $title;
        $data_insert['alias'] = $alias;
        $data_insert['weight'] = $weight;
        $data_insert['type'] = $type;
        
        if ($db->insert_id($sql, 'location_id', $data_insert)) {
            nv_insert_logs(NV_LANG_DATA, $module_name, 'log_add_location', " ", $admin_info['userid']);
            Header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
            die();
        } else {
            $error = $lang_module['errorsave'];
        }
    } else {
        $stmt = $db->prepare("UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_location SET title= :title, alias = :alias, type= :type WHERE location_id =" . $location_id);
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':alias', $alias, PDO::PARAM_STR);
        $stmt->bindParam(':type', $type, PDO::PARAM_STR);
        $stmt->execute();
        if ($stmt->execute()) {
            nv_insert_logs(NV_LANG_DATA, $module_name, 'log_edit_blockcat', "location_id " . $location_id, $admin_info['userid']);
            Header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
            die();
        } else {
            $error = $lang_module['errorsave'];
        }
    }
	$nv_Cache->delMod($module_name);
}

$location_id = $nv_Request->get_int('location_id', 'get', 0);
if ($location_id > 0) {
    list ($location_id, $title, $alias, $type) = $db->query("SELECT location_id, title, alias, type FROM " . NV_PREFIXLANG . "_" . $module_data . "_location where location_id=" . $location_id)->fetch(3);
    $lang_module['add_location'] = $lang_module['edit_location'];
}

$lang_global['title_suggest_max'] = sprintf($lang_global['length_suggest_max'], 65);
$lang_global['description_suggest_max'] = sprintf($lang_global['length_suggest_max'], 160);

$xtpl = new XTemplate('location.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('GLANG', $lang_global);
$xtpl->assign('NV_BASE_ADMINURL', NV_BASE_ADMINURL);
$xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('OP', $op);

$xtpl->assign('LOCATION_LIST', nv_show_location_list());

$xtpl->assign('location_id', $location_id);
$xtpl->assign('title', $title);
$xtpl->assign('alias', $alias);
$xtpl->assign('type', $type);

if (! empty($error)) {
    $xtpl->assign('ERROR', $error);
    $xtpl->parse('main.error');
}

if (empty($alias)) {
    $xtpl->parse('main.getalias');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
