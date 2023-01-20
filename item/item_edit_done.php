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
$item_code=$post['code'];
$item_name=$post['name'];
$item_price=$post['price'];
$item_comment=$post['comment'];
$item_image_name_old=$post['image_name_old'];
$item_image_name=$post['image_name'];

$dsn='mysql:dbname=shop;host=mysql;charset=utf8';
$user='root';
$password='password';
$dbh=new PDO($dsn,$user,$password);
$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

$sql='UPDATE mst_item SET name=?,price=?,comment=?,image=? WHERE code=?';
$stmt=$dbh->prepare($sql);
$data[]=$item_name;
$data[]=$item_price;
$data[]=$item_comment;
$data[]=$item_image_name;
$data[]=$item_code;
$stmt->execute($data);

$dbh=null;

if($item_image_name_old!=$item_image_name)
{
  if($item_image_name_old!='')
  {
    unlink('./image/'.$item_image_name_old);
  }
}

print '修正しました。<br/>';

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