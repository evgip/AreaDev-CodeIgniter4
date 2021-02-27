<h1 class="head">Вход</h1>

<?php $validation = \Config\Services::validation(); ?>
<?php if (session()->get('success')) : ?>
    <div class="alert alert-success" role="alert">
        <?= session()->get('success'); ?>
    </div>
<?php endif; ?>
<?php if (session()->get('danger')) : ?>
    <div class="alert alert-danger" role="alert">
        <?= session()->get('danger'); ?>
        <?php if (session()->get('resetlink')) {
            echo session()->get('resetlink');
        } ?>
    </div>
<?php endif; ?>
<div class="box wide">
    <form class="" action="/login" method="post">
        <?= csrf_field() ?>
        <div class="boxline">
            <label for="email">Email</label>
            <input type="text" name="email" id="email" value="<?= set_value('email') ?>">
            <?php if ($validation->getError('email')) { ?>
                <div class='alert alert-danger mt-2'>
                    <?= $error = $validation->getError('email'); ?>
                </div>
            <?php } ?>
        </div>
        <div class="boxline">
            <label for="password">Пароль</label>
            <input type="password" name="password" id="password" value="">
            <?php if ($validation->getError('password')) { ?>
                <div class='alert alert-danger mt-2'>
                    <?= $error = $validation->getError('password'); ?>
                </div>
            <?php } ?>
        </div>
        <?php if ($config->rememberMe) : ?>
            <div class="boxline">
                <input type="checkbox" id="rememberme" name="rememberme" value="1">
                <label class="form-check-label" for="rememberme">Запомнить меня</label>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="boxline">
                <button type="submit" class="button-primary">Войти</button>
            </div>
            <div class="boxline">
                <a href="/register">Регистрация</a> &emsp;
                <a href="/forgotpassword">Забыли пароль?</a>
            </div>
        </div>
    </form>
</div>