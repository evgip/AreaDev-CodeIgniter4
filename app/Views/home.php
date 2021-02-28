<a title="Участники" class="avatar-user right" href="/users/">
    <svg class="md-icon moon">
        <use xlink:href="/assets/icons/icons.svg#user"></use>
    </svg>
</a>

<h1><?= esc($title) ?></h1>

<div class="telo">
    <?php if (!empty($posts)) : ?>
  
        <?php foreach ($posts as $post_item): ?>
            <div class="voters">
                <a class="upvoter" href="/login"></a>
                <div class="score">3</div>
            </div>
        
            <div class="post-telo">
                <a class="u-url" href="/posts/<?= esc($post_item['post_slug'], 'url') ?>">
                    <h3 class="titl"><?= esc($post_item['post_title']) ?></h3>
                </a>

                <div class="footer">
                    <img class="ava" src="/upload/users/small/<?php echo $post_item['avatar'] ?>">
                    <span class="user"> 
                        <a href="/users/<?= esc($post_item['nickname']) ?>"><?= esc($post_item['nickname']) ?></a> 
                    </span>
                    <span class="date"> 
                        <?= $post_item['post_date'] ?>
                    </span>
                </div>  
            </div>
        <?php endforeach; ?>

    <?php else : ?>

        <h3>Нет постов</h3>

        <p>К сожалению постов нет...</p>

    <?php endif ?>
</div> 