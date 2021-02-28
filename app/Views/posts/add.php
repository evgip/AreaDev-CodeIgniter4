<h2><?= esc($title) ?></h2>

<?= \Config\Services::validation()->listErrors() ?>

<form action="/posts/create" method="post">
    <?= csrf_field() ?>

    <label for="post_title">Заголовок</label>
    <input type="input" name="post_title" /><br />

    <label for="post_content">Текст</label>
    <textarea name="post_content"></textarea><br />

    <input type="submit" name="submit" value="Написать" />
</form>