<a title="Участники" class="avatar-user right" href="/users/">
    <svg class="md-icon moon">
        <use xlink:href="/assets/icons/icons.svg#user"></use>
    </svg>
</a>

<h1><?= esc($title) ?></h1>

<div class="telo comments">
    <?php if (!empty($comments)) : ?>
  
        <?php foreach ($comments as  $comm ): ?>  
            <div class="voters">
                <a class="upvoter" href="/login"></a>
                <div class="score">2</div>
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