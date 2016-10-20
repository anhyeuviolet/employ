<!-- BEGIN: main -->
<form name="block_list" action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="get">
	<div class="table-responsive">
		<table class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th class="w100">{LANG.location_id}</th>
					<th>{LANG.location_name}</th>
					<th>{LANG.location_type}</th>
					<th>&nbsp;</th>
				</tr>
			</thead>
			<tbody>
			<!-- BEGIN: loop -->
				<tr>
					<td class="text-center">{ROW.location_id}</td>
					<td class="text-left"><strong>{ROW.title}</strong></td>
					<td class="text-left"><strong>{ROW.type}</strong></td>
					<td class="text-center">
						<em class="fa fa-edit fa-lg">&nbsp;</em> <a href="{ROW.url_edit}">{GLANG.edit}</a> &nbsp;
						<em class="fa fa-trash-o fa-lg">&nbsp;</em> <a href="javascript:void(0);" onclick="nv_del_location({ROW.location_id})">{GLANG.delete}</a>
					</td>
				</tr>
			<!-- END: loop -->
			</tbody>
		</table>
	</div>
</form>
<!-- END: main -->