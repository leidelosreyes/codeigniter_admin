<main class="col-md-9 ms-sm-auto col-lg-10 px-md-5 mb-5">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom bg-light">
        <h2 class="h2"><?php echo $pagetitle; ?> <a href="javascript: reloadPage();"><i class="bi-arrow-clockwise"></i></a></h2>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
            </div>
        </div>
    </div>

    <div id="crud_form">
        <h4 id="crud_label">用户资料 / User Info</h4>
        <form class="profile row bg-light py-3 mb-3 mx-1">
            <div class="mb-3 col-md-6">
                <label for="username" class="form-label">用户名 / Username</label>
                <input type="text" class="form-control" id="username" value="<?php echo $userdata['username'] ?>" disabled>
                <div id="usertext" class="form-text">输入您的用户名 / Enter your Username.</div>
            </div>
            <div class="mb-3 col-md-6">
                <label for="email" class="form-label">电子邮件 / Email</label>
                <input type="text" class="form-control" id="email" value="<?php echo $userdata['email'] ?>">
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
                <label for="gsecret" class="form-label">谷歌认证码 / Google Auth Key</label>
                <input type="text" class="form-control" id="gsecret" value="<?php echo $userdata['gsecret'] ?>" disabled>
                <div id="gsecrettext" class="form-text"><a href="#" onclick="b_gcode()">点击这里，生成谷歌认证代码。 / Click here generate Google Authentication code.</a></div>
                <img class="mt-2" src="" id="gimg">
            </div>

            <h6>用户指南 / Userguide</h6>
            <ul class="list-unstyled">
                <li>在您按下提交键之前，一切都不会被保存。 / Nothing is saved until you press submit.</li>
                <li>填写密码区域将会更改密码。 / Filling up the password field will trigger a password change.</li>
            </ul>
            <input type="hidden" id="action_type" value="<?php echo $userdata['id'] ?>">
        </form>
        <div class="spin w-100 h-100 position-absolute d-none">
            <div class="profile-spinner spinner-border " role="status">
                <span class="sr-only"></span>
            </div>
        </div>
        <div class="mb-3 col-12 text-end">

            <button onclick="b_submit()" class="btn btn-primary">提交/Submit</button>
        </div>
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