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

/**
 * ThemeEmployMain()
 * 
 * @param mixed $dataContent
 * @return
 */
function ThemeEmployMain ( $viewcat, $dataContent, $generate_page )
{
    global $global_config, $module_name, $module_file, $lang_module, $module_config, $module_info, $op;

    $xtpl = new XTemplate( $viewcat . '.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file );
    $xtpl->assign( 'LANG', $lang_module );

    foreach($dataContent as $data_content){
		$xtpl->assign( 'MAIN', $data_content );
			if (defined('NV_IS_MODADMIN')) {
				$xtpl->assign('ADMINLINK', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=employee&amp;id=' . $data_content['id'] . '#edit');
				$xtpl->parse('main.loop.adminlink');
			}
		$xtpl->parse( 'main.loop' );
	}

	if( !empty($generate_page)){
		$xtpl->assign( 'GENERATE_PAGE', $generate_page );
		$xtpl->parse( 'main.generate_page' );
	}
    $xtpl->parse( 'main' );
    return $xtpl->text( 'main' );
}

/**
 * ThemeEmployCat()
 * 
 * @param mixed $dataContent
 * @return
 */
function ThemeEmployCat ( $viewcat, $dataContent, $generate_page )
{
    global $global_config, $module_name, $module_file, $lang_module, $module_config, $module_info, $op;

    $xtpl = new XTemplate( $viewcat . '.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file );
    $xtpl->assign( 'LANG', $lang_module );

    foreach($dataContent as $data_content){
		$xtpl->assign( 'MAIN', $data_content );
			if (defined('NV_IS_MODADMIN')) {
				$xtpl->assign('ADMINLINK', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=employee&amp;id=' . $data_content['id'] . '#edit');
				$xtpl->parse('main.loop.adminlink');
			}
		$xtpl->parse( 'main.loop' );
	}

	if( !empty($generate_page)){
		$xtpl->assign( 'GENERATE_PAGE', $generate_page );
		$xtpl->parse( 'main.generate_page' );
	}
    $xtpl->parse( 'main' );
    return $xtpl->text( 'main' );
}

/**
 * ThemeEmployDetail()
 * 
 * @param mixed $dataContent
 * @return
 */
function ThemeEmployDetail ( $dataContent, $related_array )
{
    global $global_config, $module_name, $module_file, $lang_module, $module_config, $module_info, $op;

    $xtpl = new XTemplate( $op . '.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file );
    $xtpl->assign( 'LANG', $lang_module );
    $xtpl->assign( 'DETAIL', $dataContent );
	
	if( !empty($related_array) ){
		foreach( $related_array as $related_array_i){
			$xtpl->assign( 'RELATED', $related_array_i );
			if (defined('NV_IS_MODADMIN')) {
				$xtpl->assign('ADMINLINK', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=employee&amp;id=' . $related_array_i['id'] . '#edit');
				$xtpl->parse('main.related.loop.adminlink');
			}
			$xtpl->parse('main.related.loop');
		}
		$xtpl->parse('main.related');
	}
	
	if (defined('NV_IS_MODADMIN')) {
		$xtpl->assign('ADMINLINK', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=employee&amp;id=' . $dataContent['id'] . '#edit');
		$xtpl->parse('main.adminlink');
	}

    $xtpl->parse( 'main' );
    return $xtpl->text( 'main' );
}

function sendcontact_theme( $sendmail )
{
	global $op, $module_info, $module_file, $module_config, $module_name, $lang_module, $lang_global;

	$xtpl = new XTemplate( 'request.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file );
	$xtpl->assign( 'SENDMAIL', $sendmail );
	$xtpl->assign( 'LANG', $lang_module );
	$xtpl->assign( 'NV_BASE_SITEURL', NV_BASE_SITEURL );
	$xtpl->assign( 'GFX_NUM', NV_GFX_NUM );

	if( $module_config[$module_name]['captcha'] > 0 )
	{
		$xtpl->assign( 'CAPTCHA_REFRESH', $lang_global['captcharefresh'] );
		$xtpl->assign( 'CAPTCHA_REFR_SRC', NV_BASE_SITEURL . NV_FILES_DIR . '/images/refresh.png' );
		$xtpl->assign( 'N_CAPTCHA', $lang_global['securitycode'] );
		$xtpl->assign( 'GFX_WIDTH', NV_GFX_WIDTH );
		$xtpl->assign( 'GFX_HEIGHT', NV_GFX_HEIGHT );
		$xtpl->parse( 'main.content.captcha' );
	}

	$xtpl->parse( 'main.content' );

	if( ! empty( $sendmail['result'] ) )
	{
		$xtpl->assign( 'RESULT', $sendmail['result'] );
		if( $sendmail['result']['check'] == true )
		{
			$xtpl->parse( 'main.result.return' );
		}
		$xtpl->parse( 'main.result' );
	}else{
		
	}

	$xtpl->parse( 'main' );
	return $xtpl->text( 'main' );
}

// Search
function search_theme($key, $array_salary_search, $array_age_search, $array_location_search, $array_cat_search)
{
    global $module_name, $module_info, $module_file, $lang_module, $module_name;

    $xtpl = new XTemplate('search.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('NV_LANG_VARIABLE', NV_LANG_VARIABLE);
    $xtpl->assign('NV_LANG_DATA', NV_LANG_DATA);
    $xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
    $xtpl->assign('MODULE_NAME', $module_name);
    $xtpl->assign('BASE_URL_SITE', NV_BASE_SITEURL . 'index.php');
    $xtpl->assign('KEY', $key);
    $xtpl->assign('NV_OP_VARIABLE', NV_OP_VARIABLE);
    $xtpl->assign('OP_NAME', 'search');

    foreach ($array_cat_search as $search_cat) {
        $xtpl->assign('SEARCH_CAT', $search_cat);
        $xtpl->parse('main.search_cat');
    }
	
    foreach ($array_location_search as $search_location) {
        $xtpl->assign('SEARCH_LOCATION', $search_location);
        $xtpl->parse('main.search_location');
    }
	
    foreach ($array_age_search as $search_age) {
        $xtpl->assign('SEARCH_AGE', $search_age);
        $xtpl->parse('main.search_age');
    }

    foreach ($array_salary_search as $search_salary) {
        $xtpl->assign('SEARCH_SALARY', $search_salary);
        $xtpl->parse('main.search_salary');
    }

    $xtpl->parse('main');
    return $xtpl->text('main');
}

function search_result_theme($key, $numRecord, $per_pages, $page, $array_content, $catid)
{
    global $module_file, $module_info, $lang_module, $module_name, $global_array_cat, $module_config, $global_config;

    $xtpl = new XTemplate('search.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('KEY', $key);
    $xtpl->assign('TITLE_MOD', $lang_module['search_modul_title']);

    if (! empty($array_content)) {
        foreach ($array_content as $value) {
            $catid_i = $value['catid'];

            $xtpl->assign('LINK', $global_array_cat[$catid_i]['link'] . '/' . $value['alias'] . $global_config['rewrite_exturl']);
            $xtpl->assign('TITLEROW', strip_tags(BoldKeywordInStr($value['title'], $key)));
            $xtpl->assign('CONTENT', BoldKeywordInStr($value['about_experience'], $key) . "...");

            if (! empty($value['homeimgfile'])) {
                $xtpl->assign('IMG_SRC', $value['homeimgfile']);
                $xtpl->parse('results.result.result_img');
            }

            $xtpl->parse('results.result');
        }
    }

    if ($numRecord == 0) {
        $xtpl->assign('KEY', $key);
        $xtpl->assign('INMOD', $lang_module['search_modul_title']);
        $xtpl->parse('results.noneresult');
    }

    if ($numRecord > $per_pages) {
		// show pages
        $url_link = $_SERVER['REQUEST_URI'];
        if (strpos($url_link, '&page=') > 0) {
            $url_link = substr($url_link, 0, strpos($url_link, '&page='));
        } elseif (strpos($url_link, '?page=') > 0) {
            $url_link = substr($url_link, 0, strpos($url_link, '?page='));
        }
        $_array_url = array( 'link' => $url_link, 'amp' => '&page=' );
        $generate_page = nv_generate_page($_array_url, $numRecord, $per_pages, $page);

        $xtpl->assign('VIEW_PAGES', $generate_page);
        $xtpl->parse('results.pages_result');
    }

    $xtpl->assign('NUMRECORD', $numRecord);
    $xtpl->assign('MY_DOMAIN', NV_MY_DOMAIN);

    $xtpl->parse('results');
    return $xtpl->text('results');
}
/**
 * redirect_link()
 *
 * @param mixed $lang_view
 * @param mixed $lang_back
 * @param mixed $nv_redirect
 * @return
 */
function redirect_link($lang_view, $lang_back, $nv_redirect)
{
    $contents = "<div class=\"alert alert-warning center-block\" align=\"center\">";
    $contents .= $lang_view . "<br /><br />\n";
    $contents .= "<img border=\"0\" src=\"" . NV_BASE_SITEURL . NV_ASSETS_DIR . "/images/load_bar.gif\"><br /><br />\n";
    $contents .= "<a href=\"" . $nv_redirect . "\">" . $lang_back . "</a>";
    $contents .= "</div>";
    $contents .= "<meta http-equiv=\"refresh\" content=\"4;url=" . $nv_redirect . "\" />";
    include NV_ROOTDIR . '/includes/header.php';
    echo nv_site_theme($contents);
    include NV_ROOTDIR . '/includes/footer.php';
    exit();
}