<!-- BEGIN: main -->
<!-- BEGIN: marquee_css -->
<script src="{NV_BASE_SITEURL}themes/{TEMPLATE}/js/jquery.marquee.min.js" type="text/javascript"></script>
	<style>
		.marquee {
			width: 95%;
			overflow: hidden;
		}
		.item-display{
			height:auto;
			text-align:center;
		}
		.marquee ul li{
			display:inline-block;
			margin-right: 50px;
		}
	</style>
<!-- END: marquee_css -->
	<script>
	$('#marquee-{BLOCKID}').marquee({
		duration: {duration},
		gap: 50,
		delayBeforeStart: 0,
		direction: '{direction}',
		duplicated: true,
		pauseOnHover: {pauseOnHover}
	});
	</script>

	<div class="pull-left"><i class="fa fa-quote-left" aria-hidden="true"></i></div>
	<div id="marquee-{BLOCKID}" class="center-block marquee">
		<ul class="item-display">
		<!-- BEGIN: newloop -->
		<li class="thumbnail-display">
			<a href="{blocknews.link}" title="{blocknews.title}" target="_blank">{blocknews.title}</a>
		</li>
		<!-- END: newloop -->
		</ul>
	</div>
<!-- END: main -->