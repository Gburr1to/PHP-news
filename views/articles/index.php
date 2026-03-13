<div class="container">
    <h3>Seznam novic</h3>
    <?php
    if (empty($articles)) {
        echo "<p>Trenutno ni nobene objavljene novice.</p>";
    } else {
        foreach ($articles as $article) {
            ?>
            <div class="article mb-4 p-3 border rounded">
                <h4><?php echo htmlspecialchars($article->title); ?></h4>
                <p><?php echo htmlspecialchars($article->abstract); ?></p>
                <p>Objavil: <?php echo htmlspecialchars($article->user->username); ?>, <?php echo date_format(date_create($article->date), 'd. m. Y \ob H:i:s'); ?></p>
                <a href="/articles/show?id=<?php echo $article->id; ?>" class="btn btn-info btn-sm">Preberi več</a>
            </div>
            <?php
        }
    }
    ?>
</div>