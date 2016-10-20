<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 2-9-2010 14:43
 */
if (! defined('NV_IS_FILE_ADMIN')) {
    die('Stop!!!');
}

if (defined('NV_EDITOR')) {
    require_once NV_ROOTDIR . '/' . NV_EDITORSDIR . '/' . NV_EDITOR . '/nv.php';
}

$username_alias = change_alias($admin_info['username']);
$array_structure_image = array();
$array_structure_image[''] = $module_upload;
$array_structure_image['Y'] = $module_upload . '/' . date('Y');
$array_structure_image['Ym'] = $module_upload . '/' . date('Y_m');
$array_structure_image['Y_m'] = $module_upload . '/' . date('Y/m');
$array_structure_image['Ym_d'] = $module_upload . '/' . date('Y_m/d');
$array_structure_image['Y_m_d'] = $module_upload . '/' . date('Y/m/d');
$array_structure_image['username'] = $module_upload . '/' . $username_alias;

$array_structure_image['username_Y'] = $module_upload . '/' . $username_alias . '/' . date('Y');
$array_structure_image['username_Ym'] = $module_upload . '/' . $username_alias . '/' . date('Y_m');
$array_structure_image['username_Y_m'] = $module_upload . '/' . $username_alias . '/' . date('Y/m');
$array_structure_image['username_Ym_d'] = $module_upload . '/' . $username_alias . '/' . date('Y_m/d');
$array_structure_image['username_Y_m_d'] = $module_upload . '/' . $username_alias . '/' . date('Y/m/d');

$structure_upload = isset($module_config[$module_name]['structure_upload']) ? $module_config[$module_name]['structure_upload'] : 'Ym';
$currentpath = isset($array_structure_image[$structure_upload]) ? $array_structure_image[$structure_upload] : '';

if (file_exists(NV_UPLOADS_REAL_DIR . '/' . $currentpath)) {
    $upload_real_dir_page = NV_UPLOADS_REAL_DIR . '/' . $currentpath;
} else {
    $upload_real_dir_page = NV_UPLOADS_REAL_DIR . '/' . $module_upload;
    $e = explode('/', $currentpath);
    if (! empty($e)) {
        $cp = '';
        foreach ($e as $p) {
            if (! empty($p) and ! is_dir(NV_UPLOADS_REAL_DIR . '/' . $cp . $p)) {
                $mk = nv_mkdir(NV_UPLOADS_REAL_DIR . '/' . $cp, $p);
                if ($mk[0] > 0) {
                    $upload_real_dir_page = $mk[2];
                    try {
                        $db->query("INSERT INTO " . NV_UPLOAD_GLOBALTABLE . "_dir (dirname, time) VALUES ('" . NV_UPLOADS_DIR . "/" . $cp . $p . "', 0)");
                    } catch (PDOException $e) {
                        trigger_error($e->getMessage());
                    }
                }
            } elseif (! empty($p)) {
                $upload_real_dir_page = NV_UPLOADS_REAL_DIR . '/' . $cp . $p;
            }
            $cp .= $p . '/';
        }
    }
    $upload_real_dir_page = str_replace('\\', '/', $upload_real_dir_page);
}

$currentpath = str_replace(NV_ROOTDIR . '/', '', $upload_real_dir_page);
$uploads_dir_user = NV_UPLOADS_DIR . '/' . $module_upload;
if (! defined('NV_IS_SPADMIN') and strpos($structure_upload, 'username') !== false) {
    $array_currentpath = explode('/', $currentpath);
    if ($array_currentpath[2] == $username_alias) {
        $uploads_dir_user = NV_UPLOADS_DIR . '/' . $module_upload . '/' . $username_alias;
    }
}

$catid = $nv_Request->get_int('catid', 'get', 0);
$parentid = $nv_Request->get_int('parentid', 'get', 0);


$rowcontent = array(
    'id' => '',
    'catid' => $catid,
    'listcatid' => $catid . ',' . $parentid,
    'admin_id' => $admin_info['userid'],
    'addtime' => NV_CURRENTTIME,
    'edittime' => NV_CURRENTTIME,
    'status' => 1,
    'inhome' => 1,
    'title' => '',
    'alias' => '',
	'birthday' => '',
	'height' => '',
	'weight' => '',
	'job_status' => 1,
	'sex' => 0,
	'location_id' => 0,
	'sid' => 0,
	'aid' => 0,
	'religion' => '',
	'about_current_salary' => '',
	'about_wish_salary' => '',
	'about_family' => '',
	'about_experience' => '',
	'about_skill' => '',
	'about_wish' => '',
    'homeimgfile' => '',
    'homeimgalt' => '',
    'homeimgthumb' => '',
    'hitstotal' => 0,
    'mode' => 'add'
);

$page_title = $lang_module['content_add'];
$error = array();
$rowcontent['id'] = $nv_Request->get_int('id', 'get,post', 0);
if ($rowcontent['id'] > 0) {
    $rowcontent = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows where id=' . $rowcontent['id'])->fetch();
    if (! empty($rowcontent['id'])) {
        $rowcontent['mode'] = 'edit';
        $arr_catid = explode(',', $rowcontent['listcatid']);
        // if (defined('NV_IS_MODADMIN')) {
            // $check_permission = true;
        // } else {
            // $check_edit = 0;
            // $status = $rowcontent['status'];
            // foreach ($arr_catid as $catid_i) {
                // if (isset($array_cat_admin[$admin_id][$catid_i])) {
                    // if ($array_cat_admin[$admin_id][$catid_i]['admin'] == 1) {
                        // ++ $check_edit;
                    // } else {
                        // if ($array_cat_admin[$admin_id][$catid_i]['edit_content'] == 1) {
                            // ++ $check_edit;
                        // } elseif ($array_cat_admin[$admin_id][$catid_i]['pub_content'] == 1 and ($status == 0 or $status = 2)) {
                            // ++ $check_edit;
                        // } elseif (($status == 0 or $status == 4 or $status == 5) and $rowcontent['admin_id'] == $admin_id) {
                            // ++ $check_edit;
                        // }
                    // }
                // }
            // }
            // if ($check_edit == sizeof($arr_catid)) {
                // $check_permission = true;
            // }
        // }
    }   
    $page_title = $lang_module['content_edit'];
    
    if (! empty($rowcontent['homeimgfile']) and file_exists(NV_UPLOADS_REAL_DIR)) {
        $currentpath = NV_UPLOADS_DIR . '/' . $module_upload . '/' . dirname($rowcontent['homeimgfile']);
    }
}

$array_cat_add_content = $array_cat_pub_content = $array_cat_edit_content = $array_censor_content = array();
foreach ($global_array_cat as $catid_i => $array_value) {
    $check_add_content = $check_pub_content = $check_edit_content = $check_censor_content = false;
    if (defined('NV_IS_MODADMIN')) {
        $check_add_content = $check_pub_content = $check_edit_content = $check_censor_content = true;
    } elseif (isset($array_cat_admin[$admin_id][$catid_i])) {
        if ($array_cat_admin[$admin_id][$catid_i]['admin'] == 1) {
            $check_add_content = $check_pub_content = $check_edit_content = $check_censor_content = true;
        } else {
            if ($array_cat_admin[$admin_id][$catid_i]['add_content'] == 1) {
                $check_add_content = true;
            }
            
            if ($array_cat_admin[$admin_id][$catid_i]['pub_content'] == 1) {
                $check_pub_content = true;
            }
            
            if ($array_cat_admin[$admin_id][$catid_i]['app_content'] == 1) {
                $check_censor_content = true;
            }
            
            if ($array_cat_admin[$admin_id][$catid_i]['edit_content'] == 1) {
                $check_edit_content = true;
            }
        }
    }
    if ($check_add_content) {
        $array_cat_add_content[] = $catid_i;
    }
    
    if ($check_pub_content) {
        $array_cat_pub_content[] = $catid_i;
    }
    if ($check_censor_content) {
        // Nguoi kiem duyet
        
        $array_censor_content[] = $catid_i;
    }
    
    if ($check_edit_content) {
        $array_cat_edit_content[] = $catid_i;
    }
}

if ($nv_Request->get_int('save', 'post') == 1) {
    $catids = array_unique($nv_Request->get_typed_array('catids', 'post', 'int', array()));
    $rowcontent['listcatid'] = implode(',', $catids);
    $rowcontent['catid'] = $nv_Request->get_int('catid', 'post', 0);
        
    $rowcontent['author'] = $admin_info['username'];
    $rowcontent['title'] = $nv_Request->get_title('title', 'post', '', 1);
    
    // Xử lý liên kết tĩnh
    $alias = $nv_Request->get_title('alias', 'post', '');
    if (empty($alias)) {
        $alias = change_alias($rowcontent['title']);
        $alias = strtolower($alias);
    } else {
        $alias = change_alias($alias);
    }
    
    if (empty($alias) or ! preg_match("/^([a-zA-Z0-9\_\-]+)$/", $alias)) {
        if (empty($rowcontent['alias'])) {
            $rowcontent['alias'] = 'post';
        }
    } else {
        $rowcontent['alias'] = $alias;
    }

    $rowcontent['status'] = $nv_Request->get_int('status', 'post', 0);
    $rowcontent['birthday'] = $nv_Request->get_int('birthday', 'post', 0);
    $rowcontent['height'] = $nv_Request->get_int('height', 'post', 0);
    $rowcontent['weight'] = $nv_Request->get_int('weight', 'post', 0);
	
    $rowcontent['job_status'] = $nv_Request->get_int('job_status', 'post', 0);
    $rowcontent['sex'] = $nv_Request->get_int('sex', 'post', 0);
	
    $rowcontent['location_id'] = $nv_Request->get_int('location', 'post', 0);
    $rowcontent['sid'] = $nv_Request->get_int('salary', 'post', 0);
    $rowcontent['aid'] = $nv_Request->get_int('age', 'post', 0);

    $rowcontent['religion'] = $nv_Request->get_title('religion', 'post', '');
    $rowcontent['about_current_salary'] = $nv_Request->get_int('about_current_salary', 'post', 0);
    $rowcontent['about_wish_salary'] = $nv_Request->get_int('about_wish_salary', 'post', 0);
	
    $rowcontent['homeimgfile'] = $nv_Request->get_title('homeimg', 'post', '');
    $rowcontent['homeimgalt'] = $nv_Request->get_title('homeimgalt', 'post', '', 1);

    $rowcontent['about_family'] = $nv_Request->get_editor('about_family', '', NV_ALLOWED_HTML_TAGS);
    $rowcontent['about_experience'] = $nv_Request->get_editor('about_experience', '', NV_ALLOWED_HTML_TAGS);
    $rowcontent['about_skill'] = $nv_Request->get_editor('about_skill', '', NV_ALLOWED_HTML_TAGS);
    $rowcontent['about_wish'] = $nv_Request->get_editor('about_wish', '', NV_ALLOWED_HTML_TAGS);
    
    if ($rowcontent['status'] == 1) {
        if (empty($rowcontent['title'])) {
            $error[] = $lang_module['error_title'];
        } elseif (empty($rowcontent['listcatid'])) {
            $error[] = $lang_module['error_cat'];
        }
    }
    
    if (empty($error)) {
        if (! empty($catids)) {
            $rowcontent['catid'] = in_array($rowcontent['catid'], $catids) ? $rowcontent['catid'] : $catids[0];
        }
        
        // Xu ly anh minh hoa
        $rowcontent['homeimgthumb'] = 0;
        if (! nv_is_url($rowcontent['homeimgfile']) and nv_is_file($rowcontent['homeimgfile'], NV_UPLOADS_DIR . '/' . $module_upload) === true) {
            $lu = strlen(NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/');
            $rowcontent['homeimgfile'] = substr($rowcontent['homeimgfile'], $lu);
            if (file_exists(NV_ROOTDIR . '/' . NV_FILES_DIR . '/' . $module_upload . '/' . $rowcontent['homeimgfile'])) {
                $rowcontent['homeimgthumb'] = 1;
            } else {
                $rowcontent['homeimgthumb'] = 2;
            }
        } elseif (nv_is_url($rowcontent['homeimgfile'])) {
            $rowcontent['homeimgthumb'] = 3;
        } else {
            $rowcontent['homeimgfile'] = '';
        }
        
        if ($rowcontent['id'] == 0) {
            if (! defined('NV_IS_SPADMIN') and intval($rowcontent['publtime']) < NV_CURRENTTIME) {
                $rowcontent['publtime'] = NV_CURRENTTIME;
            }
			$sort = $db->query('SELECT max(sort) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows')->fetchColumn();
			$sort = intval($sort) + 1;
			
            $sql = 'INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_rows
				(catid, listcatid, admin_id, author, addtime, edittime, status, title, alias, birthday, height, weight, job_status, sex, location_id, sid, aid, religion, about_current_salary, about_wish_salary, about_family, about_experience, about_skill, about_wish, homeimgfile, homeimgalt, homeimgthumb, inhome, sort, hitstotal) VALUES
				 (' . intval($rowcontent['catid']) . ',
				:listcatid,
				' . intval($rowcontent['admin_id']) . ',
				:author,
				' . intval($rowcontent['addtime']) . ',
				' . intval($rowcontent['edittime']) . ',
				' . intval($rowcontent['status']) . ',
				:title,
				:alias,
				' . intval($rowcontent['birthday']) . ',
				' . intval($rowcontent['height']) . ',
				' . intval($rowcontent['weight']) . ',
				' . intval($rowcontent['job_status']) . ',
				' . intval($rowcontent['sex']) . ',
				' . intval($rowcontent['location_id']) . ',
				' . intval($rowcontent['sid']) . ',
				' . intval($rowcontent['aid']) . ',
				:religion,
				' . intval($rowcontent['about_current_salary']) . ',
				' . intval($rowcontent['about_wish_salary']) . ',
				:about_family,
				:about_experience,
				:about_skill,
				:about_wish,
				:homeimgfile,
				:homeimgalt,
				:homeimgthumb,
				' . intval($rowcontent['inhome']) . ',
				:sort,
				1
				)';
            
            $data_insert = array();
            $data_insert['listcatid'] = $rowcontent['listcatid'];
            $data_insert['author'] = $admin_info['username'];
            $data_insert['title'] = $rowcontent['title'];
            $data_insert['alias'] = $rowcontent['alias'];
            $data_insert['religion'] = $rowcontent['religion'];
            $data_insert['about_family'] = $rowcontent['about_family'];
            $data_insert['about_experience'] = $rowcontent['about_experience'];
            $data_insert['about_skill'] = $rowcontent['about_skill'];
            $data_insert['about_wish'] = $rowcontent['about_wish'];
            $data_insert['homeimgfile'] = $rowcontent['homeimgfile'];
            $data_insert['homeimgalt'] = $rowcontent['homeimgalt'];
            $data_insert['homeimgthumb'] = $rowcontent['homeimgthumb'];
            $data_insert['sort'] = $sort;
            
            $rowcontent['id'] = $db->insert_id($sql, 'id', $data_insert);
            if ($rowcontent['id'] > 0) {
				nv_fix_rows_order();
                nv_insert_logs(NV_LANG_DATA, $module_name, $lang_module['content_add'], $rowcontent['title'], $admin_info['userid']);
            } else {
                $error[] = $lang_module['errorsave'];
            }
        } else {
            $rowcontent_old = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows where id=' . $rowcontent['id'])->fetch();
            if ($rowcontent_old['status'] == 1) {
                $rowcontent['status'] = 1;
            }

            $sth = $db->prepare('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_rows SET
					catid=' . intval($rowcontent['catid']) . ',
					listcatid=:listcatid,
					author=:author,
					status=' . intval($rowcontent['status']) . ',
					title=:title,
					alias=:alias,
					birthday=' . intval($rowcontent['birthday']) . ',
					height=' . intval($rowcontent['height']) . ',
					weight=' . intval($rowcontent['weight']) . ',
					job_status=' . intval($rowcontent['job_status']) . ',
					sex=' . intval($rowcontent['sex']) . ',
					location_id=' . intval($rowcontent['location_id']) . ',
					sid=' . intval($rowcontent['sid']) . ',
					aid=' . intval($rowcontent['aid']) . ',
					religion=:religion,
					about_current_salary=' . intval($rowcontent['about_current_salary']) . ',
					about_wish_salary=' . intval($rowcontent['about_wish_salary']) . ',
					about_family=:about_family,
					about_experience=:about_experience,
					about_skill=:about_skill,
					about_wish=:about_wish,
					homeimgfile=:homeimgfile,
					homeimgalt=:homeimgalt,
					homeimgthumb=:homeimgthumb,
					inhome=' . intval($rowcontent['inhome']) . ',
					edittime=' . NV_CURRENTTIME . '
				WHERE id =' . $rowcontent['id']);
            
            $sth->bindParam(':listcatid', $rowcontent['listcatid'], PDO::PARAM_STR);
            $sth->bindParam(':author', $admin_info['username'], PDO::PARAM_STR);
            $sth->bindParam(':title', $rowcontent['title'], PDO::PARAM_STR);
            $sth->bindParam(':alias', $rowcontent['alias'], PDO::PARAM_STR);
			$sth->bindParam(':religion', $rowcontent['religion'], PDO::PARAM_STR);
			$sth->bindParam(':about_family', $rowcontent['about_family'], PDO::PARAM_STR);
			$sth->bindParam(':about_experience', $rowcontent['about_experience'], PDO::PARAM_STR);
			$sth->bindParam(':about_skill', $rowcontent['about_skill'], PDO::PARAM_STR);
			$sth->bindParam(':about_wish', $rowcontent['about_wish'], PDO::PARAM_STR);
            $sth->bindParam(':homeimgfile', $rowcontent['homeimgfile'], PDO::PARAM_STR);
            $sth->bindParam(':homeimgalt', $rowcontent['homeimgalt'], PDO::PARAM_STR);
            $sth->bindParam(':homeimgthumb', $rowcontent['homeimgthumb'], PDO::PARAM_STR);
            
            if ($sth->execute()) {
                nv_insert_logs(NV_LANG_DATA, $module_name, $lang_module['content_edit'], $rowcontent['title'], $admin_info['userid']);
            } else {
                $error[] = $lang_module['errorsave'];
            }
        }
        
        if (empty($error)) {
			$db->query('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_salary WHERE id = ' . $rowcontent['id'] . ' AND sid = ' . $rowcontent['sid']);
			$db->query('INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_salary (sid, id, weight) VALUES (' . $rowcontent['sid'] . ', ' . $rowcontent['id'] . ', 0)');
            
			$db->query('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_age WHERE id = ' . $rowcontent['id'] . ' AND aid = ' . $rowcontent['aid']);
			$db->query('INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_age (aid, id, weight) VALUES (' . $rowcontent['aid'] . ', ' . $rowcontent['id'] . ', 0)');
            
			$db->query('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_location_id WHERE id = ' . $rowcontent['id'] . ' AND location_id = ' . $rowcontent['location_id']);
			$db->query('INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_location_id (location_id, id, weight) VALUES (' . $rowcontent['location_id'] . ', ' . $rowcontent['id'] . ', 0)');
            
			$url = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name;
			$msg1 = $lang_module['content_saveok'];
			$msg2 = $lang_module['content_main'] . ' ' . $module_info['custom_title'];
			redirect($msg1, $msg2, $url);
        }
    } else {
        $url = 'javascript: history.go(-1)';
        $msg1 = implode('<br />', $error);
        $msg2 = $lang_module['content_back'];
        redirect($msg1, $msg2, $url, 'back');
    }
}

$rowcontent['about_family'] = htmlspecialchars(nv_editor_br2nl($rowcontent['about_family']));
$rowcontent['alias'] = ($rowcontent['status'] == 4 and empty($rowcontent['title'])) ? '' : $rowcontent['alias'];

if (! empty($rowcontent['homeimgfile']) and file_exists(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . $rowcontent['homeimgfile'])) {
    $rowcontent['homeimgfile'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $rowcontent['homeimgfile'];
}

$array_catid_in_row = explode(',', $rowcontent['listcatid']);

if ($rowcontent['status'] == 1 ) {
    $array_cat_check_content = $array_cat_pub_content;
} elseif ($rowcontent['status'] == 1) {
    $array_cat_check_content = $array_cat_edit_content;
} else {
    $array_cat_check_content = $array_cat_add_content;
}

if (empty($array_cat_check_content)) {
    $redirect = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=job';
    $contents = nv_theme_alert($lang_module['note_cat_title'], $lang_module['note_cat_content'], 'warning', $redirect, $lang_module['job']);
    
    include NV_ROOTDIR . '/includes/header.php';
    echo nv_admin_theme($contents);
    include NV_ROOTDIR . '/includes/footer.php';
    die();
}
$contents = '';

$lang_global['title_suggest_max'] = sprintf($lang_global['length_suggest_max'], 65);
$lang_global['description_suggest_max'] = sprintf($lang_global['length_suggest_max'], 160);

$xtpl = new XTemplate('employee.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('GLANG', $lang_global);
$xtpl->assign('rowcontent', $rowcontent);
$xtpl->assign('NV_BASE_ADMINURL', NV_BASE_ADMINURL);
$xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
$xtpl->assign('NV_OP_VARIABLE', NV_OP_VARIABLE);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('OP', $op);

$xtpl->assign('module_name', $module_name);

foreach ($global_array_cat as $catid_i => $array_value) {
    if (defined('NV_IS_MODADMIN')) {
        $check_show = 1;
    } else {
        $array_cat = GetCatidInParent($catid_i);
        $check_show = array_intersect($array_cat, $array_cat_check_content);
    }
    if (! empty($check_show)) {
        $space = intval($array_value['lev']) * 30;
        $catiddisplay = (sizeof($array_catid_in_row) > 1 and (in_array($catid_i, $array_catid_in_row))) ? '' : ' display: none;';
        $temp = array(
            'catid' => $catid_i,
            'space' => $space,
            'title' => $array_value['title'],
            'disabled' => (! in_array($catid_i, $array_cat_check_content)) ? ' disabled="disabled"' : '',
            'checked' => (in_array($catid_i, $array_catid_in_row)) ? ' checked="checked"' : '',
            'catidchecked' => ($catid_i == $rowcontent['catid']) ? ' checked="checked"' : '',
            'catiddisplay' => $catiddisplay
        );
        $xtpl->assign('CATS', $temp);
        $xtpl->parse('main.catid');
    }
}
// Location
foreach ($global_array_location as $location_id_i => $array_value) {
	$temp = array(
		'location_id' => $location_id_i,
		'title' => $array_value['title'],
		'selected' => ($location_id_i == $rowcontent['location_id']) ? ' selected="selected"' : '',
	);
	$xtpl->assign('LOCATIONS', $temp);
	$xtpl->parse('main.location');
}

// Age
foreach ($global_array_age as $aid_i => $array_value) {
	$temp = array(
		'aid' => $aid_i,
		'title' => $array_value['title'],
		'selected' => ($aid_i == $rowcontent['aid']) ? ' selected="selected"' : '',
	);
	$xtpl->assign('AGE', $temp);
	$xtpl->parse('main.age');
}

// Salary
foreach ($global_array_salary as $sid_i => $array_value) {
	$temp = array(
		'sid' => $sid_i,
		'title' => $array_value['title'],
		'selected' => ($sid_i == $rowcontent['sid']) ? ' selected="selected"' : '',
	);
	$xtpl->assign('SALARY', $temp);
	$xtpl->parse('main.salary');
}
// Job status
$array_job_status = array(
    $lang_global['yes'] => 1,
    $lang_global['no'] => 0
);
foreach ($array_job_status as $title => $value) {
	$xtpl->assign('JOB_STATUS', array(
		'key' => $value,
		'title' => $title,
		'selected' => $value == $rowcontent['job_status'] ? ' selected="selected"' : ''
	));
	$xtpl->parse('main.job_status.loop');
}
$xtpl->parse('main.job_status');

// Inhome status
foreach ($array_job_status as $title => $value) {
	$xtpl->assign('INHOME', array(
		'key' => $value,
		'title' => $title,
		'selected' => $value == $rowcontent['inhome'] ? ' selected="selected"' : ''
	));
	$xtpl->parse('main.inhome.loop');
}
$xtpl->parse('main.inhome');

// Main status
foreach ($array_job_status as $title => $value) {
	$xtpl->assign('STATUS', array(
		'key' => $value,
		'title' => $title,
		'selected' => $value == $rowcontent['status'] ? ' selected="selected"' : ''
	));
	$xtpl->parse('main.status.loop');
}
$xtpl->parse('main.status');

// Sex
$array_sex = array(
    $lang_module['female'] => 1,
    $lang_module['male'] => 2,
    $lang_module['sex_na'] => 3
);
foreach ($array_sex as $title => $val) {
	$xtpl->assign('SEX', array(
		'key' => $val,
		'title' => $title,
		'selected' => $val == $rowcontent['sex'] ? ' selected="selected"' : ''
	));
	$xtpl->parse('main.sex.loop');
}
$xtpl->parse('main.sex');

if (defined('NV_EDITOR') and nv_function_exists('nv_aleditor')) {
    $about_family = nv_aleditor('about_family', '100%', '250px', $rowcontent['about_family'], '', $uploads_dir_user, $currentpath);
} else {
    $about_family = "<textarea style=\"width: 100%\" name=\"about_family\" id=\"about_family\" cols=\"20\" rows=\"15\">" . $rowcontent['about_family'] . "</textarea>";
}

if (defined('NV_EDITOR') and nv_function_exists('nv_aleditor')) {
    $about_experience = nv_aleditor('about_experience', '100%', '250px', $rowcontent['about_experience'], '', $uploads_dir_user, $currentpath);
} else {
    $about_experience = "<textarea style=\"width: 100%\" name=\"about_experience\" id=\"about_experience\" cols=\"20\" rows=\"15\">" . $rowcontent['about_experience'] . "</textarea>";
}

if (defined('NV_EDITOR') and nv_function_exists('nv_aleditor')) {
    $about_skill = nv_aleditor('about_skill', '100%', '250px', $rowcontent['about_skill'], '', $uploads_dir_user, $currentpath);
} else {
    $about_skill = "<textarea style=\"width: 100%\" name=\"about_skill\" id=\"about_skill\" cols=\"20\" rows=\"15\">" . $rowcontent['about_skill'] . "</textarea>";
}

if (defined('NV_EDITOR') and nv_function_exists('nv_aleditor')) {
    $about_wish = nv_aleditor('about_wish', '100%', '250px', $rowcontent['about_wish'], '', $uploads_dir_user, $currentpath);
} else {
    $about_wish = "<textarea style=\"width: 100%\" name=\"about_wish\" id=\"about_wish\" cols=\"20\" rows=\"15\">" . $rowcontent['about_wish'] . "</textarea>";
}

$xtpl->assign('edit_about_family', $about_family);
$xtpl->assign('edit_about_experience', $about_experience);
$xtpl->assign('edit_about_skill', $about_skill);
$xtpl->assign('edit_about_wish', $about_wish);

if (! empty($error)) {
    $xtpl->assign('error', implode('<br />', $error));
    $xtpl->parse('main.error');
}


if (empty($rowcontent['alias'])) {
    $xtpl->parse('main.getalias');
}
$xtpl->assign('UPLOADS_DIR_USER', $uploads_dir_user);
$xtpl->assign('UPLOAD_CURRENT', $currentpath);

$xtpl->parse('main');
$contents .= $xtpl->text('main');

if ($rowcontent['id'] > 0) {
    $op = '';
}
include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';