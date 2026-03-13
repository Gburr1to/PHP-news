<div class="container">
    <h3>Moje novice</h3>
    <?php
    foreach ($articles as $article){
        ?>
        <div class="article mb-4 p-3 border rounded">
            <h4><?php echo htmlspecialchars($article->title);?></h4>
            <p><?php echo htmlspecialchars($article->abstract);?></p>
            <p>Objavil: <?php echo htmlspecialchars($article->user->username); ?>, <?php echo date_format(date_create($article->date), 'd. m. Y \ob H:i:s'); ?></p>
            
            <div class="d-flex gap-2">
                <a href="/articles/show?id=<?php echo $article->id;?>" class="btn btn-info btn-sm">Preberi več</a>
                <a href="/articles/edit?id=<?php echo $article->id;?>" class="btn btn-primary btn-sm">Uredi</a>
                <a href="/articles/delete?id=<?php echo $article->id;?>" class="btn btn-danger btn-sm" onclick="return confirm('Ali ste prepričani, da želite izbrisati to novico?')">Izbriši</a>
            </div>
        </div>
        <?php
    }
    if(empty($articles)){
        echo "<p>Nimate še nobene objavljene novice.</p>";
    }
    ?>
</div>