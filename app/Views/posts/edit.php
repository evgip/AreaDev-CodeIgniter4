<h2><?= esc($title) ?></h2>

<?= \Config\Services::validation()->listErrors() ?>
<div class="box create">
    <form action="/posts/edit/<?= $post['id'] ?>" method="post">
        <?= csrf_field() ?>
        <div class="boxline">
            <label for="post_title">Заголовок</label>
            <input class="add" type="text" value="<?= $post['title'] ?>" name="post_title" /><br />
        </div>        
        <div class="boxline">
            <label for="post_content">Текст</label>
            <textarea name="post_content"><?= $post['content'] ?></textarea><br />
        </div>
        
        <div class="boxline">
            <label for="post_content">Теги</label>
            <input type="radio" name="tag" value="1" > не работают! Просто выберите меня
        </div>
        
        <input type="submit" name="submit" value="Изменить" />
    </form>
</div>