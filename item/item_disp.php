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
  <title>商品情報参照</title>
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

$sql='SELECT name,price,comment,image FROM mst_item WHERE code=?';
$stmt=$dbh->prepare($sql);
$data[]=$item_code;
$stmt->execute($data);

$rec=$stmt->fetch(PDO::FETCH_ASSOC);
$item_name=$rec['name'];
$item_price=$rec['price'];
$item_comment=$rec['comment'];
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
<h3>商品情報参照</h3><br/>
<br/>
商品コード<br/>
<?php print $item_code; ?>
<br/>
商品名<br/>
<?php print $item_name; ?>
<br/>
価格<br/>
<?php print $item_price; ?> 円<br/>
商品コメント<br/>
<?php print $item_comment; ?><br/>
<br/>
<?php print $disp_image; ?>
<br/>
<br/>
<form>
<input type="button" onclick="history.back()" value="戻る">
</form>

</body>
</html>