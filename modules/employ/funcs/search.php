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

function BoldKeywordInStr($str, $keyword)
{
    $str = nv_clean60($str, 300);
    if (! empty($keyword)) {
        $tmp = explode(' ', $keyword);
        foreach ($tmp as $k) {
            $tp = strtolower($k);
            $str = str_replace($tp, '<span class="keyword">' . $tp . '</span>', $str);
            $tp = strtoupper($k);
            $str = str_replace($tp, '<span class="keyword">' . $tp . '</span>', $str);
            $k[0] = strtoupper($k[0]);
            $str = str_replace($k, '<span class="keyword">' . $k . '</span>', $str);
        }
    }
    return $str;
}

$key = $nv_Request->get_title('q', 'get', '');
$key = str_replace('+', ' ', $key);
$key = trim(nv_substr($key, 0, NV_MAX_SEARCH_LENGTH));
$keyhtml = nv_htmlspecialchars($key);

$base_url_rewrite = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op;
if (! empty($key)) {
    $base_url_rewrite .= '&q=' . $key;
}


$catid = $nv_Request->get_int('catid', 'get', 0);
if (! empty($catid)) {
    $base_url_rewrite .= '&catid=' . $catid;
}

$location_id = $nv_Request->get_int('location_id', 'get', 0);
if (! empty($location_id)) {
    $base_url_rewrite .= '&location_id=' . $location_id;
}

$aid = $nv_Request->get_int('aid', 'get', 0);
if (! empty($aid)) {
    $base_url_rewrite .= '&aid=' . $aid;
}

$sid = $nv_Request->get_int('sid', 'get', 0);
if (! empty($sid)) {
    $base_url_rewrite .= '&sid=' . $sid;
}

$page = $nv_Request->get_int('page', 'get', 1);
if (! empty($page)) {
    $base_url_rewrite .= '&page=' . $page;
}
$base_url_rewrite = nv_url_rewrite($base_url_rewrite, true);

$request_uri = urldecode($_SERVER['REQUEST_URI']);
if ($request_uri != $base_url_rewrite and NV_MAIN_DOMAIN . $request_uri != $base_url_rewrite) {
    header('Location: ' . $base_url_rewrite);
    die();
}

$array_cat_search = array();
foreach ($global_array_cat as $arr_cat_i) {
    $array_cat_search[$arr_cat_i['catid']] = array(
        'catid' => $arr_cat_i['catid'],
        'title' => $arr_cat_i['title'],
        'select' => ($arr_cat_i['catid'] == $catid) ? 'selected="selected"' : ''
    );
}

$array_location_search = array();
foreach ($global_array_location as $arr_location_i) {
    $array_location_search[$arr_location_i['location_id']] = array(
        'location_id' => $arr_location_i['location_id'],
        'title' => $arr_location_i['title'],
        'select' => ($arr_location_i['location_id'] == $location_id) ? 'selected="selected"' : ''
    );
}

$array_age_search = array();
foreach ($global_array_age as $arr_age_i) {
    $array_age_search[$arr_age_i['aid']] = array(
        'aid' => $arr_age_i['aid'],
        'title' => $arr_age_i['title'],
        'select' => ($arr_age_i['aid'] == $aid) ? 'selected="selected"' : ''
    );
}

$array_salary_search = array();
foreach ($global_array_salary as $arr_salary_i) {
    $array_salary_search[$arr_salary_i['sid']] = array(
        'sid' => $arr_salary_i['sid'],
        'title' => $arr_salary_i['title'],
        'select' => ($arr_salary_i['sid'] == $sid) ? 'selected="selected"' : ''
    );
}

$contents = call_user_func('search_theme', $key, $array_salary_search, $array_age_search, $array_location_search, $array_cat_search);
$where = '';
$tbl_src = '';
if ( empty($key) and ($catid == 0) and ($location_id == 0) and ($sid == 0) and ($aid == 0) ) {
    $contents .= '<div class="alert alert-danger">' . $lang_module['empty_data_search'] . '</div>';
} else {
    $canonicalUrl = nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=search&amp;q=' . $key, true);
    if (strpos($canonicalUrl, NV_MY_DOMAIN) !== 0) {
        $canonicalUrl = NV_MY_DOMAIN . $canonicalUrl;
    }

    $dbkey = $db_slave->dblikeescape($key);
    $dbkeyhtml = $db_slave->dblikeescape($keyhtml);
	
	$where .= " AND ( title LIKE '%" . $dbkeyhtml . "%' OR about_family LIKE '%" . $dbkeyhtml . "%' ";
	$where .= " OR about_experience LIKE '%" . $dbkeyhtml . "%' OR about_wish LIKE '%" . $dbkeyhtml . "%')";
	
	$table_search = NV_PREFIXLANG . '_' . $module_data . '_rows';
    if ($catid > 0) {
        $where .= " AND catid =" . $catid;
    }
	
	if ($location_id > 0) {
		$where .= " AND location_id =" . $location_id;
	}

	if ($aid > 0) {
		$where .= " AND (  ( (YEAR(CURDATE()) - birthday) >= " . $global_array_age[$aid]['from_age'] . " AND (YEAR(CURDATE()) - birthday) <= " . $global_array_age[$aid]['to_age'] . ") )";
	}

	if ($sid > 0) {
		$where .= " AND sid =" . $sid . " OR ( about_wish_salary >= " . $global_array_salary[$sid]['from_salary'] . " AND about_wish_salary <= " . $global_array_salary[$sid]['to_salary'] . ")";
	}

    $db_slave->sqlreset()->select('COUNT(*)')->from($table_search)->where(' status=1 ' . $where);

    $numRecord = $db_slave->query($db_slave->sql())->fetchColumn();
    $db_slave->select('id,title,alias,catid,about_experience,addtime,homeimgfile, homeimgthumb')->order('addtime DESC')->limit($per_page)->offset(($page - 1) * $per_page);

    $result = $db_slave->query($db_slave->sql());

    $array_content = array();
    $show_no_image = $module_config[$module_name]['show_no_image'];

    while (list($id, $title, $alias, $catid, $about_experience, $addtime, $homeimgfile, $homeimgthumb) = $result->fetch(3)) {
        if ($homeimgthumb == 1) {
            // image thumb
            $img_src = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload . '/' . $homeimgfile;
        } elseif ($homeimgthumb == 2) {
            // image file
            $img_src = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $homeimgfile;
        } elseif ($homeimgthumb == 3) {
            // image url
            $img_src = $homeimgfile;
        } elseif (! empty($show_no_image)) {
            // no image
            $img_src = NV_BASE_SITEURL . $show_no_image;
        } else {
            $img_src = '';
        }
        $array_content[] = array(
            'id' => $id,
            'title' => $title,
            'alias' => $alias,
            'catid' => $catid,
            'about_experience' => $about_experience,
            'addtime' => $addtime,
            'homeimgfile' => $img_src
        );
    }

    $contents .= search_result_theme($key, $numRecord, $per_page, $page, $array_content, $catid);
}

if (empty($key)) {
    $page_title = $lang_module['search_title'] . ' ' . NV_TITLEBAR_DEFIS . ' ' . $module_info['custom_title'];
} else {
    $page_title = $key . ' ' . NV_TITLEBAR_DEFIS . ' ' . $lang_module['search_title'];
    if ($page > 2) {
        $page_title .= ' ' . NV_TITLEBAR_DEFIS . ' ' . $lang_global['page'] . ' ' . $page;
    }
    $page_title .= ' ' . NV_TITLEBAR_DEFIS . ' ' . $module_info['custom_title'];
}

$key_words = $description = 'no';
$mod_title = isset($lang_module['main_title']) ? $lang_module['main_title'] : $module_info['custom_title'];

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';