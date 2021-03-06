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

    <?php if($post_num_user != 0) { ?>
        <label class="required">Постов:</label>
        <span class="d">
            <a title="Всего постов <?= esc($nickname) ?>" href="/newest/<?= esc($nickname) ?>">
                <?= $post_num_user ?>
            </a>
        </span>
    <?php } ?> 
    
    <br>

    <?php if($comm_num_user != 0) { ?>
        <label class="required">Комментариев:</label>
        <span class="d">
            <a title="Все комментарии <?= esc($nickname) ?>" href="/threads/<?= esc($nickname) ?>">
                <?= $comm_num_user ?>
            </a>
        </span>
    <?php } ?>
    
        <br>

    <label class="required">О себе:</label>
    <span class="na">
        <?php if($about) { ?>
            <?= esc($about) ?>
        <?php } else { ?>
            Загадка...
        <?php } ?>
    </span>
    
</div>
 
<p> </p>