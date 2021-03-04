<a title="Участники" class="avatar-user right" href="/users/">
    Участники
</a>
 
<h1><?= esc($title) ?></h1>

<div class="telo">
    <?php if (!empty($posts)) : ?>
  
        <?php foreach ($posts as  $post ): ?>
        
            <div id="vot<?php echo $post->post_id ?>" class="voters">
                <div data-csrf_name="<?= csrf_token() ?>" data-csrf="<?= csrf_hash() ?>" data-id="<?php echo $post->post_id ?>" class="post-up-id"></div>
                <div class="score"><?= $post->post_votes ?></div>
          
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
                        комментариев (<?= $post->post_comments ?>) 
                        
                         
                    <?php } ?>
                </div>  
            </div>
        <?php endforeach; ?>

    <?php else : ?>

        <h3>Нет постов</h3>

        <p>К сожалению постов нет...</p>

    <?php endif ?>
</div> 