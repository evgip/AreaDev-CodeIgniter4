<h2><?= esc($title) ?></h2>

<?= \Config\Services::validation()->listErrors() ?>
<div class="box create">
    <form action="/posts/create" method="post">
        <?= csrf_field() ?>
        <div class="boxline">
            <label for="post_title">Заголовок</label>
            <input class="add" type="text" name="post_title" /><br />
        </div>        
        <div class="boxline">
            <label for="post_content">Текст</label>
            <textarea name="post_content"></textarea><br />
        </div>
        
        <div class="boxline">
            <label for="post_content">Теги</label>
            <input type="radio" name="tag" value="1" > cms
            <input type="radio" name="tag" value="2" > вопросы
            <input type="radio" name="tag" value="3" > флуд
        </div>
        
        
        <input type="submit" name="submit" value="Написать" />
    </form>
</div>