<!-- obrazec za vnos polj -->
<div class="container">
    <h3 class="mb-3">Objavi novico</h3>
    <form action="/articles/store" method="POST">
        <div class="mb-3">
            <label for="article-title" class="form-label">Naslov</label>
            <input type="text" class="form-control" id="article-title" name="article-title" value="<?php echo isset($_POST["article-title"]) ? htmlspecialchars($_POST["article-title"]): ""; ?>">
        </div>
        <div class="mb-3">
            <label for="article-abstract" class="form-label">Povzetek</label>
            <textarea class="form-control" id="article-abstract" name="article-abstract" rows="5"><?php echo isset($_POST["article-abstract"]) ? htmlspecialchars($_POST["article-abstract"]) : ""; ?></textarea>
        </div>
        <div class="mb-3">
            <label for="article-story" class="form-label">Vsebina novice</label>
            <textarea class="form-control" id="article-story" name="article-story" rows="5"><?php echo isset($_POST["article-story"]) ? htmlspecialchars($_POST["article-story"]) : ""; ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Objavi novico!</button>
        <label class="text-danger"><?php echo isset($error) ? $error : ""; ?></label>
    </form>
</div>