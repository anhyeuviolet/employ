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
$page_title = $lang_module['age'];

$error = '';
$savecat = 0;
list ($aid, $title, $alias, $description, $from_age, $to_age) = array(
    0,
    '',
    '',
    '',
    0,
    0
);

$savecat = $nv_Request->get_int('savecat', 'post', 0);
if (! empty($savecat)) {
    $aid = $nv_Request->get_int('aid', 'post', 0);
    $title = $nv_Request->get_title('title', 'post', '', 1);
    $alias = $nv_Request->get_title('alias', 'post', '');
    $description = $nv_Request->get_string('description', 'post', '');
    $description = nv_nl2br(nv_htmlspecialchars(strip_tags($description)), '<br />');
    $alias = ($alias == '') ? change_alias($title) : change_alias($alias);
    $from_age = $nv_Request->get_int('from_age', 'post', 0);
    $to_age = $nv_Request->get_int('to_age', 'post', 0);
	
    if (empty($title)) {
        $error = $lang_module['error_name'];
    } elseif ($aid == 0) {
        $weight = $db->query("SELECT max(weight) FROM " . NV_PREFIXLANG . "_" . $module_data . "_age_cat")->fetchColumn();
        $weight = intval($weight) + 1;
        
        $sql = "INSERT INTO " . NV_PREFIXLANG . "_" . $module_data . "_age_cat (adddefault, title, alias, description, weight, from_age, to_age, add_time, edit_time) VALUES (0, :title , :alias, :description, :weight, :from_age, :to_age, " . NV_CURRENTTIME . ", " . NV_CURRENTTIME . ")";
        $data_insert = array();
        $data_insert['title'] = $title;
        $data_insert['alias'] = $alias;
        $data_insert['description'] = $description;
        $data_insert['weight'] = $weight;
        $data_insert['from_age'] = intval($from_age);
        $data_insert['to_age'] = intval($to_age);
        
        if ($db->insert_id($sql, 'aid', $data_insert)) {
            nv_insert_logs(NV_LANG_DATA, $module_name, 'log_add_agecat', " ", $admin_info['userid']);
            Header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
            die();
        } else {
            $error = $lang_module['errorsave'];
        }
    } else {
        $stmt = $db->prepare("UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_age_cat SET title= :title, alias = :alias, description= :description, from_age = " . intval($from_age) . ", to_age = " . intval($to_age) . ", edit_time=" . NV_CURRENTTIME . " WHERE aid =" . $aid);
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':alias', $alias, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->execute();
        if ($stmt->execute()) {
            nv_insert_logs(NV_LANG_DATA, $module_name, 'log_edit_blockcat', "age_id " . $aid, $admin_info['userid']);
            Header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
            die();
        } else {
            $error = $lang_module['errorsave'];
        }
    }
}

$aid = $nv_Request->get_int('aid', 'get', 0);
if ($aid > 0) {
    list ($aid, $title, $alias, $description, $from_age, $to_age) = $db->query("SELECT aid, title, alias, description, from_age, to_age FROM " . NV_PREFIXLANG . "_" . $module_data . "_age_cat where aid=" . $aid)->fetch(3);
    $lang_module['add_age_cat'] = $lang_module['edit_age_cat'];
}

$lang_global['title_suggest_max'] = sprintf($lang_global['length_suggest_max'], 65);
$lang_global['description_suggest_max'] = sprintf($lang_global['length_suggest_max'], 160);

$xtpl = new XTemplate('age.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('GLANG', $lang_global);
$xtpl->assign('NV_BASE_ADMINURL', NV_BASE_ADMINURL);
$xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('OP', $op);

$xtpl->assign('AGE_CAT_LIST', nv_show_age_list());

$xtpl->assign('aid', $aid);
$xtpl->assign('title', $title);
$xtpl->assign('alias', $alias);
$xtpl->assign('from_age', $from_age);
$xtpl->assign('to_age', $to_age);
$xtpl->assign('description', nv_htmlspecialchars(nv_br2nl($description)));

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
