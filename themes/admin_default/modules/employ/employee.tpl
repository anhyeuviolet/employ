<!-- BEGIN: main -->
<!-- BEGIN: error -->
<div class="alert alert-danger">{error}</div>
<!-- END: error -->
<link type="text/css" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.css" rel="stylesheet" />

<form class="form-inline m-bottom confirm-reload" action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" enctype="multipart/form-data" method="post">
	<div class="row">
		<div class="col-sm-24 col-md-18">
			<table class="table table-striped table-bordered">
				<col class="w200" />
				<col />
				<tbody>
					<tr>
						<td><strong>{LANG.name}</strong>: <sup class="required">(∗)</sup></td>
						<td><input type="text" maxlength="250" value="{rowcontent.title}" id="idtitle" name="title" class="form-control"  style="width:350px"/><span class="text-middle"> {GLANG.length_characters}: <span id="titlelength" class="red">0</span>. {GLANG.title_suggest_max} </span></td>
					</tr>
					<tr>
						<td><strong>{LANG.alias}: </strong></td>
						<td><input class="form-control" name="alias" id="idalias" type="text" value="{rowcontent.alias}" maxlength="250"  style="width:350px"/>&nbsp; <em class="fa fa-refresh fa-lg fa-pointer" onclick="get_alias('employee', '{rowcontent.id}');">&nbsp;</em></td>
					</tr>
				</tbody>
			</table>
			<table class="table table-striped table-bordered table-hover">
				<col class="w200" />
				<col />
				<tbody>
					<tr>
						<td><strong>{LANG.sex}: </strong></td>
						<td>
							<!-- BEGIN: sex -->
							<select class="form-control" style="width:150px" name="sex">
								<option value="" >{LANG.pick_sex}</option>
								<!-- BEGIN: loop -->
								<option value="{SEX.key}" {SEX.selected}>{SEX.title}</option>
								<!-- END: loop -->
							</select>
							<!-- END: sex -->
							<strong>{LANG.religion}: </strong><input class="form-control" name="religion" id="religion" type="text" value="{rowcontent.religion}" maxlength="250"  style="width:150px"/>
							<strong>{LANG.job_status}: </strong>
							<!-- BEGIN: job_status -->
							<select class="form-control" style="width:100px" name="job_status">
								<!-- BEGIN: loop -->
								<option value="{JOB_STATUS.key}" {JOB_STATUS.selected}>{JOB_STATUS.title}</option>
								<!-- END: loop -->
							</select>
							<!-- END: job_status -->
						</td>
					</tr>
					<tr>
						<td><strong>{LANG.about_weight}: </strong></td>
						<td>
							<input class="form-control" name="weight" id="weight" type="text" value="{rowcontent.weight}" maxlength="250"  style="width:150px"/>
							<strong>{LANG.height}: </strong><input class="form-control" name="height" id="height" type="text" value="{rowcontent.height}" maxlength="250"  style="width:150px"/>
							<strong>{LANG.birthday}: </strong><input class="form-control" name="birthday" id="birthday" type="text" value="{rowcontent.birthday}" maxlength="250"  style="width:150px"/>
						</td>
					</tr>
					<tr>
						<td><strong>{LANG.about_current_salary}: </strong></td>
						<td>
							<input class="form-control" name="about_current_salary" id="about_current_salary" type="text" value="{rowcontent.about_current_salary}" maxlength="250"  style="width:150px"/>
							<strong>{LANG.about_wish_salary}: </strong><input class="form-control" name="about_wish_salary" id="about_wish_salary" type="text" value="{rowcontent.about_wish_salary}" maxlength="250"  style="width:150px"/>
						</td>
					</tr>
					
					<tr>
						<td><strong>{LANG.status}: </strong></td>
						<td>
							<!-- BEGIN: status -->
							<select class="form-control" style="width:150px" name="status">
								<!-- BEGIN: loop -->
								<option value="{STATUS.key}" {STATUS.selected}>{STATUS.title}</option>
								<!-- END: loop -->
							</select>
							<!-- END: status -->
							
							<strong>{LANG.inhome}: </strong>
							<!-- BEGIN: inhome -->
							<select class="form-control" style="width:100px" name="inhome">
								<!-- BEGIN: loop -->
								<option value="{INHOME.key}" {INHOME.selected}>{INHOME.title}</option>
								<!-- END: loop -->
							</select>
							<!-- END: inhome -->
						</td>
					</tr>
					
					<tr>
						<td><strong>{LANG.content_homeimg}</strong></td>
						<td><input class="form-control" style="width:380px" type="text" name="homeimg" id="homeimg" value="{rowcontent.homeimgfile}"/> <input id="select-img-post" type="button" value="Browse server" name="selectimg" class="btn btn-info" /></td>
					</tr>
					<tr>
						<td>{LANG.content_homeimgalt}</td>
						<td><input class="form-control" type="text" maxlength="255" value="{rowcontent.homeimgalt}" id="homeimgalt" name="homeimgalt" style="width:100%" /></td>
					</tr>
				</tbody>
			</table>
			<table class="table table-striped table-bordered table-hover">
				<tbody>
					<tr>
						<td><strong>{LANG.about_family}</strong></td>
					</tr>
					<tr>
						<td>
						<div style="padding:2px; background:#CCCCCC; margin:0; display:block; position:relative">
							{edit_about_family}
						</div></td>
					</tr>
					<tr>
						<td><strong>{LANG.about_experience}</strong></td>
					</tr>
					<tr>
						<td>
						<div style="padding:2px; background:#CCCCCC; margin:0; display:block; position:relative">
							{edit_about_experience}
						</div></td>
					</tr>
					<tr>
						<td><strong>{LANG.about_skill}</strong></td>
					</tr>
					<tr>
						<td>
						<div style="padding:2px; background:#CCCCCC; margin:0; display:block; position:relative">
							{edit_about_skill}
						</div></td>
					</tr>
					<tr>
						<td><strong>{LANG.about_wish}</strong></td>
					</tr>
					<tr>
						<td>
						<div style="padding:2px; background:#CCCCCC; margin:0; display:block; position:relative">
							{edit_about_wish}
						</div></td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="col-sm-24 col-md-6">
			<div class="row">
				<div class="col-sm-12 col-md-24">
					<ul style="padding-left:4px; margin:0">
						<li>
							<p class="message_head">
								<cite>{LANG.content_cat}:</cite> <sup class="required">(∗)</sup>
							</p>
							<div class="message_body" style="height:260px; overflow: auto">
								<table class="table table-striped table-bordered table-hover">
									<tbody>
										<!-- BEGIN: catid -->
										<tr>
											<td><input style="margin-left: {CATS.space}px;" type="checkbox" value="{CATS.catid}" name="catids[]" class="news_checkbox" {CATS.checked} {CATS.disabled}> {CATS.title} </td>
											<td><input id="catright_{CATS.catid}" style="{CATS.catiddisplay}" type="radio" name="catid" title="{LANG.content_checkcat}" value="{CATS.catid}" {CATS.catidchecked}/></td>
										</tr>
										<!-- END: catid -->
									</tbody>
								</table>
							</div>
						</li>
						<li>
							<p class="message_head">
								<cite>{LANG.age}</cite>
							</p>
							<div class="message_body">
								<select class="form-control" style="width:100%" name="age">
									<option value=""><em>{LANG.pick_age}</em></option>
									<!-- BEGIN: age -->
									<option value="{AGE.aid}" {AGE.selected}>{AGE.title}</option>
									<!-- END: age -->
								</select>
							</div>
						</li>
						<li>
							<p class="message_head">
								<cite>{LANG.salary}:</cite>
							</p>
							<div class="message_body">
								<select class="form-control" style="width:100%" name="salary">
									<option value=""><em>{LANG.pick_salary}</em></option>
									<!-- BEGIN: salary -->
									<option value="{SALARY.sid}" {SALARY.selected}>{SALARY.title}</option>
									<!-- END: salary -->
								</select>
							</div>
						</li>
						<li>
							<p class="message_head">
								<cite>{LANG.location}:</cite>
							</p>
							<div class="message_body">
								<select class="form-control required" style="width:100%" name="location" required="required">
									<option value=""><em>{LANG.pick_location}</em></option>
									<!-- BEGIN: location -->
									<option value="{LOCATIONS.location_id}" {LOCATIONS.selected}>{LOCATIONS.title}</option>
									<!-- END: location -->
								</select>
							</div>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="text-center">
		<br/>
		<input type="hidden" value="1" name="save" />
		<input type="hidden" value="{rowcontent.id}" name="id" />
		<input class="btn btn-primary submit-post" name="statussave" type="submit" value="{LANG.save}" />
	</div>
</form>
<div id="message"></div>
<script type="text/javascript">
//<![CDATA[
var LANG = [];
var CFG = [];
CFG.uploads_dir_user = "{UPLOADS_DIR_USER}";
CFG.upload_current = "{UPLOAD_CURRENT}";
LANG.content_tags_empty = "{LANG.content_tags_empty}.<!-- BEGIN: auto_tags --> {LANG.content_tags_empty_auto}.<!-- END: auto_tags -->";
LANG.alias_empty_notice = "{LANG.alias_empty_notice}";
var content_checkcatmsg = "{LANG.content_checkcatmsg}";
<!-- BEGIN: getalias -->
$("#idtitle").change(function() {
	get_alias('employee', '{rowcontent.id}');
});
<!-- END: getalias -->
//]]>
</script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/language/jquery.ui.datepicker-{NV_LANG_INTERFACE}.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}themes/admin_default/js/employ_content.js"></script>
<!-- END:main -->