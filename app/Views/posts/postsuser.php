<a title="Участники" class="avatar-user right" href="/users/">
    Участники
</a>
<h1 class="top"><?= esc($title) ?></h1>

<div class="telo posts">
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
                
                <?php foreach ($post->tags as  $tag ): ?>                
                    <a class="tag tag_<?= $tag->tags_tip ?>" href="/t/<?= esc($tag->tags_slug) ?>" title="<?= esc($tag->tags_name) ?>">
                        <?= esc($tag->tags_name) ?>
                    </a>
                <?php endforeach; ?>
                
                <div class="footer">
                    <img class="ava" src="/upload/users/small/<?php echo $post->avatar ?>">
                    <span class="user"> 
                        <a href="/u/<?= esc($post->nickname) ?>"><?= esc($post->nickname) ?></a> 
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

        <h3>Нет комментариев</h3>

        <p>К сожалению комментариев нет...</p>

    <?php endif ?>
</div> 