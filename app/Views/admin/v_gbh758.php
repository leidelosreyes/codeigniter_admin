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
		<h4 id="crud_label">添加/编辑配置</h4>
		<form class="row">
		<div class="mb-3 col-md-6">
				<label for="item" class="form-label">物品 / Item</label>
				<input type="text" class="form-control" id="item">
				<div id="itemtext" class="form-text">输入项目</div>
				<label for="title" class="form-label">标题 / title</label>
				<textarea class="form-control" id="title"></textarea>
				<div id="titletext" class="form-text">输入标题</div>
				<h6>用户指南 / Userguide</h6>
			<ul class="list-unstyled">
				<li>除非您确定效果，否则请勿删除任何内容。</li>
			</ul>
			</div>
			<div class="mb-3 col-md-6">
				<label for="value" class="form-label">关联 / Link</label>
				<textarea class="form-control" id="value" style="width: 100%; height: 300px; font-size: 16px; resize: both;"></textarea>
				<div id="valuetext" class="form-text">输入链接</div>
			</div>
			<input type="hidden" id="action_type" value="add/123456">
		</form>
		<div class="spin w-100 h-100 position-absolute d-none">
			<div class="sys-spinner spinner-border " role="status">
				<span class="sr-only"></span>
			</div>
		</div>
		<div class="mb-3 col-12 text-end">
			<button onclick="b_cancel()" class="btn btn-secondary">取消/Cancel</button>
			<button onclick="b_submit()" class="btn btn-primary">提交/Submit</button>
		</div>
	</div>
	<div class="overflow-auto">
		<table class="bg-light  table-sm table-striped w-100 compact" id="gbh758_datatable">
			<thead>
				<tr class="text-light">
					<th>ID</th>
					<th>物品 / item</th>
					<th>关联 / link</th>
					<th>标题 / title</th>
					<th>创建日期 / Date Created</th>
					<th>更新日期 / Date Updated</th>
					<th>行动 / Actions</th>
				</tr>
			</thead>
			<tfoot>
				<tr class="text-light">
                    <th>ID</th>
					<th>物品 / item</th>
					<th>关联 / link</th>
					<th>标题 / title</th>
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