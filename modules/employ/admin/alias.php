<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 2-10-2010 18:49
 */
if (! defined('NV_IS_FILE_ADMIN')) {
    die('Stop!!!');
}

$title = $nv_Request->get_title('title', 'post', '');
$alias = change_alias($title);

$id = $nv_Request->get_int('id', 'post', 0);
$mod = $nv_Request->get_string('mod', 'post', '');

if ($mod == 'cat') {
    $tab = NV_PREFIXLANG . '_' . $module_data . '_cat';
    $stmt = $db_slave->prepare('SELECT COUNT(*) FROM ' . $tab . ' WHERE catid!=' . $id . ' AND alias= :alias');
    $stmt->bindParam(':alias', $alias, PDO::PARAM_STR);
    $stmt->execute();
    $nb = $stmt->fetchColumn();
    if (! empty($nb)) {
        $nb = $db_slave->query('SELECT MAX(catid) FROM ' . $tab)->fetchColumn();
        
        $alias .= '-' . (intval($nb) + 1);
    }
	$alias = strtolower($alias);
} elseif ($mod == 'age') {
    $tab = NV_PREFIXLANG . '_' . $module_data . '_age_cat';
    $stmt = $db_slave->prepare('SELECT COUNT(*) FROM ' . $tab . ' WHERE aid!=' . $id . ' AND alias= :alias');
    $stmt->bindParam(':alias', $alias, PDO::PARAM_STR);
    $stmt->execute();
    $nb = $stmt->fetchColumn();
    if (! empty($nb)) {
        $nb = $db_slave->query('SELECT MAX(aid) FROM ' . $tab)->fetchColumn();
        
        $alias .= '-' . (intval($nb) + 1);
    }
	$alias = strtolower($alias);
} elseif ($mod == 'salary') {
    $tab = NV_PREFIXLANG . '_' . $module_data . '_salary_cat';
    $stmt = $db_slave->prepare('SELECT COUNT(*) FROM ' . $tab . ' WHERE sid!=' . $id . ' AND alias= :alias');
    $stmt->bindParam(':alias', $alias, PDO::PARAM_STR);
    $stmt->execute();
    $nb = $stmt->fetchColumn();
    if (! empty($nb)) {
        $nb = $db_slave->query('SELECT MAX(sid) FROM ' . $tab)->fetchColumn();
        
        $alias .= '-' . (intval($nb) + 1);
    }
	$alias = strtolower($alias);
} elseif ($mod == 'employee') {
    $tab = NV_PREFIXLANG . '_' . $module_data . '_rows';
    $stmt = $db_slave->prepare('SELECT COUNT(*) FROM ' . $tab . ' WHERE id!=' . $id . ' AND alias= :alias');
    $stmt->bindParam(':alias', $alias, PDO::PARAM_STR);
    $stmt->execute();
    $nb = $stmt->fetchColumn();
    if (! empty($nb)) {
        $nb = $db_slave->query('SELECT MAX(id) FROM ' . $tab)->fetchColumn();
        
        $alias .= '-' . (intval($nb) + 1);
    }
} elseif ($mod == 'location') {
    $tab = NV_PREFIXLANG . '_' . $module_data . '_location';
    $stmt = $db_slave->prepare('SELECT COUNT(*) FROM ' . $tab . ' WHERE location_id!=' . $id . ' AND alias= :alias');
    $stmt->bindParam(':alias', $alias, PDO::PARAM_STR);
    $stmt->execute();
    $nb = $stmt->fetchColumn();
    if (! empty($nb)) {
        $nb = $db_slave->query('SELECT MAX(location_id) FROM ' . $tab)->fetchColumn();
        
        $alias .= '-' . (intval($nb) + 1);
    }
}

include NV_ROOTDIR . '/includes/header.php';
echo $alias;
include NV_ROOTDIR . '/includes/footer.php';
