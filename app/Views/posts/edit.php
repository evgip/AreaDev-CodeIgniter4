<link rel="stylesheet" href="/assets/css/select2.css">
<script src="/assets/js/select2.min.js"></script>

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
            <select name="tag" class="js-example-placeholder-multiple js-states form-control" multiple="multiple">
                <?php foreach ($post['tag'] as  $tag ) { ?>
                    <option selected="selected" name="tag" value="<?= $tag->tags_id ?>">
                        <?= $tag->tags_name ?>
                    </option>
                <?php } ?>
            </select>
              <br>  Теги не работают, показан изначальный выбор.<br> 
                
                1- cms,  
                2 - вопросы, 
                3 - флуд 
        </div>
        
        <input type="submit" name="submit" value="Изменить" />
    </form>
</div>

<script {csp-script-nonce}>
    $(".js-example-placeholder-multiple").select2({
            tags: true,
            tokenSeparators: [',', ' '],
            placeholder: {
            text: 'Выберите теги'
        }
    });
</script>