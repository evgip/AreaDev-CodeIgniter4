<?php $this->config = config('Auth'); $redirect = $this->config->assignRedirect;?>

<h1>Настройка профиля <?= esc(session()->get('nickname')); ?></h3>

<img alt="Профиль" src="/upload/users/<?php echo $usr_avatar ?>">

<?php $validation = \Config\Services::validation(); ?>
<?php if (session()->get('success')) : ?>
    <div class="alert alert-success alert-dismissible" role="alert">
        <?= session()->get('success'); ?>
    </div>
<?php endif; ?>   
 <div class="box wide">
    <form action="/setting" method="post" enctype="multipart/form-data">
        <div class="boxline">
            <label for="name">Имя</label>
            <input type="text" class="form-control" name="name" id="name" value="<?= set_value('name', session()->get('name')) ?>">
            <?php if ($validation->getError('name')) { ?>
                <div class='alert alert-danger mt-2'>
                    <?= $error = $validation->getError('name'); ?>
                </div>
            <?php } ?>
        </div>
        <div class="boxline">
            <label for="email">Email</label>
            <input type="text" class="form-control" name="email" id="email" value="<?= set_value('email', session()->get('email')) ?>">
            <?php if ($validation->getError('email')) { ?>
                <div class='alert alert-danger mt-2'>
                    <?= $error = $validation->getError('email'); ?>
                </div>
            <?php } ?>
        </div>
        <div class="boxline">
            <label for="password">Пароль</label>
            <input type="password" class="form-control" name="password" id="password" value="">
            <?php if ($validation->getError('password')) { ?>
                <div class='alert alert-danger mt-2'>
                    <?= $error = $validation->getError('password'); ?>
                </div>
            <?php } ?>
        </div>
        <div class="boxline">
            <label for="password_confirm">Повторите пароль</label>
            <input type="password" class="form-control" name="password_confirm" id="password_confirm" value="">
            <?php if ($validation->getError('password_confirm')) { ?>
                <div class='alert alert-danger mt-2'>
                    <?= $error = $validation->getError('password_confirm'); ?>
                </div>
            <?php } ?>
        </div>
        <div class="boxline">
            <label for="about">О себе</label>
            <input type="text" class="form-about" name="about" id="about" value="<?= set_value('about', session()->get('about')) ?>">
            <?php if ($validation->getError('about')) { ?>
                <div class='alert alert-danger mt-2'>
                    <?= $error = $validation->getError('about'); ?>
                </div>
            <?php } ?>
        </div>
        <div class="boxline">
            <input id="fileInput" name="image" accept="image/*" type="file" />
        </div>
        
        <div class="boxline">
            <input type="hidden" name="nickname" id="nickname" value="<?= esc(session()->get('nickname')); ?>">
            <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" /> 
            <button type="submit" class="btn btn-primary">Изменить</button>
        </div>
        
    </form>
</div>
  