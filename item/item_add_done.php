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

require_once('../common/common.php');

$post=sanitize($_POST);
$item_name=$post['name'];
$item_price=$post['price'];
$item_comment=$post['comment'];
$item_image_name=$post['image_name'];

$dsn='mysql:dbname=shop;host=mysql;charset=utf8';
$user='root';
$password='password';
$dbh=new PDO($dsn,$user,$password);
$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

$sql='INSERT INTO mst_item(name,price,comment,image)VALUES(?,?,?,?)';
$stmt=$dbh->prepare($sql);
$data[]=$item_name;
$data[]=$item_price;
$data[]=$item_comment;
$data[]=$item_image_name;
$stmt->execute($data);

$dbh=null;

print $item_name;
print 'を追加しました。<br/>';
print '価格';
print $item_price;
print '円 <br/>';
print '商品コメント<br/>';
print $item_comment;
print '<br/>';

}

catch(Exception $e)
{
  print 'ただいま障害により大変ご迷惑をお掛けしております。';
  exit();
}

?>

<a href="item_list.php">戻る</a>

</body>
</html>