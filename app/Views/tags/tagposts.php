    <?php   $i=0; 
            foreach ($posts as $tags) {  
            $i++;
            if($i==2)break; ?>

     <h1><?= esc($title) ?>:   <?= esc($tags->tags_name) ?></h1>
        <!--?= esc($tags->tags_description) ?-->
    <?php } ?>

<div class="telo comments">
    <?php if (!empty($posts)) : ?>
  
        <?php foreach ($posts as  $post) { ?> 
        
               <!--?php print_r ($post)  ?--> 
            <div id="vot<?php echo $post->post_id ?>" class="voters">
                <div data-csrf_name="<?= csrf_token() ?>" data-csrf="<?= csrf_hash() ?>" data-id="<?php echo $post->post_id ?>" class="post-up-id"></div>
                <div class="score"><?= $post->post_votes ?></div>
          
            </div>
            <div class="post-telo">
                <a class="u-url" href="/posts/<?= $post->post_slug ?>">
                    <h3 class="titl"><?= esc($post->post_title) ?></h3>
                </a>
  
                <div class="footer">
                    <img class="ava" src="/upload/users/small/<?= $post->avatar ?>">
                    <span class="user"> 
                        <a href="/u/<?= $post->nickname ?>"><?= $post->nickname ?></a> 
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
        <?php } ?>

    <?php else : ?>

        <h3>Нет постов (в разработке)</h3>

        <p>К сожалению поcтов по данному тегу нет...</p>

    <?php endif ?>
</div> 