<!-- BEGIN: main -->
<h2>Thông tin người lao động</h2>
<hr/>
<div class="row employee_detail">
	<div class="col-md-8">
		<img src="{DETAIL.homeimgfile}" alt="{DETAIL.title}" class="img-responsive"/>
		<div class="col-md-24 margin-top-lg">
			<a class="center-block btn btn-primary request-button ls-modal-{DETAIL.id}" href="{DETAIL.request_link}" title="{LANG.title}">Chọn</a>
		</div>
		<!-- BEGIN: adminlink -->
		<div class="col-md-24 margin-top-lg">
			<a class="center-block btn btn-success edit-button" href="{ADMINLINK}" title="Sửa">Sửa</a>
		</div>
		<!-- END: adminlink -->
	</div>
	<div class="col-md-16">
		<h2 class="employee_name">{DETAIL.title}</h2>
		<div class="row">
			<div class="col-md-12">
			<p><strong>Mức lương hiện tại:</strong> {DETAIL.about_current_salary} VND</p>
			</div>
			<div class="col-md-12">
			<p><strong>Mức lương mong muốn:</strong> {DETAIL.about_wish_salary} VND</p>
			</div>
		</div>	
		<hr/>
		<div class="row">
		<h3>1. Thông tin cá nhân</h3>
			<div class="col-md-12">
			<p><strong>Năm sinh:</strong> {DETAIL.birthday}</p>
			<p><strong>Quê quán:</strong> {DETAIL.location}</p>
			<p><strong>Chiều cao:</strong> {DETAIL.height} cm</p>
			<p><strong>Sẵn sàng nhận việc:</strong> {DETAIL.job_status}</p>
			</div>
			<div class="col-md-12">
			<p><strong>Giới tính:</strong> {DETAIL.sex}</p>
			<p><strong>Tôn giáo:</strong> {DETAIL.religion}</p>
			<p><strong>Cân nặng:</strong> {DETAIL.weight} Kg</p>
			</div>
		</div>
		<hr/>
		<div class="row">
			<h3>2. Hoàn cảnh gia đình</h3>
			<p>{DETAIL.about_family}</p>
		</div>
		<hr/>
		<div class="row">
			<h3>3. Kinh nghiệm làm việc</h3>
			<p>{DETAIL.about_experience}</p>
		</div>
		<hr/>
		<div class="row">
			<h3>4. Kĩ năng</h3>
			<p>{DETAIL.about_skill}</p>
		</div>
		<hr/>
		<div class="row">
			<h3>5. Nguyện vọng</h3>
			<p>{DETAIL.about_wish}</p>
		</div>
	</div>
</div>
<div id="previewModal-{DETAIL.id}" class="modal fade">
<div class="modal-dialog">
    <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><strong>Bạn đã chọn người giúp việc {DETAIL.title}</strong></h4>
            </div>
            <div class="modal-body">
                <p>Loading...</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
            </div>
    </div>
</div>
</div>
<!-- BEGIN: related -->
<hr/>
<div class="row">
<h3 class="field-content">Các ứng viên khác</h3>
<hr/>
	<!-- BEGIN: loop -->
	<div class="col-md-6">
		<a href="{RELATED.link}" title="{RELATED.title}"><img src="{RELATED.homeimgfile}" alt="{RELATED.title}" class="img-responsive"/></a>
		<a href="{RELATED.link}" class="maid-title" title="{RELATED.title}"><h3 class="field-content">{RELATED.title}</h3></a>
		<div class="col-md-24 margin-top-lg">
			<p><strong>Năm sinh:</strong> {RELATED.birthday}</p>
			<p><strong>Quê quán:</strong> {RELATED.location}</p>
			<p><strong>Sẵn sàng nhận việc:</strong> {DETAIL.job_status}</p>
			<a class="center-block btn btn-primary request-button ls-related-{RELATED.id}" href="{RELATED.request_link}" title="{RELATED.title}">Chọn</a>
		</div>
		<!-- BEGIN: adminlink -->
		<div class="col-md-24 margin-top-lg">
			<a class="center-block btn btn-success edit-button" href="{ADMINLINK}" title="Sửa">Sửa</a>
		</div>
		<!-- END: adminlink -->
	</div>
	<div id="related-{RELATED.id}" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title"><strong>Bạn đã chọn người giúp việc {RELATED.title}</strong></h4>
					</div>
					<div class="modal-related-{RELATED.id}">
						<p>Loading...</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
					</div>
			</div>
		</div>
	</div>
	<script>
	$('.ls-related-{RELATED.id}').on('click', function(e){
	  e.preventDefault();
	  $('#related-{RELATED.id}').modal('show').find('.modal-related-{RELATED.id}').load($(this).attr('href'));
	});
	</script>
	<!-- END: loop -->
</div>
<!-- END: related -->

<script>
$('.ls-modal-{DETAIL.id}').on('click', function(e){
  e.preventDefault();
  $('#previewModal-{DETAIL.id}').modal('show').find('.modal-body').load($(this).attr('href'));
});
</script>
<!-- END: main -->