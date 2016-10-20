<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 2-10-2010 20:59
 */

if (! defined('NV_IS_FILE_MODULES')) {
    die('Stop!!!');
}

$sql_drop_module = array();
$array_table = array(
    'rows',
    'age_cat',
    'age',
    'salary_cat',
    'salary',
    'cat',
    'location',
    'request',
    'location_id'
);
$table = $db_config['prefix'] . '_' . $lang . '_' . $module_data;
$result = $db->query('SHOW TABLE STATUS LIKE ' . $db->quote($table . '_%'));
while ($item = $result->fetch()) {
    $name = substr($item['name'], strlen($table) + 1);
    if (preg_match('/^' . $db_config['prefix'] . '\_' . $lang . '\_' . $module_data . '\_/', $item['name']) and (preg_match('/^([0-9]+)$/', $name) or in_array($name, $array_table) or preg_match('/^bodyhtml\_([0-9]+)$/', $name))) {
        $sql_drop_module[] = 'DROP TABLE IF EXISTS ' . $item['name'];
    }
}

$result = $db->query("SHOW TABLE STATUS LIKE '" . $db_config['prefix'] . "\_" . $lang . "\_comment'");
$rows = $result->fetchAll();
if (sizeof($rows)) {
    $sql_drop_module[] = "DELETE FROM " . $db_config['prefix'] . "_" . $lang . "_comment WHERE module='" . $module_name . "'";
}
$sql_create_module = $sql_drop_module;

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_cat (
	  catid smallint(5) unsigned NOT NULL AUTO_INCREMENT,
	  parentid smallint(5) unsigned NOT NULL DEFAULT '0',
	  title varchar(250) NOT NULL,
	  titlesite varchar(250) DEFAULT '',
	  alias varchar(250) NOT NULL DEFAULT '',
	  description text,
	  descriptionhtml text,
	  viewdescription tinyint(2) NOT NULL DEFAULT '0',
	  weight smallint(5) unsigned NOT NULL DEFAULT '0',
	  sort smallint(5) NOT NULL DEFAULT '0',
	  lev smallint(5) NOT NULL DEFAULT '0',
	  viewcat varchar(50) NOT NULL DEFAULT 'viewcat_page_new',
	  numlinks tinyint(2) unsigned NOT NULL DEFAULT '3',
	  numsubcat smallint(5) NOT NULL DEFAULT '0',
	  subcatid varchar(255) DEFAULT '',
	  add_time int(11) unsigned NOT NULL DEFAULT '0',
	  edit_time int(11) unsigned NOT NULL DEFAULT '0',
	  groups_view varchar(255) DEFAULT '',
	  PRIMARY KEY (catid),
	  UNIQUE KEY alias (alias),
	  KEY parentid (parentid)
	) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_salary_cat (
	 sid smallint(5) unsigned NOT NULL AUTO_INCREMENT,
	 adddefault tinyint(4) NOT NULL DEFAULT '0',
	 title varchar(250) NOT NULL DEFAULT '',
	 alias varchar(250) NOT NULL DEFAULT '',
	 description varchar(255) DEFAULT '',
	 weight smallint(5) NOT NULL DEFAULT '0',
	 from_salary int(11) NOT NULL DEFAULT '0',
	 to_salary int(11) NOT NULL DEFAULT '0',
	 add_time int(11) NOT NULL DEFAULT '0',
	 edit_time int(11) NOT NULL DEFAULT '0',
	 PRIMARY KEY (sid),
	 UNIQUE KEY title (title),
	 UNIQUE KEY alias (alias)
	) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_salary (
	 sid smallint(5) unsigned NOT NULL,
	 id int(11) unsigned NOT NULL,
	 weight int(11) unsigned NOT NULL,
	 UNIQUE KEY sid (sid,id)
	) ENGINE=MyISAM";
	
$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_age_cat (
	 aid smallint(5) unsigned NOT NULL AUTO_INCREMENT,
	 adddefault tinyint(4) NOT NULL DEFAULT '0',
	 title varchar(250) NOT NULL DEFAULT '',
	 alias varchar(250) NOT NULL DEFAULT '',
	 description varchar(255) DEFAULT '',
	 weight smallint(5) NOT NULL DEFAULT '0',
	 from_age int(11) NOT NULL DEFAULT '0',
	 to_age int(11) NOT NULL DEFAULT '0',
	 add_time int(11) NOT NULL DEFAULT '0',
	 edit_time int(11) NOT NULL DEFAULT '0',
	 PRIMARY KEY (aid),
	 UNIQUE KEY title (title),
	 UNIQUE KEY alias (alias)
	) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_age (
	 aid smallint(5) unsigned NOT NULL,
	 id int(11) unsigned NOT NULL,
	 weight int(11) unsigned NOT NULL,
	 UNIQUE KEY aid (aid,id)
	) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_location (
	location_id mediumint(8) NOT NULL AUTO_INCREMENT,
	title varchar(250) NOT NULL DEFAULT '',
	alias varchar(250) NOT NULL DEFAULT '',
	weight mediumint(8) unsigned NOT NULL DEFAULT '0',
	status tinyint(1) unsigned NOT NULL DEFAULT '0',
	type varchar(30) NOT NULL,
	PRIMARY KEY (location_id),
	UNIQUE KEY alias (alias)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_location_id (
	 location_id smallint(5) unsigned NOT NULL,
	 id int(11) unsigned NOT NULL,
	 weight int(11) unsigned NOT NULL,
	 UNIQUE KEY location_id (location_id,id)
	) ENGINE=MyISAM";
	
$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_rows (
	 id int(11) unsigned NOT NULL auto_increment,
	 catid smallint(5) unsigned NOT NULL default '0',
	 listcatid varchar(255) NOT NULL default '',
	 admin_id mediumint(8) unsigned NOT NULL default '0',
	 author varchar(250) default '',
	 addtime int(11) unsigned NOT NULL default '0',
	 edittime int(11) unsigned NOT NULL default '0',
	 status tinyint(4) NOT NULL default '1',
	 title varchar(250) NOT NULL default '',
	 alias varchar(250) NOT NULL default '',
	 birthday int(11) unsigned NOT NULL default '0',
	 height int(11) unsigned NOT NULL default '0',
	 weight int(11) unsigned NOT NULL default '0',
	 job_status int(11) unsigned NOT NULL default '0',
	 sex int(11) unsigned NOT NULL default '0',
	 location_id int(11) unsigned NOT NULL default '0',
	 sid int(11) unsigned NOT NULL default '0',
	 aid int(11) unsigned NOT NULL default '0',
	 religion varchar(250) default '',
	 about_current_salary int(11) unsigned NOT NULL default '0',
	 about_wish_salary int(11) unsigned NOT NULL default '0',
	 about_family text NOT NULL,
	 about_experience text NOT NULL,
	 about_skill text NOT NULL,
	 about_wish text NOT NULL,
	 homeimgfile varchar(255) default '',
	 homeimgalt varchar(255) default '',
	 homeimgthumb tinyint(4) NOT NULL default '0',
	 inhome tinyint(1) unsigned NOT NULL default '0',
	 sort tinyint(1) unsigned NOT NULL default '0',
	 hitstotal mediumint(8) unsigned NOT NULL default '0',
	 PRIMARY KEY (id),
	 KEY catid (catid),
	 KEY admin_id (admin_id),
	 KEY author (author),
	 KEY title (title),
	 KEY addtime (addtime),
	 KEY status (status),
	 UNIQUE KEY alias (alias)
	) ENGINE=MyISAM";
	
$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_request (
	 id int(11) unsigned NOT NULL auto_increment,
	 eid int(11) unsigned NOT NULL default '0',
	 status smallint(5) unsigned NOT NULL default '0',
	 create_time int(11) unsigned NOT NULL default '0',
	 cus_name varchar(250) NOT NULL default '',
	 cus_email varchar(250) default '',
	 cus_company text,
	 cus_phone varchar(250) default '',
	 cus_address text,
	 cus_ip varchar(250) default '',
	 cus_request text,
	 PRIMARY KEY (id),
	 KEY eid (eid),
	 KEY status (status)
	) ENGINE=MyISAM";

$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'viewhome', 'viewcat_page_new')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'per_page', '20')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'st_links', '10')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'structure_upload', 'Ym')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'sale_email', 'your_email@gmail.com')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'captcha', '1')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'show_no_image', '')";
