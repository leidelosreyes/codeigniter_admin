<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mb-5">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2"><?php echo $pagetitle; ?></h1>
        <div id="spineradmin" class="spin w-100 h-100 position-absolute d-none">
            <div class="teleadmin-spinner spinner-border " role="status">
                <span class="sr-only"></span>
            </div>
        </div>
    </div>
    <div id="crud_form" style="display: none;">
        <h4 id="crud_label">編輯網址</h4>
        <form class="row">
            <div class="mb-3 col-md-6">
                <label for="text" class="form-label">網址</label>
                <input type="text" class="form-control" id="url">
                <div id="text" class="form-text">輸入網址。.</div>
            </div>
            <input type="hidden" id="action_type">
        </form>
        <div class="spin w-100 h-100 position-absolute d-none">
            <div class="user-spinner spinner-border " role="status">
                <span class="sr-only"></span>
            </div>
        </div>
        <div class="mb-3 col-12 text-end">
            <button onclick="b_cancel()" class="btn btn-secondary">取消/Cancel</button>
            <button onclick="b_submit()" class="btn btn-primary">提交/Submit</button>
        </div>
    </div>
    <div class="overflow-auto">
        <table class="bg-light  table-sm table-striped w-100 compact" id="url_datatable">
            <thead>
                <tr class="text-light">
                    <th>ID</th>
                    <th>手机号码 / Url</th>
                    <th>创建日期 / Date Created</th>
                    <th>行动 / Actions</th>
                </tr>
            </thead>
            <tfoot>
                <tr class="text-light">
                    <th>ID</th>
                    <th>手机号码 / Url</th>
                    <th>创建日期 / Date Created</th>
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