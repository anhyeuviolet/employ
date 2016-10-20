<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC.
 * All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 3/9/2010 23:25
 */
if (! defined('NV_MAINFILE')) {
    die('Stop!!!');
}

if (! nv_function_exists('nv_news_block_top_employ')) {

    function nv_block_config_top_news_employ($module, $data_block, $lang_block)
    {
        global $nv_Cache, $site_mods;
        $html = '';
		
        $html .= '<tr>';
        $html .= '	<td>' . $lang_block['numrow'] . '</td>';
        $html .= '	<td><input type="text" name="config_numrow" class="form-control w100" size="5" value="' . $data_block['numrow'] . '"/></td>';
        $html .= '</tr>';
		
        $html .= '<tr>';
        $html .= '	<td>' . $lang_block['duration'] . '</td>';
        $html .= '	<td><input type="text" name="config_duration" class="form-control w100" size="5" value="' . $data_block['duration'] . '"/></td>';
        $html .= '</tr>';
		
		$html .= "<tr>";
		$html .= "<td>". $lang_block['direction'] ."</td>";
		$html .= "<td>";
		$sorting_array = array( 'left' => $lang_block['left'], 'right' => $lang_block['right']);
		$html .= '<select name="config_direction">';
		foreach( $sorting_array as $key => $value )
		{
			$html .= '<option value="' . $key . '" ' . ( $data_block['direction'] == $key ? 'selected="selected"' : '') . '>' . $value . '</option>';
		}
		$html .= '</select>';
		$html .= "</td";
		$html .= "	</tr>";
		
        $html .= '<tr>';
        $html .= '<td>' . $lang_block['nocatid'] . '</td>';
        $sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $site_mods[$module]['module_data'] . '_cat ORDER BY sort ASC';
        $list = $nv_Cache->db($sql, '', $module);
        $html .= '<td>';
        $html .= '<div style="height: 200px; overflow: auto">';
        if (! is_array($data_block['nocatid'])) {
            $data_block['nocatid'] = explode(',', $data_block['nocatid']);
        }
        foreach ($list as $l) {
            $xtitle_i = '';
            
            if ($l['lev'] > 0) {
                for ($i = 1; $i <= $l['lev']; ++ $i) {
                    $xtitle_i .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                }
            }
            $html .= $xtitle_i . '<label><input type="checkbox" name="config_nocatid[]" value="' . $l['catid'] . '" ' . ((in_array($l['catid'], $data_block['nocatid'])) ? ' checked="checked"' : '') . '</input>' . $l['title'] . '</label><br />';
        }
        $html .= '</div>';
        $html .= '</td>';
        $html .= '</tr>';
		
		$html .= '<tr>';
		$html .= '<td>' . $lang_block['pauseOnHover'] . '</td>';
        $html .= '<td>';
        $html .= '<input type="checkbox" value="1" name="config_pauseOnHover" ' . ($data_block['pauseOnHover'] == 1 ? 'checked="checked"' : '') . ' /><br /><br />';
        $html .= '</td>';
        $html .= '</tr>';
        
        return $html;
    }

    function nv_block_config_top_news_employ_submit($module, $lang_block)
    {
        global $nv_Request;
        $return = array();
        $return['error'] = array();
        $return['config'] = array();
        $return['config']['numrow'] = $nv_Request->get_int('config_numrow', 'post', 0);
        $return['config']['duration'] = $nv_Request->get_int('config_duration', 'post', 0);
        $return['config']['direction'] = $nv_Request->get_title('config_direction', 'post', 0);
        $return['config']['pauseOnHover'] = $nv_Request->get_int('config_pauseOnHover', 'post', 0);
        $return['config']['nocatid'] = $nv_Request->get_typed_array('config_nocatid', 'post', 'int', array());
        return $return;
    }

    function nv_news_block_top_employ($block_config, $mod_data)
    {
        global $module_array_cat, $site_mods, $module_info, $db_slave, $module_config, $global_config, $blockID;
        
        $module = $block_config['module'];
        $mod_file = $site_mods[$module]['module_file'];
        
        $show_no_image = $module_config[$module]['show_no_image'];
		if(empty($block_config['numrow'])){
			$block_config['numrow'] = 10;
		}
		
		if(empty($block_config['duration'])){
			$block_config['duration'] = 1000;
		}
		
		if(empty($block_config['direction'])){
			$block_config['direction'] = 'left';
		}
        
        $array_block_news = array();
        $db_slave->sqlreset()
            ->select('id, catid, addtime, title, alias, homeimgthumb, homeimgfile')
            ->from(NV_PREFIXLANG . '_' . $mod_data . '_rows')
            ->order('addtime DESC')
            ->limit($block_config['numrow']);
        if (empty($block_config['nocatid'])) {
            $db_slave->where('status= 1');
        } else {
            $db_slave->where('status= 1 AND catid NOT IN (' . implode(',', $block_config['nocatid']) . ')');
        }
        
        $result = $db_slave->query($db_slave->sql());
        while (list ($id, $catid, $addtime, $title, $alias, $homeimgthumb, $homeimgfile) = $result->fetch(3)) {
            if ($homeimgthumb == 1) {
                // image thumb
                
                $imgurl = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $site_mods[$module]['module_upload'] . '/' . $homeimgfile;
            } elseif ($homeimgthumb == 2) {
                // image file
                
                $imgurl = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $site_mods[$module]['module_upload'] . '/' . $homeimgfile;
            } elseif ($homeimgthumb == 3) {
                // image url
                
                $imgurl = $homeimgfile;
            } elseif (! empty($show_no_image)) {
                // no image
                
                $imgurl = NV_BASE_SITEURL . $show_no_image;
            } else {
                $imgurl = '';
            }
            $link = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module . '&amp;' . NV_OP_VARIABLE . '=' . $module_array_cat[$catid]['alias'] . '/' . $alias . '-' . $id . $global_config['rewrite_exturl'];
            
            $array_block_news[] = array(
                'id' => $id,
                'title' => $title,
                'link' => $link,
                'imgurl' => $imgurl
            );
        }
        
        if (file_exists(NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $mod_file . '/block_top_news.tpl')) {
            $block_theme = $global_config['module_theme'];
        } else {
            $block_theme = 'default';
        }
        
        $xtpl = new XTemplate('block_top_news.tpl', NV_ROOTDIR . '/themes/' . $block_theme . '/modules/' . $mod_file);
        $xtpl->assign('NV_BASE_SITEURL', NV_BASE_SITEURL);
        $xtpl->assign('TEMPLATE', $block_theme);
        $xtpl->assign('BLOCKID', $blockID);
		
        $xtpl->assign('duration', $block_config['duration']);
        $xtpl->assign('direction', $block_config['direction']);
		
        $xtpl->assign('pauseOnHover', 'false');
		if( $block_config['pauseOnHover'] == 1 ){
			$xtpl->assign('pauseOnHover', 'true');
		}
        
        foreach ($array_block_news as $array_news) {
            $xtpl->assign('blocknews', $array_news);
            $xtpl->parse('main.newloop');
        }
	if (!defined('MARQUEE_CSS')) {
		define('MARQUEE_CSS', true);
		 $xtpl->parse('main.marquee_css');
	}
        $xtpl->parse('main');
        return $xtpl->text('main');
    }
}

if (defined('NV_SYSTEM')) {
    global $nv_Cache, $site_mods, $module_name, $global_array_cat, $module_array_cat;
    $module = $block_config['module'];
    if (isset($site_mods[$module])) {
        $mod_data = $site_mods[$module]['module_data'];
        if ($module == $module_name) {
            $module_array_cat = $global_array_cat;
            unset($module_array_cat[0]);
        } else {
            $module_array_cat = array();
            $sql = 'SELECT catid, parentid, title, alias, viewcat, subcatid, numlinks, description, groups_view FROM ' . NV_PREFIXLANG . '_' . $mod_data . '_cat ORDER BY sort ASC';
            $list = $nv_Cache->db($sql, 'catid', $module);
            if (! empty($list)) {
                foreach ($list as $l) {
                    $module_array_cat[$l['catid']] = $l;
                    $module_array_cat[$l['catid']]['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module . '&amp;' . NV_OP_VARIABLE . '=' . $l['alias'];
                }
            }
        }
        $content = nv_news_block_top_employ($block_config, $mod_data);
    }
}
