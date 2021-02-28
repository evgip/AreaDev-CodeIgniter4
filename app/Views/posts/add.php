<h2><?= esc($title) ?></h2>

<?= \Config\Services::validation()->listErrors() ?>
<div class="box">
    <form action="/posts/create" method="post">
        <?= csrf_field() ?>
        <div class="boxline">
            <label for="post_title">Заголовок</label>
            <input type="text" name="post_title" /><br />
        </div>        
        <div class="boxline">
            <label for="post_content">Текст</label>
            <textarea name="post_content"></textarea><br />
        </div>
        <input type="submit" name="submit" value="Написать" />
    </form>
</div>