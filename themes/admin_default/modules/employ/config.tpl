<!-- BEGIN: main -->
<link rel="stylesheet" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/select2.min.css">
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/select2.min.js"></script>

<form class="form-inline" role="form" action="{NV_BASE_ADMINURL}index.php" method="post">
	<input type="hidden" name ="{NV_NAME_VARIABLE}" value="{MODULE_NAME}" />
	<input type="hidden" name ="{NV_OP_VARIABLE}" value="{OP}" />
	<div class="table-responsive">
		<table class="table table-striped table-bordered table-hover">
			<caption><em class="fa fa-file-text-o">&nbsp;</em>{LANG.setting_view}</caption>
			<tbody>
				<tr>
					<th>{LANG.setting_indexfile}</th>
					<td>
					<select class="form-control" name="viewhome">
						<!-- BEGIN: viewhome -->
						<option value="{VIEWHOME.key}"{VIEWHOME.selected}>{VIEWHOME.title}</option>
						<!-- END: viewhome -->
					</select></td>
				</tr>
				<tr>
					<th>{LANG.setting_per_page}</th>
					<td>
					<select class="form-control" name="per_page">
						<!-- BEGIN: per_page -->
						<option value="{PER_PAGE.key}"{PER_PAGE.selected}>{PER_PAGE.title}</option>
						<!-- END: per_page -->
					</select></td>
				</tr>
				<tr>
					<th>{LANG.setting_st_links}</th>
					<td>
					<select class="form-control" name="st_links">
						<!-- BEGIN: st_links -->
						<option value="{ST_LINKS.key}"{ST_LINKS.selected}>{ST_LINKS.title}</option>
						<!-- END: st_links -->
					</select></td>
				</tr>
				<tr>
					<th>{LANG.structure_image_upload}</th>
					<td>
					<select class="form-control" name="structure_upload" id="structure_upload">
						<!-- BEGIN: structure_upload -->
						<option value="{STRUCTURE_UPLOAD.key}"{STRUCTURE_UPLOAD.selected}>{STRUCTURE_UPLOAD.title}</option>
						<!-- END: structure_upload -->
					</select></td>
				</tr>
				<tr>
					<th>Email nhận yêu cầu Khách hàng</th>
					<td><input class="form-control w150" name="sale_email" value="{DATA.sale_email}" type="text"/></td>
				</tr>
				<tr>
					<th>Kích hoạt Captcha khi gửi yêu cầu</th>
					<td><input type="checkbox" value="1" name="captcha"{CAPTCHA}/></td>
				</tr>
				<tr>
					<th>{LANG.show_no_image}</th>
					<td><input class="form-control" name="show_no_image" id="show_no_image" value="{SHOW_NO_IMAGE}" style="width:340px;" type="text"/> <input id="select-img-setting" value="{GLANG.browse_image}" name="selectimg" type="button" class="btn btn-info"/></td>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<td class="text-center" colspan="2">
						<input class="btn btn-primary" type="submit" value="{LANG.save}" name="Submit1" />
						<input type="hidden" value="1" name="savesetting" />
					</td>
				</tr>
			</tfoot>
		</table>
	</div>
</form>
<script type="text/javascript">
//<![CDATA[
$(document).ready(function() {
	$("#structure_upload").select2();
});
//]]>
</script>
<script type="text/javascript">
//<![CDATA[
var CFG = [];
CFG.path = '{PATH}';
CFG.currentpath = '{CURRENTPATH}';
$(document).ready(function() {
	$("#structure_upload").select2();
});
//]]>
</script>
<!-- END: main -->