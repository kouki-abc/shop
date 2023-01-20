<?php
session_start();
session_regenerate_id(true);
if(isset($_SESSION['member_login'])==false)
{
  print 'ようこそゲスト様　<br/>';
  print '<a href="member_login.html">会員ログイン</a><br/>';
  print '<br/>';
}
else
{
  print 'ようこそ';
  print $_SESSION['member_name'];
  print '様';
  print '<a href="member_logout.php">ログアウト</a><br/>';
  print '<br/>';
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>商品情報</title>
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
  $disp_image='<img src="../item/image/'.$item_image_name.'">';
}
print '<a href="shop_cartin.php?itemcode='.$item_code.'">カートに入れる</a><br/><br/>';

}
catch(Exception $e)
{
  print 'ただいま障害により大変ご迷惑をお掛けしております。';
  exit();
}

?>
<h3>商品情報参照</h3><br/>
<br/>
<table>
<tr>
  <td>商品コード</td>
  <td>商品画像</td>
  <td>商品名</td>
  <td>価格</td>
  <td>商品コメント</td>
</tr>

<tr>
  <td><?php print $item_code; ?></td>
  <td><?php print $disp_image; ?></td>
  <td><?php print $item_name; ?></td>
  <td><?php print $item_price; ?> 円</td>
  <td><?php print $item_comment; ?></td>
</tr>
</table>
<form>
<input type="button" onclick="history.back()" value="戻る">
</form>

</body>
</html>