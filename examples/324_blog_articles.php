<?php
require_once(__DIR__ . '/bootstrap.php');
require_once(__DIR__ . '/include/checkAuth.php');
?>
<!DOCTYPE html>
<html>
<head>
<?php require_once(__DIR__ . '/include/header.php'); ?>
</head>
<body>
<div class="container">
    <?php require_once(__DIR__ . '/include/top.php'); ?>
    <h1 class="page-header">取得指定文章之留言</h1>
    <h3>呼叫方式</h3>
    <pre>$pixapi->blog->articles->comments($id, $options = array());</pre>
    <div class="well"><a href="http://developer.pixnet.pro/#!/doc/pixnetApi/blogArticlesComments" target="blank">Options說明</a></div>
    <h3>實際測試</h3>
    <form class="form-inline" role="form" method="POST">
      <div class="form-group">

          <select class="form-control" id="query" name="query">
          <?php
          $articles = $pixapi->blog->articles->latest(array('limit' => 5));
          foreach ($articles as $article) {
            if ($article['id'] > 0) {
          ?>
              <option value="<?= $article['id'] ?>" <?= ($query == $article['id']) ? 'selected' : ''; ?>><?= $article['title'] ?></option>
          <?php
            }
          }
          ?>
          </select>
          (只顯示最新5筆)
      </div>
      <button type="submit" class="btn btn-primary">查詢</button>
    </form>
    <?php
        $query = $_POST['query'];
        if ('' != $query) {
    ?>
    <h3>執行</h3>
    <pre>$pixapi->blog->articles->comments(<?= $query; ?>);</pre>
    <h3>執行結果</h3>
    <pre><?php print_r($pixapi->blog->articles->comments($query)); ?></pre>
    <?php
        }
    ?>
</div>
</body>
</html>