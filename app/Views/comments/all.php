<a title="Участники" class="avatar-user right" href="/users/">
    Учасники
</a>

<h1><?= esc($title) ?></h1>

<div class="telo comments">
    <?php if (!empty($comments)) : ?>
  
        <?php foreach ($comments as  $comm ): ?>  
            <div class="voters">
                <div class="comm-up-id"></div>
                <div class="score"><?= $comm->comment_votes ?></div>
            </div>
            <div class="comm-telo">
                <div class="comm-header">
                    <img class="ava" src="/upload/users/small/<?php echo $comm->avatar ?>">
                    <span class="user"> 
                        <a href="/users/<?= esc($comm->nickname) ?>"><?= esc($comm->nickname) ?></a> 
                        
                        <?= esc($comm->date) ?>
                    </span> 
 
                    <span class="otst"> | </span>
                    <span class="date">  
                       <a href="/posts/<?= $comm->post_slug ?>"><?= esc($comm->post_title) ?></a>
                    </span>
                </div>
                <div class="comm-telo-body">
                    <?= $comm->content ?> 
                </div>
            </div>
        <?php endforeach; ?>
        
     <?php else : ?>

        <h3>Нет комментариев</h3>

        <p>К сожалению комментариев нет...</p>

    <?php endif ?>
</div> 