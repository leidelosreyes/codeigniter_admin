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
        <h4 id="crud_label">Add/Edit Permission</h4>
        <form class="row">
            <div class="mb-3 col-md-6">
                <label for="controller_method" class="form-label">控制器/方法 / Controller/Method</label>
                <input type="text" class="form-control" id="controller_method">
                <div id="controller_methodtext" class="form-text">输入控制器和方法。 / Enter Controller and Method.</div>
            </div>
            <div class="mb-3 col-md-6">
                <label for="perm_desc" class="form-label">说明 / Description</label>
                <input type="text" class="form-control" id="perm_desc">
                <div id="perm_desctext" class="form-text">输入说明 / Enter Description</div>
            </div>
            <h6>用户指南 / Userguide</h6>
            <ul class="list-unstyled">
                <li>控制器和方法的名称是区分大小写的 / The name of the controller and method is case sensitive</li>
            </ul>
            <input type="hidden" id="action_type" value="add/123456">
        </form>
        <div class="spin w-100 h-100 position-absolute d-none">
            <div class="permission-spinner spinner-border " role="status">
                <span class="sr-only"></span>
            </div>
        </div>
        <div class="mb-3 col-12 text-end">
            <button onclick="b_cancel()" class="btn btn-secondary">取消/Cancel</button>
            <button onclick="b_submit()" class="btn btn-primary">提交/Submit</button>
        </div>
    </div>
    <div class="overflow-auto">
        <table class="bg-light  table-sm table-striped w-100 compact" id="permission_datatable">
            <thead>
                <tr class="text-light">
                    <th>ID</th>
                    <th>控制器/方法 / Controller/Method</th>
                    <th>说明 / Description</th>
                    <th>创建日期 / Date Created</th>
                    <th>更新日期 / Date Updated</th>
                    <th>行动 / Actions</th>
                </tr>
            </thead>
            <tfoot>
                <tr class="text-light">
                    <th>ID</th>
                    <th>控制器/方法 / Controller/Method</th>
                    <th>说明 / Description</th>
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