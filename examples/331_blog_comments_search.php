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
    <h1 class="page-header">讀取單一留言</h1>
    <h3>呼叫方式</h3>
    <pre>$pixapi->blog->comments->search($id);</pre>
    <h3>實際測試</h3>
    <form class="form-inline" role="form" method="POST">
      <div class="form-group">
          <?php
          $comments = $pixapi->blog->comments->search();
          ?>
          <select class="form-control" id="query" name="query">
          <?php
          foreach ($comments as $comments) {
          ?>
              <option value="<?= $comments['id'] ?>" <?= ($query == $comments['id']) ? 'selected' : ''; ?>><?= $comments['body'] ?></option>
          <?php
          }
          ?>
          </select>
      </div>
      <button type="submit" class="btn btn-primary">讀取單一留言</button>
    </form>
    <?php
        $query = $_POST['query'];
        if ('' != $query) {
    ?>
    <h3>執行</h3>
    <pre>$pixapi->blog->comments->search('<?= $query; ?>');</pre>
    <h3>執行結果</h3>
    <pre><?php print_r($pixapi->blog->comments->search($query)); ?></pre>
    <?php
        }
    ?>
</div>
</body>
</html>