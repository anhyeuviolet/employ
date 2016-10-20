<!-- BEGIN: main -->
<div id="sendmail">
	<div class="panel panel-default">
		<div class="panel-body">
			<h1 class="text-center">{SENDMAIL.title}</h1>
			<!-- BEGIN: result -->
			<div class="alert alert-warning" style="margin-top: 10px;">
				<div>
					{RESULT.err_name}
				</div>
				<div>
					{RESULT.err_capcha}
				</div>
				<div>
					{RESULT.err_email}
				</div>
				<div>
					{RESULT.err_yourmail}
				</div>
				<div class="text-center">
					{RESULT.send_success}
					<!-- BEGIN: return -->
					<p>Bạn sẽ được chuyển về trang vừa xem sau <strong>5</strong> giây nữa.</p>
					<!-- END: return -->
				</div>
			</div>
			<!-- END: result -->

			<!-- BEGIN: content -->
				<form id="sendmailForm" action="{SENDMAIL.action}" method="post" class="form-horizontal" role="form">
					<div class="form-group">
						<label for="sname" class="col-sm-4 control-label">{LANG.sendmail_name}<em>*</em></label>
						<div class="col-sm-20">
							<input id="sname" type="text" name="cus_name" value="{SENDMAIL.cus_name}" class="form-control" />
						</div>
					</div>

					<div class="form-group">
						<label for="cus_email" class="col-sm-4 control-label">{LANG.sendmail_youremail}<em>*</em></label>
						<div class="col-sm-20">
							<input id="cus_email" type="text" name="cus_email" value="{SENDMAIL.cus_email}" class="form-control" />
						</div>
					</div>
					
					<div class="form-group">
						<label for="cus_phone" class="col-sm-4 control-label">{LANG.sendmail_phone}</label>
						<div class="col-sm-20">
							<input id="cus_phone" type="text" name="cus_phone" value="{SENDMAIL.cus_phone}" class="form-control" />
						</div>
					</div>
					
					<div class="form-group">
						<label for="cus_address" class="col-sm-4 control-label">{LANG.sendmail_address}</label>
						<div class="col-sm-20">
							<input id="cus_address" type="text" name="cus_address" value="{SENDMAIL.cus_address}" class="form-control" />
						</div>
					</div>

					<div class="form-group">
						<label for="cus_company" class="col-sm-4 control-label">{LANG.sendmail_company}</label>
						<div class="col-sm-20">
							<input id="cus_company" type="text" name="cus_company" value="{SENDMAIL.cus_company}" class="form-control" />
						</div>
					</div>

					<div class="form-group">
						<label for="scontent" class="col-sm-4 control-label">{LANG.sendmail_content}</label>
						<div class="col-sm-20">
							<textarea id="scontent"  name="content" rows="5" cols="20" class="form-control">{SENDMAIL.content}</textarea>
						</div>
					</div>

					<!-- BEGIN: captcha -->
					<div class="form-group">
						<label for="semail" class="col-sm-4 control-label">{LANG.captcha}<em>*</em></label>
						<div class="col-sm-20">
							<input name="nv_seccode" type="text" id="seccode" class="form-control" maxlength="{GFX_NUM}" style="width: 100px; float: left !important; margin: 2px 5px 0 !important;"/><img class="captchaImg pull-left" style="margin-top: 5px;" alt="{N_CAPTCHA}" src="{NV_BASE_SITEURL}index.php?scaptcha=captcha&t={NV_CURRENTTIME}" width="{GFX_WIDTH}" height="{GFX_HEIGHT}" /><img alt="{CAPTCHA_REFRESH}" src="{CAPTCHA_REFR_SRC}" width="16" height="16" class="refresh pull-left resfresh1" style="margin: 9px;" onclick="change_captcha('#seccode');"/>
						</div>
					</div>
					<!-- END: captcha -->

					<input type="hidden" name="checkss" value="{SENDMAIL.checkss}" /><input type="hidden" name="catid" value="{SENDMAIL.catid}" /><input type="hidden" name="id" value="{SENDMAIL.id}" /><input type="submit" value="{LANG.sendmail_submit}" class="btn btn-primary center-block" />
				</form>
			<!-- END: content -->
		</div>
	</div>
</div>
<!-- END: main -->