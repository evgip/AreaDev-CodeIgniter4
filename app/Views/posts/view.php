<div class="telo detail">
    <h1 class="titl"><?= esc($posts['title']) ?></h1>
    <div class="footer">
        <img class="ava" src="/upload/users/small/<?php echo $posts['avatar'] ?>">
        <span class="user"> 
            <a href="/u/<?= esc($posts['nickname']) ?>"><?= esc($posts['nickname']) ?></a> 
        </span>
        <span class="date"> 
            <?= $posts['date'] ?>
        </span>
    </div>   
<div class="post"><?= $posts['content'] ?></div>

    <?php if ($auth) : ?>
    <form id="add_comm" class="new_comment" action="/comment/add" accept-charset="UTF-8" method="post">
    <?= csrf_field() ?>
        <textarea rows="5" placeholder="Напишите, что нибудь..." name="comment" id="comment"></textarea>
        <div> 
            <input type="hidden" name="post_id" id="post_id" value="<?= $posts['id'] ?>">
            <input type="hidden" name="comm_id" id="comm_id" value="0">
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
        <h2>Комментариев <?= $posts['post_comm'] ?></h2>
        
        <?php foreach ($comments as  $comm ): ?>
        <div class="block-comments">
        <?php if ($comm->level > 3) { ?> 
            <?php $indent = 3; ?>  
        <?php } else { ?> 
            <?php $indent = $comm->level; ?> 
        <?php } ?> 
  
        <ol class="comment-telo<?php if ($comm->level == 0) { ?> one<?php } ?>">
            <li class="comments_subtree">

               <?php if ($comm->comm_vote_status || $usr_id == $comm->comment_user_id) { ?>
                    <div class="voters active">
                        <div class="comm-up-id"></div>
                        <div class="score"><?= $comm->comment_votes ?></div>
                    </div>
                <?php } else { ?>
                    <div id="vot<?php echo $comm->comment_id ?>" class="voters">
                        <div data-csrf_name="<?= csrf_token() ?>" data-csrf="<?= csrf_hash() ?>" data-id="<?php echo $comm->comment_id ?>" class="comm-up-id"></div>
                        <div class="score"><?= $comm->comment_votes ?></div>
                    </div>
                <?php } ?>

                <div class="comm-telo">
                    <div class="comm-header">
                        <img class="ava" src="/upload/users/small/<?php echo $comm->avatar ?>">
                        <span class="user"> 
                            <a href="/u/<?= esc($comm->nickname) ?>"><?= esc($comm->nickname) ?></a> 
                        </span> 
                        <span class="date">  
                           <?= esc($comm->date) ?>
                        </span>
                        
                        <span class="date">  
                          . #id<?= $comm->comment_id ?>
                        </span>
                    </div>
                    <div class="comm-telo-body">
                        <?= $comm->content ?> 
                    </div>
                </div>
                <span id="cm_add_link<?= $comm->comment_id ?>" class="cm_add_link">
                    <a data-post_id="<?= $posts['id'] ?>" data-id="<?= $comm->comment_id ?>" data-csrf_name="<?= csrf_token() ?>" data-csrf="<?= csrf_hash() ?>" class="addcomm">Ответить</a>
                </span>
              level: <?= $comm->level ?>
                <div id="cm_addentry<?= $comm->comment_id ?>" class="reply"></div> 
            
      
            <?php if ($indent == 0) { ?>
            
            <?php if ($comm->after == 0) { ?></li></ol><?php } else { ?><?php } ?>
            
            <?php } ?>
        
      
            <!-- Чтобы понять логику, пока пишем так -->
            <?php if ($indent == 1) { ?>  
                <?php if ($comm->after == 0) { ?></li></ol></li></ol><?php } else { ?></li></ol><?php } ?>
            <?php } ?> 
             
            <?php if ($indent == 2) { ?>  
               <?php if ($comm->after == 0) { ?></li></ol></li></ol></li></ol><?php } else { ?></li></ol></li></ol><?php } ?>
            <?php } ?>  
             
            <?php if ($indent == 3) { ?>  
                <?php if ($comm->after == 0) { ?></li></ol></li></ol></li></ol></li></ol><?php } else { ?></li></ol></li></ol></li></ol><?php } ?>
            <?php } ?>   
             
            
        
        
        </div>
        <?php endforeach; ?>
         
    </div>
<?php else : ?>
    <div class="telo">
        <p>К сожалению комментариев пока нет...</p>
    </div>
<?php endif ?>
  
<br>  