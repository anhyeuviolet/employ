<!-- BEGIN: main -->
<!-- BEGIN: cat_title -->
<div style="background:#eee;padding:10px">
	{CAT_TITLE}
</div>
<!-- END: cat_title -->
<!-- BEGIN: data -->
<div class="table-responsive">
	<table class="table table-striped table-bordered table-hover">
		<thead>
			<tr>
				<th class="text-center">{LANG.weight}</th>
				<th class="text-center">{LANG.name}</th>
				<th class="text-center">{LANG.viewcat_page}</th>
				<th class="text-center">{LANG.numlinks}</th>
				<th class="text-center">{LANG.functional}</th>
			</tr>
		</thead>
		<tbody>
			<!-- BEGIN: loop -->
			<tr>
				<td class="text-center">
				<!-- BEGIN: stt -->
				{STT}
				<!-- END: stt -->
				<!-- BEGIN: weight -->
				<select class="form-control" id="id_weight_{ROW.catid}" onchange="nv_change_cat('{ROW.catid}','weight');">
					<!-- BEGIN: loop -->
					<option value="{WEIGHT.key}"{WEIGHT.selected}>{WEIGHT.title}</option>
					<!-- END: loop -->
				</select>
				<!-- END: weight -->
				</td>
				<td><a href="{ROW.link}"><strong>{ROW.title}</strong>
				<!-- BEGIN: numsubcat -->
				<span class="red">({NUMSUBCAT})</span>
				<!-- END: numsubcat -->
				</a>
				</td>
				<td class="text-left">
				<!-- BEGIN: disabled_viewcat -->
				{VIEWCAT}
				<!-- END: disabled_viewcat -->
				<!-- BEGIN: viewcat -->
				<select class="form-control" id="id_viewcat_{ROW.catid}" onchange="nv_change_cat('{ROW.catid}','viewcat');">
					<!-- BEGIN: loop -->
					<option value="{VIEWCAT.key}"{VIEWCAT.selected}>{VIEWCAT.title}</option>
					<!-- END: loop -->
				</select>
				<!-- END: viewcat -->
				</td>
				<td class="text-center">
				<!-- BEGIN: title_numlinks -->
				{NUMLINKS}
				<!-- END: title_numlinks -->
				<!-- BEGIN: numlinks -->
				<select class="form-control" id="id_numlinks_{ROW.catid}" onchange="nv_change_cat('{ROW.catid}','numlinks');">
					<!-- BEGIN: loop -->
					<option value="{NUMLINKS.key}"{NUMLINKS.selected}>{NUMLINKS.title}</option>
					<!-- END: loop -->
				</select>
				<!-- END: numlinks -->
				</td>
				<td class="text-center">{ROW.adminfuncs}</td>
			</tr>
			<!-- END: loop -->
		</tbody>
	</table>
</div>
<!-- END: data -->
<!-- END: main -->