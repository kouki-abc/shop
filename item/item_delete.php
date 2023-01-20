<?php
session_start();
session_regenerate_id(true);
if(isset($_SESSION['login'])==false)
{
  print 'ログインされていません。<br/>';
  print '<a href="../staff_login/staff_login.html">ログイン画面へ</a>';
  exit();
}
else
{
  print $_SESSION['staff_name'];
  print 'さんログイン中<br/>';
  print '<br/>';
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>title</title>
  <link rel="stylesheet" href="../css/style.css">

</head>
<body>
  
<?php

try
{

$item_code=$_GET['itemcode'];

$dsn='mysql:dbname=shop;host=mysql;charset=utf8';
$user='root';
$password='password';
$dbh=new PDO($dsn,$user,$password);
$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

$sql='SELECT name,image FROM mst_item WHERE code=?';
$stmt=$dbh->prepare($sql);
$data[]=$item_code;
$stmt->execute($data);

$rec=$stmt->fetch(PDO::FETCH_ASSOC);
$item_name=$rec['name'];
$item_image_name=$rec['image'];

$dbh=null;

if($item_image_name=='')
{
  $disp_image='';
}
else
{
  $disp_image='<img src="./image/'.$item_image_name.'">';
}

}
catch(Exception $e)
{
  print 'ただいま障害により大変ご迷惑をお掛けしております。';
  exit();
}


?>
<h3>商品削除</h3><br/>
<br/>
商品コード<br/>
<?php print $item_code; ?>
<br/>
商品名<br/>
<?php print $item_name; ?>
<br/>
<?php print $disp_image; ?>
<br/>
この商品を削除してよろしいですか？<br/>
<br/>

<script>
  function confirm_alert()
  {
    let select = confirm('以下の商品データを削除します\n<?php print $item_name; ?>\nよろしいでしょうか？');
    return select;
  }
</script>

<form method="post" action="item_delete_done.php" onsubmit="return confirm_alert()">
<input type="hidden" name="code" value="<?php print $item_code; ?>">
<input type="hidden" name="image_name" value="<?php print $item_image_name; ?>">
<input type="button" onclick="history.back()" value="戻る">
<input type="submit" value="OK">
</form>

</body>
</html>