<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES., JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 3/9/2010 23:25
 */

if (! defined('NV_MAINFILE')) {
    die('Stop!!!');
}

if (! function_exists('nv_employ_search')) {
    /**
     * nv_employ_search()
     *
     * @param mixed $block_config
     * @return
     */
    function nv_employ_search($block_config)
    {
        global $nv_Cache, $site_mods, $my_head, $db_config, $module_name, $module_info, $nv_Request, $catid, $module_config;

        $module = $block_config['module'];
        $mod_data = $site_mods[$module]['module_data'];
        $mod_file = $site_mods[$module]['module_file'];
        $pro_config = $module_config[$module];

        include NV_ROOTDIR . '/modules/' . $mod_file . '/language/' . NV_LANG_DATA . '.php';

        $keyword = $nv_Request->get_string('keyword', 'get');
        $location_id = $nv_Request->get_int('location_id', 'get', '');
        $sid = $nv_Request->get_int('sid', 'get', '');
        $aid = $nv_Request->get_int('aid', 'get', '');
        $cataid = $nv_Request->get_int('cata', 'get', 0);

        if (file_exists(NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $mod_file . '/block.quick_search.tpl')) {
            $block_theme = $module_info['template'];
        } else {
            $block_theme = 'default';
        }

        if ($module != $module_name) {
            $my_head .= '<script type="text/javascript" src="' . NV_BASE_SITEURL . '/themes/' . $block_theme . '/' . 'js/' . $mod_file . '.js"></script>';
        }

        $xtpl = new XTemplate('block.quick_search.tpl', NV_ROOTDIR . '/themes/' . $block_theme . '/modules/' . $mod_file);
        $xtpl->assign('LANG', $lang_module);
        $xtpl->assign('NV_BASE_SITEURL', NV_BASE_SITEURL);
        $xtpl->assign('MODULE_NAME', $module);

        $sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $mod_data . '_cat ORDER BY sort ASC';
        $list = $nv_Cache->db($sql, '', $module);
        foreach ($list as $row) {
            $xtitle_i = '';
            if ($row['lev'] > 0) {
                $xtitle_i .= '&nbsp;&nbsp;&nbsp;';
                for ($i = 1; $i <= $row['lev']; $i++) {
                    $xtitle_i .= '&nbsp;&nbsp;&nbsp;';
                }
                $xtitle_i .= '&nbsp;';
            }
            $row['xtitle'] = $xtitle_i . $row['title'];
            $row['selected'] = ($cataid == $row['catid']) ? 'selected="selected"' : '';
            $xtpl->assign('ROW', $row);
            $xtpl->parse('main.loopcata');
        }

        $sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $mod_data . '_location ORDER BY weight ASC';
        $list = $nv_Cache->db($sql, '', $module);
        foreach ($list as $row) {
            $row['xtitle'] = $row['title'];
            $row['selected'] = ($location_id == $row['location_id']) ? 'selected="selected"' : '';
            $xtpl->assign('ROW', $row);
            $xtpl->parse('main.location');
        }

        $sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $mod_data . '_salary_cat ORDER BY weight ASC';
        $list = $nv_Cache->db($sql, '', $module);
        foreach ($list as $row) {
            $row['xtitle'] = $row['title'];
            $row['selected'] = ($sid == $row['sid']) ? 'selected="selected"' : '';
            $xtpl->assign('ROW', $row);
            $xtpl->parse('main.salary');
        }

        $sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $mod_data . '_age_cat ORDER BY weight ASC';
        $list = $nv_Cache->db($sql, '', $module);
        foreach ($list as $row) {
            $row['xtitle'] = $row['title'];
            $row['selected'] = ($aid == $row['aid']) ? 'selected="selected"' : '';
            $xtpl->assign('ROW', $row);
            $xtpl->parse('main.age');
        }

        $xtpl->assign('value_keyword', $keyword);
        $xtpl->parse('main');
        return $xtpl->text('main');
    }
}

if (defined('NV_SYSTEM')) {
    $content = nv_employ_search($block_config);
}
