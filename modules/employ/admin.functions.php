<?php

/**
 * @Project NUKEVIET 4.x
 * @Author KennyNguyen (nguyentiendat713@gmail.com)
 * @Copyright (C) 2016 KennyNguyen .All rights reserved
 * @Website support https://www.nuke.vn
 * @License GNU/GPL version 2 or any later version
 * @Createdate Thu, 22 Sep 2016 13:09:49 GMT
 */

if (!defined('NV_ADMIN') or !defined('NV_MAINFILE') or !defined('NV_IS_MODADMIN'))
	die('Stop!!!');

$array_viewcat_full = array(
    'viewcat_page_new' => $lang_module['viewcat_page_new'],
    'viewcat_page_old' => $lang_module['viewcat_page_old'],
    'viewcat_grid_new' => $lang_module['viewcat_grid_new'],
    'viewcat_grid_old' => $lang_module['viewcat_grid_old'],
    'viewcat_none' => $lang_module['viewcat_none']
);
$array_viewcat_nosub = array(
    'viewcat_page_new' => $lang_module['viewcat_page_new'],
    'viewcat_page_old' => $lang_module['viewcat_page_old'],
    'viewcat_grid_new' => $lang_module['viewcat_grid_new'],
    'viewcat_grid_old' => $lang_module['viewcat_grid_old']
);

$array_allowed_comm = array($lang_global['no'], $lang_global['level6'], $lang_global['level4']);

global $global_array_employee;
$global_array_cat = array();
$sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows ORDER BY sort ASC';
$result = $db_slave -> query($sql);
while ($row = $result -> fetch()) {
	$global_array_employee[$row['id']] = $row;
}

global $global_array_cat;
$global_array_cat = array();
$sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_cat ORDER BY sort ASC';
$result = $db_slave -> query($sql);
while ($row = $result -> fetch()) {
	$global_array_cat[$row['catid']] = $row;
}

global $global_array_location;
$global_array_location = array();
$sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_location ORDER BY weight ASC';
$result = $db_slave -> query($sql);
while ($row = $result -> fetch()) {
	$global_array_location[$row['location_id']] = $row;
}

global $global_array_salary;
$global_array_salary = array();
$sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_salary_cat ORDER BY weight ASC';
$result = $db_slave -> query($sql);
while ($row = $result -> fetch()) {
	$global_array_salary[$row['sid']] = $row;
}

global $global_array_age;
$global_array_age = array();
$sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_age_cat ORDER BY weight ASC';
$result = $db_slave -> query($sql);
while ($row = $result -> fetch()) {
	$global_array_age[$row['aid']] = $row;
}

$submenu['main'] = $lang_module['main'];
$submenu['employee'] = $lang_module['add_employee'];
$submenu['job'] = $lang_module['job'];
$submenu['salary'] = $lang_module['salary'];
$submenu['age'] = $lang_module['age'];
$submenu['location'] = $lang_module['location'];
$submenu['request'] = 'Liên hệ từ Web';
$submenu['config'] = $lang_module['config'];

$allow_func = array('request','del_request', 'location_list', 'location', 'del_location', 'main', 'employee', 'change_employee', 'del_employee', 'employee_list', 'config', 'salary', 'del_salary_cat', 'salary_list', 'change_salary_cat', 'age', 'age_list', 'del_age_cat', 'change_age_cat', 'job', 'job_list', 'alias', 'del_cat', 'list_cat', 'change_cat');

define('NV_IS_FILE_ADMIN', true);

/**
 * nv_show_location_list()
 *
 * @return
 */
function nv_show_location_list() {
	global $db_slave, $lang_module, $lang_global, $module_name, $module_data, $op, $module_file, $global_config;

	$xtpl = new XTemplate('location_list.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
	$xtpl -> assign('LANG', $lang_module);
	$xtpl -> assign('GLANG', $lang_global);
	$xtpl -> assign('NV_BASE_ADMINURL', NV_BASE_ADMINURL);
	$xtpl -> assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
	$xtpl -> assign('NV_OP_VARIABLE', NV_OP_VARIABLE);
	$xtpl -> assign('MODULE_NAME', $module_name);
	$xtpl -> assign('OP', $op);

	$sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_location WHERE status=1 ORDER BY location_id ASC';
	$array_block = $db_slave -> query($sql) -> fetchAll();
	$num = sizeof($array_block);
	$array_status = array($lang_global['no'], $lang_global['yes']);
	if ($num > 0) {
		foreach ($array_block as $row) {
			$xtpl -> assign('ROW', array(
				'location_id' => $row['location_id'],
				'title' => $row['title'],
				'type' => $row['type'],
				'url_edit' => NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;location_id=' . $row['location_id'] . '#edit'
				)
			);

			foreach ($array_status as $key => $val) {
				$xtpl -> assign('STATUS', array('key' => $key, 'title' => $val, 'selected' => $key == $row['status'] ? ' selected="selected"' : ''));
				$xtpl -> parse('main.loop.status.loop');
			}
			$xtpl -> parse('main.loop.status');

			$xtpl -> parse('main.loop');
		}

		$xtpl -> parse('main');
		$contents = $xtpl -> text('main');
	} else {
		$contents = '&nbsp;';
	}
	return $contents;
}

/**
 * nv_show_cat_list()
 *
 * @param integer $parentid
 * @return
 *
 */
function nv_show_cat_list($parentid = 0) {
	global $db, $lang_module, $lang_global, $module_name, $module_data, $array_viewcat_full, $array_viewcat_nosub, $array_cat_admin, $global_array_cat, $admin_id, $global_config, $module_file;

	$xtpl = new XTemplate('cat_list.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
	$xtpl -> assign('LANG', $lang_module);
	$xtpl -> assign('GLANG', $lang_global);

	// Cac chu de co quyen han
	$array_cat_check_content = array();
	foreach ($global_array_cat as $catid_i => $array_value) {
		if (defined('NV_IS_MODADMIN')) {
			$array_cat_check_content[] = $catid_i;
		} elseif (isset($array_cat_admin[$admin_id][$catid_i])) {
			if ($array_cat_admin[$admin_id][$catid_i]['admin'] == 1) {
				$array_cat_check_content[] = $catid_i;
			} elseif ($array_cat_admin[$admin_id][$catid_i]['add_content'] == 1) {
				$array_cat_check_content[] = $catid_i;
			} elseif ($array_cat_admin[$admin_id][$catid_i]['pub_content'] == 1) {
				$array_cat_check_content[] = $catid_i;
			} elseif ($array_cat_admin[$admin_id][$catid_i]['edit_content'] == 1) {
				$array_cat_check_content[] = $catid_i;
			}
		}
	}

	// Cac chu de co quyen han
	if ($parentid > 0) {
		$parentid_i = $parentid;
		$array_cat_title = array();
		while ($parentid_i > 0) {
			$array_cat_title[] = "<a href=\"" . NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=job&amp;parentid=" . $parentid_i . "\"><strong>" . $global_array_cat[$parentid_i]['title'] . "</strong></a>";
			$parentid_i = $global_array_cat[$parentid_i]['parentid'];
		}
		sort($array_cat_title, SORT_NUMERIC);

		$xtpl -> assign('CAT_TITLE', implode(' &raquo; ', $array_cat_title));
		$xtpl -> parse('main.cat_title');
	}

	$sql = 'SELECT catid, parentid, title, weight, viewcat, numsubcat, numlinks FROM ' . NV_PREFIXLANG . '_' . $module_data . '_cat WHERE parentid = ' . $parentid . ' ORDER BY weight ASC';
	$rowall = $db -> query($sql) -> fetchAll(3);
	$num = sizeof($rowall);
	$a = 1;
	$array_inhome = array($lang_global['no'], $lang_global['yes']);

	foreach ($rowall as $row) {
		list($catid, $parentid, $title, $weight, $viewcat, $numsubcat, $numlinks) = $row;
		if (defined('NV_IS_MODADMIN')) {
			$check_show = 1;
		} else {
			$array_cat = GetCatidInParent($catid);
			$check_show = array_intersect($array_cat, $array_cat_check_content);
		}

		if (!empty($check_show)) {
			$array_viewcat = ($numsubcat > 0) ? $array_viewcat_full : $array_viewcat_nosub;
			if (!array_key_exists($viewcat, $array_viewcat)) {
				$viewcat = 'viewcat_page_new';
				$stmt = $db -> prepare('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_cat SET viewcat= :viewcat WHERE catid=' . intval($catid));
				$stmt -> bindParam(':viewcat', $viewcat, PDO::PARAM_STR);
				$stmt -> execute();
			}

			$admin_funcs = array();
			$weight_disabled = $func_cat_disabled = true;
			if (defined('NV_IS_MODADMIN') or (isset($array_cat_admin[$admin_id][$catid]) and $array_cat_admin[$admin_id][$catid]['add_content'] == 1)) {
				$func_cat_disabled = false;
				$admin_funcs[] = "<em class=\"fa fa-plus fa-lg\">&nbsp;</em> <a href=\"" . NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=employee&amp;catid=" . $catid . "&amp;parentid=" . $parentid . "\">" . $lang_module['content_add'] . "</a>\n";
			}
			if (defined('NV_IS_MODADMIN') or ($parentid > 0 and isset($array_cat_admin[$admin_id][$parentid]) and $array_cat_admin[$admin_id][$parentid]['admin'] == 1)) {
				$func_cat_disabled = false;
				$admin_funcs[] = "<em class=\"fa fa-edit fa-lg\">&nbsp;</em> <a class=\"\" href=\"" . NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=job&amp;catid=" . $catid . "&amp;parentid=" . $parentid . "#edit\">" . $lang_global['edit'] . "</a>\n";
			}
			if (defined('NV_IS_MODADMIN') or ($parentid > 0 and isset($array_cat_admin[$admin_id][$parentid]) and $array_cat_admin[$admin_id][$parentid]['admin'] == 1)) {
				$weight_disabled = false;
				$admin_funcs[] = "<em class=\"fa fa-trash-o fa-lg\">&nbsp;</em> <a href=\"javascript:void(0);\" onclick=\"nv_del_cat(" . $catid . ")\">" . $lang_global['delete'] . "</a>";
			}

			$xtpl -> assign('ROW', array('catid' => $catid, 'link' => NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=job&amp;parentid=' . $catid, 'title' => $title, 'adminfuncs' => implode('&nbsp;-&nbsp;', $admin_funcs)));

			if ($weight_disabled) {
				$xtpl -> assign('STT', $a);
				$xtpl -> parse('main.data.loop.stt');
			} else {
				for ($i = 1; $i <= $num; ++$i) {
					$xtpl -> assign('WEIGHT', array('key' => $i, 'title' => $i, 'selected' => $i == $weight ? ' selected="selected"' : ''));
					$xtpl -> parse('main.data.loop.weight.loop');
				}
				$xtpl -> parse('main.data.loop.weight');
			}

			foreach ($array_viewcat as $key => $val) {
				$xtpl->assign('VIEWCAT', array(
					'key' => $key,
					'title' => $val,
					'selected' => $key == $viewcat ? ' selected="selected"' : ''
				));
				$xtpl->parse('main.data.loop.viewcat.loop');
			}
			$xtpl->parse('main.data.loop.viewcat');

			for ($i = 0; $i <= 20; ++$i) {
				$xtpl->assign('NUMLINKS', array(
					'key' => $i,
					'title' => $i,
					'selected' => $i == $numlinks ? ' selected="selected"' : ''
				));
				$xtpl->parse('main.data.loop.numlinks.loop');
			}
			$xtpl->parse('main.data.loop.numlinks');

			if ($numsubcat) {
				$xtpl -> assign('NUMSUBCAT', $numsubcat);
				$xtpl -> parse('main.data.loop.numsubcat');
			}

			$xtpl -> parse('main.data.loop');
			++$a;
		}
	}

	if ($num > 0) {
		$xtpl -> parse('main.data');
	}

	$xtpl -> parse('main');
	$contents = $xtpl -> text('main');

	return $contents;
}

/**
 * nv_fix_cat_order()
 *
 * @param integer $parentid
 * @param integer $order
 * @param integer $lev
 * @return
 *
 */
function nv_fix_cat_order($parentid = 0, $order = 0, $lev = 0) {
	global $db, $module_data;

	$sql = 'SELECT catid, parentid FROM ' . NV_PREFIXLANG . '_' . $module_data . '_cat WHERE parentid=' . $parentid . ' ORDER BY weight ASC';
	$result = $db -> query($sql);
	$array_cat_order = array();
	while ($row = $result -> fetch()) {
		$array_cat_order[] = $row['catid'];
	}
	$result -> closeCursor();
	$weight = 0;
	if ($parentid > 0) {
		++$lev;
	} else {
		$lev = 0;
	}
	foreach ($array_cat_order as $catid_i) {
		++$order;
		++$weight;
		$sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_cat SET weight=' . $weight . ', sort=' . $order . ', lev=' . $lev . ' WHERE catid=' . intval($catid_i);
		$db -> query($sql);
		$order = nv_fix_cat_order($catid_i, $order, $lev);
	}
	$numsubcat = $weight;
	if ($parentid > 0) {
		$sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_cat SET numsubcat=' . $numsubcat;
		if ($numsubcat == 0) {
			$sql .= ",subcatid='', viewcat='viewcat_page_new'";
		} else {
			$sql .= ",subcatid='" . implode(',', $array_cat_order) . "'";
		}
		$sql .= ' WHERE catid=' . intval($parentid);
		$db -> query($sql);
	}
	return $order;
}

/**
 * GetCatidInParent()
 *
 * @param mixed $catid
 * @return
 *
 */
function GetCatidInParent($catid) {
	global $global_array_cat;
	$array_cat = array();
	$array_cat[] = $catid;
	$subcatid = explode(',', $global_array_cat[$catid]['subcatid']);
	if (!empty($subcatid)) {
		foreach ($subcatid as $id) {
			if ($id > 0) {
				if ($global_array_cat[$id]['numsubcat'] == 0) {
					$array_cat[] = $id;
				} else {
					$array_cat_temp = GetCatidInParent($id);
					foreach ($array_cat_temp as $catid_i) {
						$array_cat[] = $catid_i;
					}
				}
			}
		}
	}
	return array_unique($array_cat);
}

/**
 * nv_show_salary_list()
 *
 * @return
 *
 */
function nv_show_salary_list() {
	global $db_slave, $lang_module, $lang_global, $module_name, $module_data, $op, $module_file, $global_config, $module_info;

	$sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_salary_cat ORDER BY weight ASC';
	$_array_block_cat = $db_slave -> query($sql) -> fetchAll();
	$num = sizeof($_array_block_cat);

	if ($num > 0) {
		$array_adddefault = array($lang_global['no'], $lang_global['yes']);

		$xtpl = new XTemplate('salary_list.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
		$xtpl -> assign('LANG', $lang_module);
		$xtpl -> assign('GLANG', $lang_global);

		foreach ($_array_block_cat as $row) {

			$xtpl -> assign('ROW', array('sid' => $row['sid'], 'title' => $row['title'], 'url_edit' => NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;sid=' . $row['sid'] . '#edit'));

			for ($i = 1; $i <= $num; ++$i) {
				$xtpl -> assign('WEIGHT', array('key' => $i, 'title' => $i, 'selected' => $i == $row['weight'] ? ' selected="selected"' : ''));
				$xtpl -> parse('main.loop.weight');
			}

			foreach ($array_adddefault as $key => $val) {
				$xtpl -> assign('ADDDEFAULT', array('key' => $key, 'title' => $val, 'selected' => $key == $row['adddefault'] ? ' selected="selected"' : ''));
				$xtpl -> parse('main.loop.adddefault');
			}

			$xtpl -> parse('main.loop');
		}

		$xtpl -> parse('main');
		$contents = $xtpl -> text('main');
	} else {
		$contents = '&nbsp;';
	}

	return $contents;
}

/**
 * nv_fix_salary_cat()
 *
 * @return
 *
 */
function nv_fix_salary_cat() {
	global $db, $module_data;
	$sql = 'SELECT sid FROM ' . NV_PREFIXLANG . '_' . $module_data . '_salary_cat ORDER BY weight ASC';
	$weight = 0;
	$result = $db -> query($sql);
	while ($row = $result -> fetch()) {
		++$weight;
		$sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_salary_cat SET weight=' . $weight . ' WHERE sid=' . intval($row['sid']);
		$db -> query($sql);
	}
	$result -> closeCursor();
}

/**
 * nv_show_age_list()
 *
 * @return
 *
 */
function nv_show_age_list() {
	global $db_slave, $lang_module, $lang_global, $module_name, $module_data, $op, $module_file, $global_config, $module_info;

	$sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_age_cat ORDER BY weight ASC';
	$_array_block_cat = $db_slave -> query($sql) -> fetchAll();
	$num = sizeof($_array_block_cat);

	if ($num > 0) {
		$array_adddefault = array($lang_global['no'], $lang_global['yes']);

		$xtpl = new XTemplate('age_list.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
		$xtpl -> assign('LANG', $lang_module);
		$xtpl -> assign('GLANG', $lang_global);

		foreach ($_array_block_cat as $row) {

			$xtpl -> assign('ROW', array('aid' => $row['aid'], 'title' => $row['title'], 'url_edit' => NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;aid=' . $row['aid'] . '#edit'));

			for ($i = 1; $i <= $num; ++$i) {
				$xtpl -> assign('WEIGHT', array('key' => $i, 'title' => $i, 'selected' => $i == $row['weight'] ? ' selected="selected"' : ''));
				$xtpl -> parse('main.loop.weight');
			}

			foreach ($array_adddefault as $key => $val) {
				$xtpl -> assign('ADDDEFAULT', array('key' => $key, 'title' => $val, 'selected' => $key == $row['adddefault'] ? ' selected="selected"' : ''));
				$xtpl -> parse('main.loop.adddefault');
			}

			$xtpl -> parse('main.loop');
		}

		$xtpl -> parse('main');
		$contents = $xtpl -> text('main');
	} else {
		$contents = '&nbsp;';
	}

	return $contents;
}

/**
 * nv_fix_age_cat()
 *
 * @return
 *
 */
function nv_fix_age_cat() {
	global $db, $module_data;
	$sql = 'SELECT aid FROM ' . NV_PREFIXLANG . '_' . $module_data . '_age_cat ORDER BY weight ASC';
	$weight = 0;
	$result = $db -> query($sql);
	while ($row = $result -> fetch()) {
		++$weight;
		$sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_age_cat SET weight=' . $weight . ' WHERE aid=' . intval($row['aid']);
		$db -> query($sql);
	}
	$result -> closeCursor();
}



/**
 * redirect()
 *
 * @param string $msg1
 * @param string $msg2
 * @param mixed $nv_redirect
 * @return
 *
 */

function redirect($msg1 = '', $msg2 = '', $nv_redirect, $go_back = '') {
	global $global_config, $module_file, $module_name;
	$xtpl = new XTemplate('redirect.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);

	if (empty($nv_redirect)) {
		$nv_redirect = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name;
	}
	$xtpl -> assign('NV_BASE_SITEURL', NV_BASE_SITEURL);
	$xtpl -> assign('NV_REDIRECT', $nv_redirect);
	$xtpl -> assign('MSG1', $msg1);
	$xtpl -> assign('MSG2', $msg2);

	if ($go_back) {
		$xtpl -> parse('main.go_back');
	} else {
		$xtpl -> parse('main.meta_refresh');
	}

	$xtpl -> parse('main');
	$contents = $xtpl -> text('main');

	include NV_ROOTDIR . '/includes/header.php';
	echo nv_admin_theme($contents);
	include NV_ROOTDIR . '/includes/footer.php';
}


/**
 * nv_show_employee_list()
 *
 * @param integer $parentid
 * @return
 *
 */
function nv_show_employee_list() {
	global $db_slave, $lang_module, $lang_global, $global_array_cat, $module_name, $module_data, $op, $module_file, $global_config, $module_info;

	$sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows ORDER BY sort ASC';
	$_array_block_cat = $db_slave -> query($sql) -> fetchAll();
	$num = sizeof($_array_block_cat);

	if ($num > 0) {
		$by_status = array($lang_global['no'], $lang_global['yes']);
		$xtpl = new XTemplate('employee_list.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
		$xtpl -> assign('LANG', $lang_module);
		$xtpl -> assign('GLANG', $lang_global);

		foreach ($_array_block_cat as $row) {

			$xtpl -> assign('ROW', array(
			'id' => $row['id'],
			'title' => $row['title'],
			'url_edit' => NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=employee&amp;id=' . $row['id'] . '#edit',
			'link' => NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $global_array_cat[$row['catid']]['alias'] . '/' . $row['alias'] . $global_config['rewrite_exturl']
			));
			$xtpl -> assign('CHECKSS', md5($row['id'] . NV_CHECK_SESSION));
			for ($i = 1; $i <= $num; ++$i) {
				$xtpl -> assign('sort', array('key' => $i, 'title' => $i, 'selected' => $i == $row['sort'] ? ' selected="selected"' : ''));
				$xtpl -> parse('main.loop.sort');
			}

			foreach ($by_status as $key => $val) {
				$xtpl -> assign('status', array('key' => $key, 'title' => $val, 'selected' => $key == $row['status'] ? ' selected="selected"' : ''));
				$xtpl -> parse('main.loop.status');
			}
			
			foreach ($by_status as $key => $val) {
				$xtpl -> assign('inhome', array('key' => $key, 'title' => $val, 'selected' => $key == $row['inhome'] ? ' selected="selected"' : ''));
				$xtpl -> parse('main.loop.inhome');
			}
			
			foreach ($by_status as $key => $val) {
				$xtpl -> assign('job_status', array('key' => $key, 'title' => $val, 'selected' => $key == $row['job_status'] ? ' selected="selected"' : ''));
				$xtpl -> parse('main.loop.job_status');
			}

			$xtpl -> parse('main.loop');
		}

		$xtpl -> parse('main');
		$contents = $xtpl -> text('main');
	} else {
		$contents = '<div class="alert alert-info">Chưa có dữ liệu</div>';
	}

	return $contents;
}


/**
 * nv_fix_rows_order()
 *
 * @return
 *
 */
function nv_fix_rows_order() {
	global $db, $module_data;
	$sql = 'SELECT id FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows ORDER BY sort ASC';
	$sort = 0;
	$result = $db -> query($sql);
	while ($row = $result -> fetch()) {
		++$sort;
		$sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_rows SET sort=' . $sort . ' WHERE id=' . intval($row['id']);
		$db -> query($sql);
	}
	$result -> closeCursor();
}



/**
 * nv_del_content_module()
 *
 * @param mixed $id
 * @return
 */
function nv_del_content_module($id)
{
    global $db, $module_name, $module_data, $title, $lang_module;
    $content_del = 'NO_' . $id;
    $title = '';
    list($id, $listcatid, $title, $homeimgfile) = $db->query('SELECT id, listcatid, title, homeimgfile FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows WHERE id=' . intval($id))->fetch(3);
    if ($id > 0) {
        $number_no_del = 0;

        $_sql = 'DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows WHERE id=' . $id;
        if (! $db->exec($_sql)) {
            ++$number_no_del;
        }

        $db->query('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_location_id WHERE id = ' . $id);
        $db->query('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_age WHERE id = ' . $id);
        $db->query('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_salary WHERE id = ' . $id);
        if ($number_no_del == 0) {
            $content_del = 'OK_' . $id;
        } else {
            $content_del = 'ERR_' . $lang_module['error_del_content'];
        }
    }
    return $content_del;
}