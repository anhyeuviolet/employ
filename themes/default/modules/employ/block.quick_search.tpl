<!-- BEGIN: main -->
<form id="search_form_shops" action="{NV_BASE_SITEURL}" method="get" role="form" name="frm_search" onsubmit="return employ_search();">
	<div class="form-group">
		<label>{LANG.keyword}</label>
		<input id="keyword" type="text" value="{value_keyword}" name="keyword" class="form-control input-sm">
	</div>

	<div class="form-group">
		<label>Loại việc làm</label>
		<select name="cata" id="cata" class="form-control input-sm">
			<option value="0">Chọn loại công việc</option>
			<!-- BEGIN: loopcata -->
			<option {ROW.selected} value="{ROW.catid}">{ROW.xtitle}</option>
			<!-- END: loopcata -->
		</select>
	</div>
	
	<div class="form-group">
		<label>Mức lương</label>
		<select name="sid" id="sid" class="form-control input-sm">
			<option value="0">Chọn mức lương</option>
			<!-- BEGIN: salary -->
			<option {ROW.selected} value="{ROW.sid}">{ROW.xtitle}</option>
			<!-- END: salary -->
		</select>
	</div>
	
	<div class="form-group">
		<label>Độ tuổi</label>
		<select name="aid" id="aid" class="form-control input-sm">
			<option value="0">Chọn độ tuổi</option>
			<!-- BEGIN: age -->
			<option {ROW.selected} value="{ROW.aid}">{ROW.xtitle}</option>
			<!-- END: age -->
		</select>
	</div>

	<div class="form-group">
		<label>Quê quán</label>
		<select name="location_id" id="location_id" class="form-control input-sm">
			<option value="0">Chọn quê quán</option>
			<!-- BEGIN: location -->
			<option {ROW.selected} value="{ROW.location_id}">{ROW.xtitle}</option>
			<!-- END: location -->
		</select>
	</div>

	<div class="text-center">
		<input type="button" name="submit" id="submit" value="{LANG.search}" onclick="employ_search('{MODULE_NAME}')" class="btn btn-primary">
	</div>
</form>
<!-- END: main -->