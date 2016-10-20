<?php

/**
 * @Project NUKEVIET 4.x
 * @Author KennyNguyen (nguyentiendat713@gmail.com)
 * @Copyright (C) 2016 KennyNguyen .All rights reserved
 * @Website support https://www.nuke.vn
 * @License GNU/GPL version 2 or any later version
 * @Createdate Thu, 22 Sep 2016 13:09:49 GMT
 */

if ( ! defined( 'NV_IS_MOD_EMPLOY' ) ) die( 'Stop!!!' );


$page_title = $module_info['custom_title'];
$key_words = $module_info['keywords'];

$contents = '';
$cache_file = '';

$base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name;
$base_url_rewrite = nv_url_rewrite($base_url, true);
$page_url_rewrite = ($page > 1) ? nv_url_rewrite($base_url . '/page-' . $page, true) : $base_url_rewrite;
$request_uri = $_SERVER['REQUEST_URI'];
if (! ($home or $request_uri == $base_url_rewrite or $request_uri == $page_url_rewrite or NV_MAIN_DOMAIN . $request_uri == $base_url_rewrite or NV_MAIN_DOMAIN . $request_uri == $page_url_rewrite)) {
    $redirect = '<meta http-equiv="Refresh" content="3;URL=' . $base_url_rewrite . '" />';
    nv_info_die($lang_global['error_404_title'], $lang_global['error_404_title'], $lang_global['error_404_content'] . $redirect, 404);
}
if (! defined('NV_IS_MODADMIN') and $page < 5) {
    $cache_file = NV_LANG_DATA . '_' . $module_info['template'] . '-' . $op . '-' . $page . '-' . NV_CACHE_PREFIX . '.cache';
    if (($cache = $nv_Cache->getItem($module_name, $cache_file)) != false) {
        $contents = $cache;
    }
}

if (empty($contents)) {
    $array_catpage = array();
    $viewcat = $module_config[$module_name]['viewhome'];
	if($viewcat == 'viewcat_none'){
		$contents = '';
	}
    elseif ($viewcat == 'viewcat_page_new' or $viewcat == 'viewcat_page_old') {
		$order_by = ($viewcat == 'viewcat_page_new') ? 'addtime DESC' : 'addtime ASC';
		$db_slave->sqlreset()
			->select('COUNT(*)')
			->from(NV_PREFIXLANG . '_' . $module_data . '_rows')
			->where('status= 1 AND inhome=1');

		$num_items = $db_slave->query($db_slave->sql())->fetchColumn();

		$db_slave->select('id, catid, listcatid, admin_id, author, addtime, edittime, title, alias, homeimgfile, homeimgalt, homeimgthumb, hitstotal, birthday, about_experience, job_status, location_id')
			->order($order_by)
			->limit($per_page)
			->offset(($page - 1) * $per_page);

		$end_publtime = 0;

		$result = $db_slave->query($db_slave->sql());
		while ($item = $result->fetch()) {
			if ($item['homeimgthumb'] == 1) {
				//image thumb
				$item['imghome'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $item['homeimgfile'];
			} elseif ($item['homeimgthumb'] == 2) {
				//image file
				$item['imghome'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $item['homeimgfile'];
			} elseif ($item['homeimgthumb'] == 3) {
				//image url
				$item['imghome'] = $item['homeimgfile'];
			} elseif (! empty($show_no_image)) {
				//no image
				$item['imghome'] = NV_BASE_SITEURL . $show_no_image;
			} else {
				$item['imghome'] = '';
			}
			
			$item['request_link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=request/' . $global_array_cat[$item['catid']]['alias'] . '/' . $item['alias'] . $global_config['rewrite_exturl'];

			$item['link'] = $global_array_cat[$item['catid']]['link'] . '/' . $item['alias'] . $global_config['rewrite_exturl'];
			$item['location'] = $global_array_location[$item['location_id']]['title'];
			if($item['job_status'] == 1){
				$item['job_status'] = $lang_module['job_status_' . $item['job_status']];
			}else{
				$item['job_status'] = $lang_module['job_status_0'];
			}
			
			$array_catpage[] = $item;
		}

		$viewcat = 'viewcat_page';
		$generate_page = nv_alias_page($page_title, $base_url, $num_items, $per_page, $page);
		$contents = ThemeEmployMain($viewcat, $array_catpage, $generate_page);

		if (! defined('NV_IS_MODADMIN') and $contents != '' and $cache_file != '') {
			$nv_Cache->setItem($module_name, $cache_file, $contents);
		}
	}elseif ($viewcat == 'viewcat_grid_new' or $viewcat == 'viewcat_grid_old') {
		$order_by = ($viewcat == 'viewcat_grid_new') ? 'addtime DESC' : 'addtime ASC';
		$db_slave->sqlreset()
			->select('COUNT(*)')
			->from(NV_PREFIXLANG . '_' . $module_data . '_rows')
			->where('status= 1 AND inhome=1');

		$num_items = $db_slave->query($db_slave->sql())->fetchColumn();

		$db_slave->select('id, catid, listcatid, admin_id, author, addtime, edittime, title, alias, homeimgfile, homeimgalt, homeimgthumb, hitstotal, birthday, about_experience, job_status, location_id')
			->order($order_by)
			->limit($per_page)
			->offset(($page - 1) * $per_page);

		$end_publtime = 0;

		$result = $db_slave->query($db_slave->sql());
		while ($item = $result->fetch()) {
			if ($item['homeimgthumb'] == 1) {
				//image thumb
				$item['imghome'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $item['homeimgfile'];
			} elseif ($item['homeimgthumb'] == 2) {
				//image file
				$item['imghome'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $item['homeimgfile'];
			} elseif ($item['homeimgthumb'] == 3) {
				//image url
				$item['imghome'] = $item['homeimgfile'];
			} elseif (! empty($show_no_image)) {
				//no image
				$item['imghome'] = NV_BASE_SITEURL . $show_no_image;
			} else {
				$item['imghome'] = '';
			}
			
			$item['request_link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=request/' . $global_array_cat[$item['catid']]['alias'] . '/' . $item['alias'] . $global_config['rewrite_exturl'];

			$item['link'] = $global_array_cat[$item['catid']]['link'] . '/' . $item['alias'] . $global_config['rewrite_exturl'];
			$item['location'] = $global_array_location[$item['location_id']]['title'];
			if($item['job_status'] == 1){
				$item['job_status'] = $lang_module['job_status_' . $item['job_status']];
			}else{
				$item['job_status'] = $lang_module['job_status_0'];
			}
			
			$array_catpage[] = $item;
		}
		$viewcat = 'viewcat_grid';
		$generate_page = nv_alias_page($page_title, $base_url, $num_items, $per_page, $page);
		$contents = ThemeEmployMain($viewcat, $array_catpage, $generate_page);

		if (! defined('NV_IS_MODADMIN') and $contents != '' and $cache_file != '') {
			$nv_Cache->setItem($module_name, $cache_file, $contents);
		}
	}
}

if ($page > 1) {
    $page_title .= ' ' . NV_TITLEBAR_DEFIS . ' ' . $lang_global['page'] . ' ' . $page;
}

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme( $contents );
include NV_ROOTDIR . '/includes/footer.php';
