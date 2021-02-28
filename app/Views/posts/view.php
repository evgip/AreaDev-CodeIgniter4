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

    <textarea rows="5" disabled="disabled" placeholder="Вы должны войти в систему, чтобы оставить комментарий." name="comment" id="comment"></textarea>
    <div> 
    <input type="submit" name="commit" value="Комментарий" class="comment-post" disabled="disabled">
    </div> 
</div>