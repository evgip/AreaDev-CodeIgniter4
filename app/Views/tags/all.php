<h1><?= esc($title) ?></h1>

<div class="telo tags">
    <?php if (!empty($tags)) : ?>
  
        <?php foreach ($tags as  $tag ): ?>  
            <div class="tag-telo">
                <span class="date"> 
                    <a title="<?= esc($tag->name) ?>" class="tag tag_<?= $tag->tip ?>" href="/t/<?= esc($tag->slug) ?>">
                        <?= esc($tag->name) ?>
                    </a> 
                </span> 
                <span class="date tag-des">  
                    <?= esc($tag->description) ?>    
                </span>
            </div>
        <?php endforeach; ?>

    <?php else : ?>

        <h3>Нет тегов</h3>

        <p>К сожалению тегов нет...</p>

    <?php endif ?>
</div> 