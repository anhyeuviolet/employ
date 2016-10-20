<!-- BEGIN: list -->
<!-- BEGIN: empty -->
<div class="alert alert-info">Chưa có liên hệ nào</div>
<!-- END: empty -->
<!-- BEGIN: data -->
<div class="table-responsive">
	<table class="table table-striped table-bordered table-hover">
		<thead>
			<tr>
				<th>{LANG.part_row_title} Số thứ tự </th>
				<th>{LANG.part_row_title} Tên KH</th>
				<th>{LANG.part_row_title} Thời gian gửi </th>
				<th>{LANG.cat} Email</th>
				<th>{LANG.title_send_title} Điện thoại</th>
				<th>   </th>
			</tr>
		</thead>
		<tbody>
			<!-- BEGIN: row -->
			<tr>
				<td>{ROW.num}</td>
				<td><a href="{ROW.link}" title="{ROW.cus_name}">{ROW.cus_name}</a></td>
				<td>{ROW.create_time}</td>
				<td>{ROW.cus_email}</td>
				<td>{ROW.cus_phone}</td>
				<td>{ROW.delete}</td>
			</tr>
			<!-- END: row -->
		</tbody>
	</table>
</div>
<!-- BEGIN: generate_page -->
	<div class="text-center">{GENERATE_PAGE}</div>
<!-- END: generate_page -->
<!-- END: data -->
<!-- END: list -->

<!-- BEGIN: single -->
<div class="row">
	<div class="well">{ROW.cus_request}</div>
	<table class="table table-condensed">
		<tr class="success">
			<td>Tên Khách hàng</td>
			<td>{ROW.cus_name}</td>
		</tr>
		<tr>
			<td>Thời gian gửi yêu cầu</td>
			<td>{ROW.create_time}</td>
		</tr>
		<tr>
			<td>Email</td>
			<td>{ROW.cus_email}</td>
		</tr>
		<tr>
			<td>Số điện thoại</td>
			<td>{ROW.cus_phone}</td>
		</tr>
		<tr>
			<td>IP khách hàng</td>
			<td>{ROW.cus_ip}</td>
		</tr>
	</table>
</div>
<!-- END: single -->

