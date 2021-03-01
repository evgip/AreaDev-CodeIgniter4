<a title="Участники" class="avatar-user right" href="/users/">
    <svg class="md-icon moon">
        <use xlink:href="/assets/icons/icons.svg#user"></use>
    </svg>
</a>

<h1><?= esc($title) ?></h1>

<div class="telo">
    <?php if (!empty($posts)) : ?>
  
        <?php foreach ($posts as  $post ): ?>
            <div class="voters">
                <a class="upvoter" href="/login"></a>
                <div class="score">3</div>
            </div>
        
            <div class="post-telo">
                <a class="u-url" href="/posts/<?= $post->slug ?>">
                    <h3 class="titl"><?= esc($post->title) ?></h3>
                </a>

                <div class="footer">
                    <img class="ava" src="/upload/users/small/<?php echo $post->avatar ?>">
                    <span class="user"> 
                        <a href="/users/<?= esc($post->nickname) ?>"><?= esc($post->nickname) ?></a> 
                    </span>
                    <span class="date"> 
                        <?= $post->date ?>
                    </span>
                    <?php if($post->post_comments !=0) { ?> 
                        <span class="otst"> | </span>
                        <?= $post->post_comments ?> комментария 
                    <?php } ?>
                </div>  
            </div>
        <?php endforeach; ?>

    <?php else : ?>

        <h3>Нет постов</h3>

        <p>К сожалению постов нет...</p>

    <?php endif ?>
</div> 