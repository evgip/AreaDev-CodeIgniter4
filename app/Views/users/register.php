<h1 class="head">Регистрация</h1>
<?php $validation = \Config\Services::validation(); ?>
<div class="box wide">
    <form class="" action="register" method="post">
        <?= csrf_field() ?>
        <div class="boxline">
            <label for="nickname">Никнейм</label>
            <input type="text" name="nickname" id="nickname" value="<?= set_value('nickname') ?>">
            <?php if ($validation->getError('nickname')) { ?>
                <div class='alert alert-danger mt-2'>
                    <?= $error = $validation->getError('nickname'); ?>
                </div>
            <?php } ?>
        </div>
        <div class="boxline">
            <label for="name">Имя</label>
            <input type="text" name="name" id="name" value="<?= set_value('name') ?>">
            <?php if ($validation->getError('name')) { ?>
                <div class='alert alert-danger mt-2'>
                    <?= $error = $validation->getError('name'); ?>
                </div>
            <?php } ?>
        </div>
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
         <div class="boxline">
            <label for="password_confirm">Повторите пароль</label>
            <input type="password" name="password_confirm" id="password_confirm" value="">
            <?php if ($validation->getError('password_confirm')) { ?>
                <div class='alert alert-danger mt-2'>
                    <?= $error = $validation->getError('password_confirm'); ?>
                </div>
            <?php } ?>
        </div>                    
        <div class="boxline">
            <div class="boxline">
                <button type="submit" class="button-primary">Регистрация</button>
            </div>
            <div class="boxline">
                <a href="/login">Войти</a>
            </div>
        </div>
    </form>
</div>