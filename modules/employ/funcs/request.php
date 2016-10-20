<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 3-6-2010 0:14
 */

if( ! defined( 'NV_IS_MOD_EMPLOY' ) ) die( 'Stop!!!' );

$full = false;

if( !empty($array_op[1])){
	$alias_cat_url = $array_op[1];
	$array_page = explode( '-', $array_op[2] );
	$alias = $array_op[2];
	$catid = 0;
	foreach( $global_array_cat as $catid_i => $array_cat_i )
	{
		if( $alias_cat_url == $array_cat_i['alias'] )
		{
			$catid = $catid_i;
			break;
		}
	}

	if( !empty($alias) and $catid > 0 )
	{
		$sql = 'SELECT id, title, alias FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows WHERE alias =' . $db->quote($alias) . ' AND status=1';
		$result = $db->query( $sql );
		list( $id, $title, $alias ) = $result->fetch( 3 );

		$page_title = $title;

		$array_mod_title[] = array(
			'catid' => 0,
			'title' => $page_title,
			'link' => $global_array_cat[$catid]['link'] . '/' . $alias . $global_config['rewrite_exturl']
		);
		if( $id > 0 )
		{
			$allowed_send = 1;
			if( $allowed_send == 1 )
			{
				unset( $sql, $result );
				$result = '';
				$check = false;
				$checkss = $nv_Request->get_string( 'checkss', 'post', '' );
				
				$cus_name = $nv_Request->get_title( 'cus_name', 'post', '' );
				$cus_email = $nv_Request->get_title( 'cus_email', 'post', '' );
				$cus_phone = $nv_Request->get_title( 'cus_phone', 'post', '' );
				$cus_company = $nv_Request->get_title( 'cus_company', 'post', '' );
				$cus_address = $nv_Request->get_title( 'cus_address', 'post', '' );
				$to_mail = $module_config[$module_name]['sale_email'];
				$content = '';
				if( $checkss == md5( $id . session_id() . $global_config['sitekey'] ) and $allowed_send == 1 )
				{
					$link = nv_url_rewrite( NV_MY_DOMAIN . NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $global_array_cat[$catid]['alias'] . '/' . $alias . $global_config['rewrite_exturl'], true );
					$link = "<a href=\"$link\" title=\"$title\">$link</a>\n";
					$link_back = nv_url_rewrite( NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $global_array_cat[$catid]['alias'] . '/' . $alias . $global_config['rewrite_exturl'], true );
					$nv_seccode = $nv_Request->get_title( 'nv_seccode', 'post', '' );
					$full = true;
					$content = $nv_Request->get_title( 'content', 'post', '', 1 );
					$err_youremail = nv_check_valid_email( $cus_email );
					$err_name = $err_email = '';
					$message = '';
					$success = '';
					if( $module_config[$module_name]['captcha'] > 0 and ! nv_capcha_txt( $nv_seccode ) )
					{
						$err_name = $lang_global['securitycodeincorrect'];
					}
					elseif( empty( $cus_name ) )
					{
						$err_name = $lang_module['sendmail_err_name'];
					}
					elseif( empty( $err_youremail ) and empty( $err_name ) )
					{
						$subject = $lang_module['sendmail_subject'] . $cus_name . ' ' . $cus_phone;
						
						$message .= '<h2><strong>Chọn người giúp việc:' . $title . '</strong></h2><br />';
						
						$message .= '----------------------------------------------------<br /><br /><br />';
						$message .=  $content . '<br />';
						$message .= '--------------------<br />';
						$message .= '<strong>' . $lang_module['request_welcome2'] . '</strong>';
						$message .= '<br />' . $link . '<br />';
						
						$message .= '----------------------------------------------------<br />';
						$message .= '<h2><strong>' . $lang_module['cus_info'] . '</strong></h2><br />';
						$message .= '----------------------------------------------------<br />';
						
						$message .= $lang_module['cus_name'] . '<strong>' . $cus_name . '</strong><br />';
						$message .=  $lang_module['cus_email'] .  $cus_email . '<br />';
						if($cus_phone)
						{
							$message .= $lang_module['cus_phone'] . '<strong>' . $cus_phone . '</strong><br />';
						}
						if($cus_company)
						{
							$message .= $lang_module['cus_company'] . '<strong>' . $cus_company . '</strong><br />';
						}
						if($cus_address)
						{
							$message .= $lang_module['cus_address'] . '<strong>' . $cus_address . '</strong><br />';
						}
						
						$from = array( $cus_name, $cus_email );
						$check = nv_sendmail( $from, $to_mail, $subject, $message );
						
						$cus_request = nv_nl2br( nv_htmlspecialchars (  $message ), '<br />' );

						// Insert data into Database
						$query = 'INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_request 
						(eid, status, create_time, cus_name, cus_email, cus_company, cus_phone, cus_address, cus_ip, cus_request )
						VALUES
						(:eid, 3, ' . NV_CURRENTTIME . ', :cus_name, :cus_email, :cus_company, :cus_phone, :cus_address, :cus_ip, :cus_request)';

						$data_insert = array();
						$data_insert['eid'] = $id;
						$data_insert['cus_name'] = $cus_name;
						$data_insert['cus_email'] = $cus_email;
						$data_insert['cus_company'] = $cus_company;
						$data_insert['cus_phone'] = $cus_phone;
						$data_insert['cus_address'] = $cus_address;
						$data_insert['cus_ip'] = $client_info['ip'];
						$data_insert['cus_request'] = $cus_request;
						$rq_id = $db->insert_id( $query, 'id', $data_insert );
						nv_insert_logs( NV_LANG_DATA, $module_name, 'Customer request', 'Employee name: ' . $title, '1' );
						// End insert data into Database
						
						$success = $lang_module['sendmail_success_contact'];
						$sendmail = '';
						header( 'refresh:5;url='. $link_back );
					}
					$result = array(
						'err_name' => $err_name,
						'err_email' => $err_youremail,
						'err_yourmail' => $err_youremail,
						'send_success' => $success,
						'check' => $check,
						'link_back' => $link_back
					);
				}
				$sendmail = array(
					'id' => $id,
					'title' => $title,
					'catid' => $catid,
					'checkss' => md5( $id . session_id() . $global_config['sitekey'] ),
					'cus_name' => $cus_name,
					'cus_email' => $cus_email,
					'cus_phone' => $cus_phone,
					'cus_company' => $cus_company,
					'cus_address' => $cus_address,
					'content' => $content,
					'result' => $result,
					'action' => NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=request/' . $global_array_cat[$catid]['alias'] . '/' . $alias . $global_config['rewrite_exturl'] //
				);

				$contents = sendcontact_theme( $sendmail );
				include NV_ROOTDIR . '/includes/header.php';
				if($full){
					echo nv_site_theme($contents);
				}else{
					echo $contents ;
				}
				include NV_ROOTDIR . '/includes/footer.php';
			}
		}
	}
}else{
	$allowed_send = 1;
	if( $allowed_send == 1 ){
		unset( $result );
		$result = '';
		$check = false;
		$checkss = $nv_Request->get_string( 'checkss', 'post', '' );
		
		$cus_name = $nv_Request->get_title( 'cus_name', 'post', '' );
		$cus_email = $nv_Request->get_title( 'cus_email', 'post', '' );
		$cus_phone = $nv_Request->get_title( 'cus_phone', 'post', '' );
		$cus_company = $nv_Request->get_title( 'cus_company', 'post', '' );
		$cus_address = $nv_Request->get_title( 'cus_address', 'post', '' );
		$to_mail = $module_config[$module_name]['sale_email'];
		$content = '';
		$this_link = $client_info['referer'];
		if( $checkss == md5( session_id() . $global_config['sitekey'] ) and $allowed_send == 1 ){
			$link = "<a href=\"$this_link\" title=\"Cần người giúp việc\">$this_link</a>\n";
			$link_back = nv_url_rewrite( NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name, true );
			$nv_seccode = $nv_Request->get_title( 'nv_seccode', 'post', '' );
			$full = true;
			$content = $nv_Request->get_title( 'content', 'post', '', 1 );
			$err_youremail = nv_check_valid_email( $cus_email );
			$err_name = $err_email = '';
			$message = '';
			$success = '';
			if( $module_config[$module_name]['captcha'] > 0 and ! nv_capcha_txt( $nv_seccode ) )
			{
				$err_name = $lang_global['securitycodeincorrect'];
			}
			elseif( empty( $cus_name ) )
			{
				$err_name = $lang_module['sendmail_err_name'];
			}
			elseif( empty( $err_youremail ) and empty( $err_name ) )
			{
				$subject = $lang_module['sendmail_subject'] . $cus_name . ' ' . $cus_phone;
				
				$message .= '<h2><strong>Cần người giúp việc</strong></h2><br />';
				
				$message .= '----------------------------------------------------<br /><br /><br />';
				$message .=  $content . '<br />';
				$message .= '--------------------<br />';
				$message .= '<strong>' . $lang_module['request_welcome2'] . '</strong>';
				$message .= '<br />' . $link . '<br />';
				
				$message .= '----------------------------------------------------<br />';
				$message .= '<h2><strong>' . $lang_module['cus_info'] . '</strong></h2><br />';
				$message .= '----------------------------------------------------<br />';
				
				$message .= $lang_module['cus_name'] . '<strong>' . $cus_name . '</strong><br />';
				$message .=  $lang_module['cus_email'] .  $cus_email . '<br />';
				if($cus_phone)
				{
					$message .= $lang_module['cus_phone'] . '<strong>' . $cus_phone . '</strong><br />';
				}
				if($cus_company)
				{
					$message .= $lang_module['cus_company'] . '<strong>' . $cus_company . '</strong><br />';
				}
				if($cus_address)
				{
					$message .= $lang_module['cus_address'] . '<strong>' . $cus_address . '</strong><br />';
				}
				
				$from = array( $cus_name, $cus_email );
				$check = nv_sendmail( $from, $to_mail, $subject, $message );
				
				$cus_request = nv_nl2br( nv_htmlspecialchars (  $message ), '<br />' );

				// Insert data into Database
				$query = 'INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_request 
				(eid, status, create_time, cus_name, cus_email, cus_company, cus_phone, cus_address, cus_ip, cus_request )
				VALUES
				(:eid, 3, ' . NV_CURRENTTIME . ', :cus_name, :cus_email, :cus_company, :cus_phone, :cus_address, :cus_ip, :cus_request)';

				$data_insert = array();
				$data_insert['eid'] = 0;
				$data_insert['cus_name'] = $cus_name;
				$data_insert['cus_email'] = $cus_email;
				$data_insert['cus_company'] = $cus_company;
				$data_insert['cus_phone'] = $cus_phone;
				$data_insert['cus_address'] = $cus_address;
				$data_insert['cus_ip'] = $client_info['ip'];
				$data_insert['cus_request'] = $cus_request;
				$rq_id = $db->insert_id( $query, 'id', $data_insert );
				nv_insert_logs( NV_LANG_DATA, $module_name, 'Customer request', 'Cần người giúp việc', '1' );
				// End insert data into Database
				
				$success = $lang_module['sendmail_success_contact'];
				$sendmail = '';
				header( 'refresh:5;url='. $link_back );
			}
			$result = array(
				'err_name' => $err_name,
				'err_email' => $err_youremail,
				'err_yourmail' => $err_youremail,
				'send_success' => $success,
				'check' => $check,
				'link_back' => $link_back
			);
		}
		$sendmail = array(
			'id' => 0,
			'title' => 'Liên hệ',
			'catid' => 0,
			'checkss' => md5( session_id() . $global_config['sitekey'] ),
			'cus_name' => $cus_name,
			'cus_email' => $cus_email,
			'cus_phone' => $cus_phone,
			'cus_company' => $cus_company,
			'cus_address' => $cus_address,
			'content' => $content,
			'result' => $result,
			'action' => NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=request' //
		);

		$contents = sendcontact_theme( $sendmail );
		include NV_ROOTDIR . '/includes/header.php';
		if($full){
			echo nv_site_theme($contents);
		}else{
			echo $contents ;
		}
		include NV_ROOTDIR . '/includes/footer.php';
	}
}
Header( 'Location: ' . $global_config['site_url'] );
exit();