<!-- BEGIN: main -->
<div class="row">
	<!-- BEGIN: loop -->
	<div class="panel panel-default">
		<div class="panel-body">
			<div class="col-md-6 views-field views-field-field-image">
				<div class="img-content">
					<a href="{MAIN.link}">
						<img class="img-responsive" src="{MAIN.imghome}" alt="{MAIN.title}">
					</a>
					<a class="center-block btn btn-primary request-button cat-modal margin-top-lg" href="{MAIN.request_link}" title="{MAIN.title}">Chọn</a>
					<!-- BEGIN: adminlink -->
					<a class="center-block btn btn-success margin-top-lg" href="{ADMINLINK}" title="{MAIN.title}">Sửa</a>
					<!-- END: adminlink -->
				</div>
			</div>
			<div class="col-md-18 views-field">
				<h3 class="field-content">
					<a class="maid-title" href="{MAIN.link}">{MAIN.title}</a>
				</h3>
				<ul class="list-unstyled">
					<li class="views-field views-field-field-special-feature">
						<p class="field-content"><strong>Sinh Năm: </strong>{MAIN.birthday}</p>
					</li>
					<li class="views-field views-field-field-special-feature">
						<p class="field-content"><strong>Quê Quán: </strong>{MAIN.location}</p>
					</li>
					<li class="views-field views-field-field-special-feature">
						<p class="field-content"><strong>Trạng thái: </strong>{MAIN.job_status}</p>
					</li>
					<li class="views-field views-field-body">
						<li class="field-content">
							<p class="field-content"><strong>Kinh nghiệm: </strong> {MAIN.about_experience}</p>
						</li>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<!-- END: loop -->
</div>


<div id="catModal" class="modal fade">
<div class="modal-dialog">
    <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><strong>Yêu cầu người giúp việc</strong></h4>
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
<script>
$('.cat-modal').on('click', function(e){
  e.preventDefault();
  $('#catModal').modal('show').find('.modal-body').load($(this).attr('href'));
});
</script>
<!-- BEGIN: generate_page -->
<div class="clearfix"></div>
<div class="text-center">
	{GENERATE_PAGE}
</div>
<!-- END: generate_page -->
<!-- END: main -->