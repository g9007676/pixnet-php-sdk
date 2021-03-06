<?php
require_once(__DIR__ . '/../bootstrap.php');
require_once(__DIR__ . '/../include/checkAuth.php');
$name = $pixapi->getUserName();
$sets = $pixapi->album->sets->search($name);
if ($sets['total'] > 0) {
    foreach ($sets['data'] as $k => $set) {
        $count = $pixapi->album->sets->elements($name, $set['id'])['total'];
        $sets['data'][$k]['title'] .= " ( $count )";
    }
    if (!isset($_GET['set_id'])) {
        $current_set = $sets['data'][0];
    } else {
        $current_set = $pixapi->album->sets->search($name, ['set_id' => $_GET['set_id']])['data'];
    }
    $element_data = $pixapi->album->sets->elements($name, $current_set['id']);
    if ($element_data['total']) {
        $elements = $element_data['data'];
        foreach ($elements as $k => $e) {
            $count = $pixapi->album->elements->comments->search($name, ['element_id' => $e['id']], $options = [])['total'];
            $elements[$k]['title'] .= " ( $count )";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<?php require_once(__DIR__ . '/../include/header.php'); ?>
</head>
<body>
<div class="container">
    <?php require_once(__DIR__ . '/../include/top.php'); ?>
    <h1 class="page-header">取得相片上所有留言</h1>
    <h3>呼叫方式</h3>
    <pre>$pixapi->album->elements->comments->search($name, ['element_id' => $element_id], $options = [])</pre>
    <div class="well">
        <p>必填參數</p>
        <ul>
            <li><p>name</p><p>使用者名稱</p></li>
            <li><p>element_id</p><p>相片 id</p></li>
        </ul>
        <p>選填參數</p>
        <ul>
            <li><p>page</p><p>頁數, 預設為1</p></li>
            <li><p>per_page</p><p>每頁幾筆, 預設為100</p></li>
            <li><p>password</p><p>相簿密碼，當使用者相簿設定為密碼相簿時使用</p></li>
        </ul>
    </div>
    <h3><a href="#execute" name="execute">實際測試</a></h3>
    <form action="#execute" class="form-horizontal" role="form" method="POST">
      <div class="form-group">
        <label class="col-sm-2 control-label" for="query">請選擇相簿</label>
        <div class="col-sm-5">
            <select class="form-control" id="query" name="set_id" onchange="updateElement(this.options[this.selectedIndex].value)">
        <?php if ($sets['total'] > 0) { ?>
                <?php foreach ($sets['data'] as $set) { ?>
                    <?php if ($set['id'] == $current_set['id']) { ?>
                <option value="<?= $set['id'] ?>" selected><?= $set['title'] ?></option>
                    <?php } else { ?>
                <option value="<?= $set['id'] ?>"><?= $set['title'] ?></option>
                    <?php } ?>
                <?php } ?>
        <?php } else { ?>
                <option disabled>無相簿可供測試</option>
        <?php } ?>
            </select>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-2 control-label" for="query">請選擇照片</label>
        <div class="col-sm-5">
            <select class="form-control" id="query" name="element_id">
                <?php if ($elements) { ?>
                    <?php foreach ($elements as $e) { ?>
                <option value="<?= $e['id'] ?>"><?= $e['title'] ?></option>
                    <?php } ?>
                <?php } else { ?>
                <option disabled>無照片</option>
                <?php } ?>
            </select>
        </div>
      </div>
      <button type="submit" class="btn btn-primary">取得照片留言</button>
    </form>
    <script>
    var updateElement = function(set_id) {
        var uri = location.pathname;
        var search = location.search;
        var hash = location.hash;
        if (search.indexOf('set_id') > 0) {
            search = search.split('&')[0];
        }
        if (search.indexOf('?') > 0) {
            location = (uri + search + '&set_id=' + set_id + hash);
        }
        location = (uri + search + '?set_id=' + set_id + hash);
    }
    </script>
    <?php if (!empty($_POST['set_id'])) { ?>
    <h3>實際執行</h3>
    <pre>$pixapi->album->elements->comments->search(<?= $name ?>, ['element_id' => <?= $_POST['element_id'] ?>], $options)</pre>
    <h3>執行結果</h3>
    <pre><?php print_r($pixapi->album->elements->comments->search($name, ['element_id' => $_POST['element_id']])); ?></pre>
    <?php } ?>
</div>
</body>
</html>
