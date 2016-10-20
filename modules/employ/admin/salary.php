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
list ($sid, $title, $alias, $description, $from_salary, $to_salary) = array(
    0,
    '',
    '',
    '',
    0,
    0
);

$savecat = $nv_Request->get_int('savecat', 'post', 0);
if (! empty($savecat)) {
    $sid = $nv_Request->get_int('sid', 'post', 0);
    $title = $nv_Request->get_title('title', 'post', '', 1);
    $alias = $nv_Request->get_title('alias', 'post', '');
    $description = $nv_Request->get_string('description', 'post', '');
    $description = nv_nl2br(nv_htmlspecialchars(strip_tags($description)), '<br />');
    $alias = ($alias == '') ? change_alias($title) : change_alias($alias);
    $from_salary = $nv_Request->get_int('from_salary', 'post', 0);
    $to_salary = $nv_Request->get_int('to_salary', 'post', 0);
	
    if (empty($title)) {
        $error = $lang_module['error_name'];
    } elseif ($sid == 0) {
        $weight = $db->query("SELECT max(weight) FROM " . NV_PREFIXLANG . "_" . $module_data . "_salary_cat")->fetchColumn();
        $weight = intval($weight) + 1;
        
        $sql = "INSERT INTO " . NV_PREFIXLANG . "_" . $module_data . "_salary_cat (adddefault, title, alias, description, weight, from_salary, to_salary, add_time, edit_time) VALUES (0, :title , :alias, :description, :weight, :from_salary, :to_salary, " . NV_CURRENTTIME . ", " . NV_CURRENTTIME . ")";
        $data_insert = array();
        $data_insert['title'] = $title;
        $data_insert['alias'] = $alias;
        $data_insert['description'] = $description;
        $data_insert['weight'] = $weight;
        $data_insert['from_salary'] = intval($from_salary);
        $data_insert['to_salary'] = intval($to_salary);
        
        if ($db->insert_id($sql, 'sid', $data_insert)) {
            nv_insert_logs(NV_LANG_DATA, $module_name, 'log_add_salarycat', " ", $admin_info['userid']);
            Header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
            die();
        } else {
            $error = $lang_module['errorsave'];
        }
    } else {
        $stmt = $db->prepare("UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_salary_cat SET title= :title, alias = :alias, description= :description, from_salary = " . intval($from_salary) . ", to_salary = " . intval($to_salary) . ", edit_time=" . NV_CURRENTTIME . " WHERE sid =" . $sid);
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':alias', $alias, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->execute();
        if ($stmt->execute()) {
            nv_insert_logs(NV_LANG_DATA, $module_name, 'log_edit_blockcat', "salary_id " . $sid, $admin_info['userid']);
            Header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
            die();
        } else {
            $error = $lang_module['errorsave'];
        }
    }
}

$sid = $nv_Request->get_int('sid', 'get', 0);
if ($sid > 0) {
    list ($sid, $title, $alias, $description, $from_salary, $to_salary) = $db->query("SELECT sid, title, alias, description, from_salary, to_salary FROM " . NV_PREFIXLANG . "_" . $module_data . "_salary_cat where sid=" . $sid)->fetch(3);
    $lang_module['add_salary_cat'] = $lang_module['edit_salary_cat'];
}

$lang_global['title_suggest_max'] = sprintf($lang_global['length_suggest_max'], 65);
$lang_global['description_suggest_max'] = sprintf($lang_global['length_suggest_max'], 160);

$xtpl = new XTemplate('salary.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('GLANG', $lang_global);
$xtpl->assign('NV_BASE_ADMINURL', NV_BASE_ADMINURL);
$xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('OP', $op);

$xtpl->assign('SALARY_CAT_LIST', nv_show_salary_list());

$xtpl->assign('sid', $sid);
$xtpl->assign('title', $title);
$xtpl->assign('alias', $alias);
$xtpl->assign('from_salary', $from_salary);
$xtpl->assign('to_salary', $to_salary);
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
