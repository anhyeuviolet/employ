/**
 * @Project NUKEVIET 4.x
 * @Author KennyNguyen (nguyentiendat713@gmail.com)
 * @Copyright (C) 2016 KennyNguyen .All rights reserved
 * @Website support https://www.nuke.vn
 * @License GNU/GPL version 2 or any later version
 * @Createdate Thu, 22 Sep 2016 13:09:49 GMT
 */
 
 function employ_search(module) {
	var keyword = $('#keyword').val();
	var location_id = $('#location_id').val();
	if (location_id == null)
		location_id = '';
	var sid = $('#sid').val();
	if (sid == null)
		sid = '';
	var aid = $('#aid').val();
	if (aid == null)
		aid = '';
	var cataid = $('#cata').val();
	if (keyword == '' && location_id == '' && sid == '' && cataid == 0 ) {
		return false;
	} else {
		window.location.href = nv_base_siteurl + 'index.php?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + module + '&' + nv_fc_variable + '=search&q=' + rawurlencode(keyword) + '&location_id=' + location_id + '&sid=' + sid + '&aid=' + aid + '&cata=' + cataid;
	}
	return false;
}