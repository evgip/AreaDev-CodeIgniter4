<div class="gravatar">
    <img src="/upload/users/<?php echo $avatar; ?>">
</div>

<h1><?= esc($nickname) ?> / <?= esc($name) ?></h1>

<div class="box wide">
    <label class="required">Профиль:</label>
    <span class="d">id:<?= $id; ?></span>

    <br>
    
    <label class="required">Присоединился::</label>
    <span class="d"><?= $created_at; ?></span>

    <br>

    <label class="required">О себе:</label>
    <span class="d"><?= esc($about) ?></span>
</div>
 
<p>`````</p>