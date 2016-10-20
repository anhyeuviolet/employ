<!-- BEGIN: main -->
<div class="table-responsive">
	<table class="table table-striped table-bordered table-hover">
		<thead>
			<tr>
				<th>{LANG.weight}</th>
				<th class="text-center">ID</th>
				<th>{LANG.name}</th>
				<th>{LANG.status}</th>
				<th>{LANG.inhome}</th>
				<th>{LANG.job_status}</th>
				<th>&nbsp;</th>
			</tr>
		</thead>
		<tbody>
			<!-- BEGIN: loop -->
			<tr>
				<td class="text-center">
					<select class="form-control" id="id_sort_{ROW.id}" onchange="nv_change_employee('{ROW.id}','sort');">
						<!-- BEGIN: sort -->
						<option value="{sort.key}"{sort.selected}>{sort.title}</option>
						<!-- END: sort -->
					</select>
				</td>
				<td class="text-center"><strong>{ROW.id}</strong></td>
				<td><strong><a href="{ROW.link}" title="{ROW.title}" target="_blank">{ROW.title}</a></strong></td>
				<td class="text-center">
					<select class="form-control" id="id_status_{ROW.id}" onchange="nv_change_employee('{ROW.id}','status');">
						<!-- BEGIN: status -->
						<option value="{status.key}"{status.selected}>{status.title}</option>
						<!-- END: status -->
					</select>
				</td>
				<td class="text-center">
					<select class="form-control" id="id_inhome_{ROW.id}" onchange="nv_change_employee('{ROW.id}','inhome');">
						<!-- BEGIN: inhome -->
						<option value="{inhome.key}"{inhome.selected}>{inhome.title}</option>
						<!-- END: inhome -->
					</select>
				</td>
				<td class="text-center">
					<select class="form-control" id="id_job_status_{ROW.id}" onchange="nv_change_employee('{ROW.id}','job_status');">
						<!-- BEGIN: job_status -->
						<option value="{job_status.key}"{job_status.selected}>{job_status.title}</option>
						<!-- END: job_status -->
					</select>
				</td>
				<td class="text-center">
					<em class="fa fa-edit fa-lg">&nbsp;</em> <a href="{ROW.url_edit}">{GLANG.edit}</a> &nbsp;
					<em class="fa fa-trash-o fa-lg">&nbsp;</em> <a href="javascript:void(0);" onclick="nv_del_employee({ROW.id},'{CHECKSS}')">{GLANG.delete}</a>
				</td>
			</tr>
			<!-- END: loop -->
		</tbody>
	</table>
</div>
<!-- END: main -->