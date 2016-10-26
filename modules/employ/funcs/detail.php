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

$data_content = array();

// Thiet lap quyen xem chi tiet
$contents = '';
$publtime = 0;

$sql = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows WHERE alias = ' . $db->quote($alias_url) . ' AND status=1');
$data_content = $sql->fetch();
if (empty($data_content)) {
    $nv_redirect = nv_url_rewrite (NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name, true);
    redirect_link($lang_module['detail_not_available'], $lang_module['redirect_to_module'], $nv_redirect);
}
$id = $data_content['id'];

if (! empty($data_content['homeimgfile'])) {
	$src = $alt = $note = '';
	if ($data_content['homeimgthumb'] == 1) {
		$src = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload . '/' . $data_content['homeimgfile'];
		$data_content['homeimgfile'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $data_content['homeimgfile'];
	} elseif (file_exists(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . $data_content['homeimgfile'])) {
		$src = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $data_content['homeimgfile'];
		$data_content['homeimgfile'] = $src;
	}

	if (! empty($src)) {
		$meta_property['og:image'] = (preg_match('/^(http|https|ftp|gopher)\:\/\//', $src)) ? $src : NV_MY_DOMAIN . $src;
	} elseif (!empty($show_no_image)) {
		$meta_property['og:image'] = NV_MY_DOMAIN . NV_BASE_SITEURL . $show_no_image;
	}
} elseif (! empty($show_no_image)) {
	$meta_property['og:image'] = NV_MY_DOMAIN . NV_BASE_SITEURL . $show_no_image;
}
// Que quan
$data_content['location'] = $global_array_location[$data_content['location_id']]['title'];

// Gioi tinh
if($data_content['sex'] == 1){
	$data_content['sex'] = $lang_module['female'];
}elseif($data_content['sex'] == 2){
	$data_content['sex'] = $lang_module['male'];
}elseif($data_content['sex'] == 3){
	$data_content['sex'] = $lang_module['sex_na'];
}
// San sang nhan viec
if($data_content['job_status'] == 1){
	$data_content['job_status'] = $lang_global['yes'];
}else{
	$data_content['job_status'] = $lang_global['no'];
}

$data_content['request_link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=request/' . $global_array_cat[$data_content['catid']]['alias'] . '/' . $data_content['alias'] . $global_config['rewrite_exturl'];

$db_slave->sqlreset()
	->select('*')
	->from(NV_PREFIXLANG . '_' . $module_data . '_rows')
	->where('status=1 AND id <> ' . $data_content['id'])
	->order('addtime ASC')
	->limit(12);

$related = $db_slave->query($db_slave->sql());
	while ($row = $related->fetch()) {
	if (! empty($row['homeimgfile'])) {
		$src = $alt = $note = '';
		if ($row['homeimgthumb'] == 1) {
			$src = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload . '/' . $row['homeimgfile'];
			$row['homeimgfile'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $row['homeimgfile'];
		} elseif (file_exists(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . $row['homeimgfile'])) {
			$src = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $row['homeimgfile'];
			$row['homeimgfile'] = $src;
		}

		if (! empty($src)) {
			$meta_property['og:image'] = (preg_match('/^(http|https|ftp|gopher)\:\/\//', $src)) ? $src : NV_MY_DOMAIN . $src;
		} elseif (!empty($show_no_image)) {
			$meta_property['og:image'] = NV_MY_DOMAIN . NV_BASE_SITEURL . $show_no_image;
		}
	} elseif (! empty($show_no_image)) {
		$meta_property['og:image'] = NV_MY_DOMAIN . NV_BASE_SITEURL . $show_no_image;
	}
	// Que quan
	$row['location'] = $global_array_location[$row['location_id']]['title'];
	// Gioi tinh
	if($row['sex'] == 1){
		$row['sex'] = $lang_module['female'];
	}elseif($row['sex'] == 2){
		$row['sex'] = $lang_module['male'];
	}elseif($row['sex'] == 3){
		$row['sex'] = $lang_module['sex_na'];
	}
	// San sang nhan viec
	if($row['job_status'] == 1){
		$row['job_status'] = $lang_global['yes'];
	}else{
		$row['job_status'] = $lang_global['no'];
	}

	$link = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $global_array_cat[$catid]['alias'] . '/' . $row['alias'] . $global_config['rewrite_exturl'];
	$row['request_link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=request/' . $global_array_cat[$row['catid']]['alias'] . '/' . $row['alias'] . $global_config['rewrite_exturl'];

	$related_array[] = array(
		'id' => $row['id'],
		'title' => $row['title'],
		'addtime' => $row['addtime'],
		'birthday' => $row['birthday'],
		'location' => $row['location'],
		'job_status' => $row['job_status'],
		'link' => $link,
		'about_experience' => $row['about_experience'],
		'sex' => $row['sex'],
		'request_link' => $row['request_link'],
		'homeimgfile' => $row['homeimgfile']
	);
}

$related->closeCursor();
unset($related, $row);


$page_title = $data_content['title'];
$description = $data_content['about_family'];
$contents = ThemeEmployDetail( $data_content, $related_array);

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme( $contents );
include NV_ROOTDIR . '/includes/footer.php';
