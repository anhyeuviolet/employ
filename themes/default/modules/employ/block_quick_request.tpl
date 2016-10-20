<!-- BEGIN: main -->
<style>
	.float{
		position:fixed;
		width:60px;
		height:60px;
		bottom:40px;
		right:40px;
		color:#FFF;
		border-radius:50px;
		text-align:center;
		z-index:999;
	}

	.my-float{
		margin-top:15px;
		font-size:18px;
	}
</style>
<div class="col-md-24 margin-top-lg">
	<a class="center-block btn btn-primary request-button ls-modal-{BLOCKID} float" href="{REQUEST_LINK}" title="Yêu cầu người giúp việc">
	<i class="fa fx-2x fa-phone my-float"></i>
	</a>
</div>

<div id="blockModal-{BLOCKID}" class="modal fade">
<div class="modal-dialog">
    <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><strong>Yêu cầu người giúp việc</strong></h4>
            </div>
            <div class="modal-body-{BLOCKID}">
                <p>Loading...</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
            </div>
    </div>
</div>
</div>
<script>
$('.ls-modal-{BLOCKID}').on('click', function(e){
  e.preventDefault();
  $('#blockModal-{BLOCKID}').modal('show').find('.modal-body-{BLOCKID}').load($(this).attr('href'));
});
</script>
<!-- END: main -->