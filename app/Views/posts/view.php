<div class="telo detail">
    <h1 class="titl"><?= esc($posts['title']) ?></h1>
    <div class="footer">
        <img class="ava" src="/upload/users/small/<?php echo $posts['avatar'] ?>">
        <span class="user"> 
            <a href="/users/<?= esc($posts['nickname']) ?>"><?= esc($posts['nickname']) ?></a> 
        </span>
        <span class="date"> 
            <?= $posts['date'] ?>
        </span>
    </div>   
<div class="post"><?= $posts['content'] ?></div><br>

    <?php if ($auth) : ?>
    <form id="add_comm" class="new_comment" action="/comment/add" accept-charset="UTF-8" method="post">
    <?= csrf_field() ?>
        <textarea rows="5" placeholder="Напишите, что нибудь..." name="comment" id="comment"></textarea>
        <div> 
            <input type="hidden" name="post_id" id="post_id" value="<?= $posts['id'] ?>">
            <input type="submit" name="commit" value="Комментарий" class="comment-post">
        </div> 
    </form>
    <?php else : ?>
        <textarea rows="5" disabled="disabled" placeholder="Вы должны войти в систему, чтобы оставить комментарий." name="comment" id="comment"></textarea>
        <div> 
            <input type="submit" name="commit" value="Комментарий" class="comment-post" disabled="disabled">
        </div> 
    <?php endif; ?>
    
    
</div>
 
<?php if (!empty($comments)) : ?>
    <div class="telo comments">
        <h2>Комментарии</h2>
        
        <?php foreach ($comments as  $comm ): ?>
            <div class="voters">
                <a class="upvoter" href="/login"></a>
                <div class="score">1</div>
            </div>
            <div class="comm-telo">
                <div class="comm-header">
                    <img class="ava" src="/upload/users/small/<?php echo $comm->avatar ?>">
                    <span class="user"> 
                        <a href="/users/<?= esc($comm->nickname) ?>"><?= esc($comm->nickname) ?></a> 
                    </span> 
                    <span class="date">  
                       <?= esc($comm->date) ?>
                    </span>
                </div>
                <div class="comm-telo-body">
                    <?= $comm->content ?> 
                </div>
            </div>
        <?php endforeach; ?>
        
    </div>
<?php else : ?>
    <div class="telo">
        <p>К сожалению комментариев пока нет...</p>
    </div>
<?php endif ?>
  
<br>  