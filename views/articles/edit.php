<div class="container">
    <h3 class="mb-3">Uredi novico</h3>
    <form action="/articles/update" method="POST">
        <input type="hidden" name="id" value="<?php echo $article->id; ?>">
        <div class="mb-3">
            <label for="article-title" class="form-label">Naslov</label>
            <input type="text" class="form-control" id="article-title" name="article-title" value="<?php echo htmlspecialchars($article->title); ?>">
        </div>
        <div class="mb-3">
            <label for="article-abstract" class="form-label">Povzetek</label>
            <textarea class="form-control" id="article-abstract" name="article-abstract" rows="5"><?php echo htmlspecialchars($article->abstract); ?></textarea>
        </div>
        <div class="mb-3">
            <label for="article-story" class="form-label">Vsebina novice</label>
            <textarea class="form-control" id="article-story" name="article-story" rows="5"><?php echo htmlspecialchars($article->text); ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Shrani spremembe</button>
        <a href="/articles/list" class="btn btn-secondary">Prekliči</a>
        <label class="text-danger"><?php echo isset($error) ? $error : ""; ?></label>
    </form>
</div>