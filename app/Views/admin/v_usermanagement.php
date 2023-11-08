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
        <h4 id="crud_label">Add/Edit User</h4>
        <form class="row">
            <div class="mb-3 col-md-6">
                <label for="username" class="form-label">用户名 / Username</label>
                <input type="text" class="form-control" id="username">
                <div id="usertext" class="form-text">输入您的用户名 / Enter your Username.</div>
            </div>
            <div class="mb-3 col-md-6">
                <label for="email" class="form-label">电子邮件 / Email</label>
                <input type="text" class="form-control" id="email">
                <div id="emailtext" class="form-text">输入您的电子邮件 / Enter your Email.</div>
            </div>
            <div class="mb-3 col-md-6">
                <label for="password" class="form-label">密码 / Password</label>
                <input type="password" class="form-control" id="password">
                <div id="passtext" class="form-text">输入密码 / Enter password.</div>
            </div>
            <div class="mb-3 col-md-6">
                <label for="passconf" class="form-label">密码确认 / Password Confirmation</label>
                <input type="password" class="form-control" id="passconf">
                <div id="passtext" class="form-text">输入密码确认 / Enter password confirmation.</div>
            </div>
            <div class="mb-3 col-md-6">
                <label for="role_id" class="form-label">用户角色 / User Role</label>
                <select id="role_id" class="form-select">
                    <?php
                    foreach ($roles_list as $row) {
                    ?>
                        <option value="<?php echo $row['id']; ?>"><?php echo $row['role_name']; ?></option>
                    <?php
                    }
                    ?>
                </select>
                <div id="roletext" class="form-text">选择用户角色 / Select user role.</div>
            </div>
            <div class="mb-3 col-md-6">
                <label for="gsecret" class="form-label">谷歌认证码 / Google Auth Key</label>
                <input type="text" class="form-control" id="gsecret" disabled>
                <div id="gsecrettext" class="form-text"><a href="#" onclick="b_gcode()">点击这里，生成谷歌认证代码。 / Click here to generate Google Authentication code.</a></div>
                <img class="mt-2" src="" id="gimg">
            </div>

            <h6>用户指南 / Userguide</h6>
            <ul class="list-unstyled">
                <li>添加新记录需要所有字段。 / Adding New record requires all fields.</li>
                <li>编辑模式不需要填写密码。如果密码字段被填入，它将触发密码更改。 / Edit mode does not require password field to be filled. IF password field is filled, it will trigger a password change.</li>
                <li>在您按下提交键之前，一切都不会被保存。 / Nothing is saved until you press submit.</li>
            </ul>
            <input type="hidden" id="action_type" value="add/123456">
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
        <table class="bg-light table-sm table-striped w-100 compact" id="user_datatable">
            <thead>
                <tr class="text-light">
                    <th>ID</th>
                    <th>用户名 / Username</th>
                    <th>电子邮件 / Email</th>
                    <th>谷歌认证码 / GAuth Key</th>
                    <th>用户角色 / User Role</th>
                    <th>创建日期 / Date Created</th>
                    <th>更新日期 / Date Updated</th>
                    <th>行动 / Actions</th>
                </tr>
            </thead>
            <tfoot>
                <tr class="text-light">
                    <th>ID</th>
                    <th>用户名 / Username</th>
                    <th>电子邮件 / Email</th>
                    <th>谷歌认证码 / GAuth Key</th>
                    <th>用户角色 / User Role</th>
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
<script>
    var roles_list = <?php echo json_encode($roles_list); ?>;
</script>