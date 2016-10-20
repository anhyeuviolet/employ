<?php

/**
 * @Project NUKEVIET 4.x
 * @Author KennyNguyen (nguyentiendat713@gmail.com)
 * @Copyright (C) 2016 KennyNguyen .All rights reserved
 * @Website support https://www.nuke.vn
 * @License GNU/GPL version 2 or any later version
 * @Createdate Thu, 22 Sep 2016 13:09:49 GMT
 */

if ( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

$page_title = $lang_module['setting'];


$savesetting = $nv_Request->get_int('savesetting', 'post', 0);
if (!empty($savesetting)) {
    $array_config = array();
    $array_config['viewhome'] = $nv_Request->get_title('viewhome', 'post', '', 0);
    $array_config['per_page'] = $nv_Request->get_int('per_page', 'post', 0);
    $array_config['st_links'] = $nv_Request->get_int('st_links', 'post', 0);
    $array_config['structure_upload'] = $nv_Request->get_title('structure_upload', 'post', '', 0);
    $array_config['sale_email'] = $nv_Request->get_title('sale_email', 'post', '', 0);
    $array_config['captcha'] = $nv_Request->get_int('captcha', 'post', '', 0);
    $array_config['show_no_image'] = $nv_Request->get_title('show_no_image', 'post', '', 0);
	
    if (!nv_is_url($array_config['show_no_image']) and nv_is_file($array_config['show_no_image'])) {
        $lu = strlen(NV_BASE_SITEURL);
        $array_config['show_no_image'] = substr($array_config['show_no_image'], $lu);
    } else {
        $array_config['show_no_image'] = '';
    }
	
    $sth = $db->prepare("UPDATE " . NV_CONFIG_GLOBALTABLE . " SET config_value = :config_value WHERE lang = '" . NV_LANG_DATA . "' AND module = :module_name AND config_name = :config_name");
    $sth->bindParam(':module_name', $module_name, PDO::PARAM_STR);
    foreach ($array_config as $config_name => $config_value) {
        $sth->bindParam(':config_name', $config_name, PDO::PARAM_STR);
        $sth->bindParam(':config_value', $config_value, PDO::PARAM_STR);
        $sth->execute();
    }
    
    $nv_Cache->delMod('settings');
    $nv_Cache->delMod($module_name);
    Header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op . '&rand=' . nv_genpass());
    die();
}

$xtpl = new XTemplate('config.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('GLANG', $lang_global);
$xtpl->assign('NV_BASE_ADMINURL', NV_BASE_ADMINURL);
$xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
$xtpl->assign('NV_OP_VARIABLE', NV_OP_VARIABLE);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('OP', $op);
$xtpl->assign('DATA', $module_config[$module_name]);


// So bai viet tren mot trang
for ($i = 5; $i <= 30; ++$i) {
    $xtpl->assign('PER_PAGE', array(
        'key' => $i,
        'title' => $i,
        'selected' => $i == $module_config[$module_name]['per_page'] ? ' selected="selected"' : ''
    ));
    $xtpl->parse('main.per_page');
}

// Bai viet chi hien thi link
for ($i = 0; $i <= 20; ++$i) {
    $xtpl->assign('ST_LINKS', array(
        'key' => $i,
        'title' => $i,
        'selected' => $i == $module_config[$module_name]['st_links'] ? ' selected="selected"' : ''
    ));
    $xtpl->parse('main.st_links');
}


$array_structure_image = array();
$array_structure_image[''] = NV_UPLOADS_DIR . '/' . $module_upload;
$array_structure_image['Y'] = NV_UPLOADS_DIR . '/' . $module_upload . '/' . date('Y');
$array_structure_image['Ym'] = NV_UPLOADS_DIR . '/' . $module_upload . '/' . date('Y_m');
$array_structure_image['Y_m'] = NV_UPLOADS_DIR . '/' . $module_upload . '/' . date('Y/m');
$array_structure_image['Ym_d'] = NV_UPLOADS_DIR . '/' . $module_upload . '/' . date('Y_m/d');
$array_structure_image['Y_m_d'] = NV_UPLOADS_DIR . '/' . $module_upload . '/' . date('Y/m/d');
$array_structure_image['username'] = NV_UPLOADS_DIR . '/' . $module_upload . '/username_admin';

$array_structure_image['username_Y'] = NV_UPLOADS_DIR . '/' . $module_upload . '/username_admin/' . date('Y');
$array_structure_image['username_Ym'] = NV_UPLOADS_DIR . '/' . $module_upload . '/username_admin/' . date('Y_m');
$array_structure_image['username_Y_m'] = NV_UPLOADS_DIR . '/' . $module_upload . '/username_admin/' . date('Y/m');
$array_structure_image['username_Ym_d'] = NV_UPLOADS_DIR . '/' . $module_upload . '/username_admin/' . date('Y_m/d');
$array_structure_image['username_Y_m_d'] = NV_UPLOADS_DIR . '/' . $module_upload . '/username_admin/' . date('Y/m/d');

$structure_image_upload = isset($module_config[$module_name]['structure_upload']) ? $module_config[$module_name]['structure_upload'] : "Ym";

// Cach hien thi tren trang chu
foreach ($array_viewcat_full as $key => $val) {
    $xtpl->assign('VIEWHOME', array(
        'key' => $key,
        'title' => $val,
        'selected' => $key == $module_config[$module_name]['viewhome'] ? ' selected="selected"' : ''
    ));
    $xtpl->parse('main.viewhome');
}

// Thu muc uploads
foreach ($array_structure_image as $type => $dir) {
    $xtpl->assign('STRUCTURE_UPLOAD', array(
        'key' => $type,
        'title' => $dir,
        'selected' => $type == $structure_image_upload ? ' selected="selected"' : ''
    ));
    $xtpl->parse('main.structure_upload');
}

$xtpl->assign('CAPTCHA', $module_config[$module_name]['captcha'] ? ' checked="checked"' : '');
$xtpl->assign('SHOW_NO_IMAGE', (!empty($module_config[$module_name]['show_no_image'])) ? NV_BASE_SITEURL . $module_config[$module_name]['show_no_image'] : '');

$xtpl->assign('PATH', defined('NV_IS_MODADMIN') ? "" : NV_UPLOADS_DIR . '/' . $module_upload);
$xtpl->assign('CURRENTPATH', defined('NV_IS_MODADMIN') ? "images" : NV_UPLOADS_DIR . '/' . $module_upload);

$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';