<?php $this->config = config('Auth'); $redirect = $this->config->assignRedirect;?>

<h3><?php echo session()->get('nickname') . ' ' . session()->get('name') ?></h3>

<img alt="" src="/upload/users/small/<?php print_r($usr_avatar) ?>" border="0">

<?php $validation = \Config\Services::validation(); ?>
<?php if (session()->get('success')) : ?>
    <div class="alert alert-success alert-dismissible" role="alert">
        <?= session()->get('success'); ?>
    </div>
<?php endif; ?>   

<form action="/setting" method="post" enctype="multipart/form-data">
     
    <div class="form-group">
        <label for="nickname">Ник</label>
        <input disabled type="text" class="form-control" name="nickname" id="nickname" value="<?= set_value('nickname', session()->get('nickname')) ?>">
        <?php if ($validation->getError('nickname')) { ?>
            <div class='alert alert-danger mt-2'>
                <?= $error = $validation->getError('nickname'); ?>
            </div>
        <?php } ?>
    </div>
    <div class="form-group">
        <label for="name">Имя</label>
        <input type="text" class="form-control" name="name" id="name" value="<?= set_value('name', session()->get('name')) ?>">
        <?php if ($validation->getError('name')) { ?>
            <div class='alert alert-danger mt-2'>
                <?= $error = $validation->getError('name'); ?>
            </div>
        <?php } ?>
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="text" class="form-control" name="email" id="email" value="<?= set_value('email', session()->get('email')) ?>">
        <?php if ($validation->getError('email')) { ?>
            <div class='alert alert-danger mt-2'>
                <?= $error = $validation->getError('email'); ?>
            </div>
        <?php } ?>
    </div>
    <div class="form-group">
        <label for="password">Пароль</label>
        <input type="password" class="form-control" name="password" id="password" value="">
        <?php if ($validation->getError('password')) { ?>
            <div class='alert alert-danger mt-2'>
                <?= $error = $validation->getError('password'); ?>
            </div>
        <?php } ?>
    </div>
    <div class="form-group">
        <label for="password_confirm">Повторите пароль</label>
        <input type="password" class="form-control" name="password_confirm" id="password_confirm" value="">
        <?php if ($validation->getError('password_confirm')) { ?>
            <div class='alert alert-danger mt-2'>
                <?= $error = $validation->getError('password_confirm'); ?>
            </div>
        <?php } ?>
    </div>
    <div class="form-group">
        <input id="fileInput" name="image" accept="image/*" type="file" />
    </div>
    <div class="form-group">
        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" /> 
        <button type="submit" class="btn btn-primary">Изменить</button>
    </div>
</form>

  