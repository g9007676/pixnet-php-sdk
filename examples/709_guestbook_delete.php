<?php
require_once(__DIR__ . '/bootstrap.php');
require_once(__DIR__ . '/include/checkAuth.php');
$query = $_POST['query'];
if ('' != $query) {
  $response = $pixapi->guestbook->delete($query);
}
?>
<!DOCTYPE html>
<html>
<head>
<?php require_once(__DIR__ . '/include/header.php'); ?>
</head>
<body>
<div class="container">
    <?php require_once(__DIR__ . '/include/top.php'); ?>
    <h1 class="page-header">刪除留言版留言</h1>
    <h3>呼叫方式</h3>
    <pre>$pixapi->guestbook->delete($id);</pre>
    <h3>實際測試</h3>
    <form class="form-inline" role="form" method="POST">
      <div class="form-group">
          <select class="form-control" id="query" name="query">
          <?php
          $guestbooks = $pixapi->guestbook->search();
          foreach ($guestbooks['articles'] as $guestbook) {
          ?>
              <option value="<?= $guestbook['id'] ?>" <?= ($query == $guestbook['id']) ? 'selected' : ''; ?>><?= $guestbook['title'] ?></option>
          <?php
          }
          ?>
          </select>
      </div>
      <button type="submit" class="btn btn-danger">刪除</button>
    </form>
    <?php
        $query = $_POST['query'];
        if ('' != $query) {
    ?>
    <h3>執行</h3>
    <pre>$pixapi->guestbook->delete('<?= $query; ?>');</pre>
    <h3>執行結果</h3>
    <pre><?php print_r($response); ?></pre>
    <?php
        }
    ?>
</div>
</body>
</html>