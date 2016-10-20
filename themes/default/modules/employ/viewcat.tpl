<!-- BEGIN: main -->
<div class="row">
	<!-- BEGIN: loop -->
	<div class="col-md-8 margin-top-lg margin-bottom-lg">
		<div class="crazy">
			<div class="views-field views-field-field-image">
				<div class="field-content">
					<a href="{MAIN.link}">
						<img class="img-responsive" src="{MAIN.imghome}" alt="{MAIN.title}">
					</a>
				</div>
			</div>
			<div class="views-field views-field-title">
				<a class="maid-title" href="{MAIN.link}">
					<h3 class="field-content">
						{MAIN.title}
					</h3>
				</a>
			</div>
			<div class="views-field views-field-field-special-feature">
				<div class="field-content"><strong>Sinh Năm: </strong>{MAIN.birthday}</div>
			</div>
			<div class="views-field views-field-field-special-feature">
				<div class="field-content"><strong>Quê Quán: </strong>{MAIN.location}</div>
			</div>
			<div class="views-field views-field-field-special-feature">
				<div class="field-content"><strong>Trạng thái: </strong>{MAIN.job_status}</div>
			</div>
			<div class="views-field views-field-body">
				<div class="field-content">
					<strong>Kinh nghiệm: </strong> {MAIN.about_experience}
				</div>
			</div>
			<div class="views-field views-field-body" style="text-align:center;margin-top:10px;">
				<a class="center-block btn btn-primary request-button cat-modal" href="{MAIN.request_link}" title="{MAIN.title}">Chọn</a>
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