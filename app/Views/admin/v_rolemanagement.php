<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mb-5">
	<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
		<h2 class="h2"><?php echo $pagetitle; ?> <a href="javascript: reloadPage();"><i class="bi-arrow-clockwise"></i></a></h2>
		<div class="btn-toolbar mb-2 mb-md-0">
			<div class="btn-group me-2">
				<button onclick="b_add()" type="button" class="btn btn-sm btn-primary">添加/Add</button>

			</div>
		</div>
	</div>

	<div id="crud_form" style="display: none;">
		<h4 id="crud_label">Add/Edit Role</h4>
		<form class="row">
			<div class="mb-3 col-md-6">
				<label for="role_name" class="form-label">角色名称 / Role Name</label>
				<input type="text" class="form-control" id="role_name">
				<div id="rolenametext" class="form-text">请输入角色名称 / Enter Role Name.</div>
			</div>
			<div class="mb-3 col-md-6">
				<label for="role_desc" class="form-label">说明 / Description</label>
				<input type="text" class="form-control" id="role_desc">
				<div id="role_desctext" class="form-text">输入说明 / Enter Description</div>
			</div>
			<h6>权限 / Permissions</h6>
			<div class="mb-3 col-md-12 form-check">
				<div class="row" id="perm_list">
					<?php
					foreach ($permission_list as $row) {
					?>
						<div class="col-md-6 px-4 py-1">
							<input type="checkbox" class="form-check-input" name="permission_list" id="perm_<?php echo $row['id']; ?>" value="<?php echo $row['id']; ?>">
							<label class="form-check-label" for="perm_<?php echo $row['id']; ?>"><?php echo $row['controller_method']; ?></label>
						</div>
					<?php
					}
					?>
				</div>
			</div>

			<h6>用户指南 / Userguide</h6>
			<ul class="list-unstyled">
				<li>一个角色至少需要1个权限 / At least 1 permission is required for a role.</li>
			</ul>
			<input type="hidden" id="action_type" value="add/123456">
		</form>
		<div class="spin w-100 h-100 position-absolute d-none">
			<div class="role-spinner spinner-border " role="status">
				<span class="sr-only"></span>
			</div>
		</div>
		<div class="mb-3 col-12 text-end">
			<button onclick="b_cancel()" class="btn btn-secondary">取消/Cancel</button>
			<button onclick="b_submit()" class="btn btn-primary">提交/Submit</button>
		</div>
	</div>
	<div class="overflow-auto">
		<table class="bg-light  table-sm table-striped w-100 compact" id="role_datatable">
			<thead>
				<tr class="text-light">
					<th>ID</th>
					<th>角色名称 / Role Name</th>
					<th>说明 / Description</th>
					<th>权限 / Permissions</th>
					<th>创建日期 / Date Created</th>
					<th>更新日期 / Date Updated</th>
					<th>行动 / Actions</th>
				</tr>
			</thead>
			<tfoot>
				<tr class="text-light">
					<th>ID</th>
					<th>角色名称 / Role Name</th>
					<th>说明 / Description</th>
					<th>权限 / Permissions</th>
					<th>创建日期 / Date Created</th>
					<th>更新日期 / Date Updated</th>
					<th>行动 / Actions</th>
				</tr>
			</tfoot>
		</table>
	</div>

	<!-- toast -->
	<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
		<div id="liveToast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true">
			<div class="toast-header">
				<i class="bi-info-circle"></i> <strong class="me-auto">Notifications</strong>
				<button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
			</div>
			<div class="toast-body" id='toast_msg'>
				Hello, world! This is a toast message.
			</div>
		</div>
	</div>
</main>