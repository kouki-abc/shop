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

if(isset($_SESSION['cart'])==true)
{
  $cart=$_SESSION['cart'];
  $kazu=$_SESSION['kazu'];
  $max=count($cart);
}
else
{
  $max=0;
}

if($max==0)
{
  print 'カートに商品が入っていません。<br/>';
  print '<br/>';
  print '<a href="shop_list.php">商品一覧へ戻る</a>';
  exit();
}

$dsn='mysql:dbname=shop;host=mysql;charset=utf8';
$user='root';
$password='password';
$dbh=new PDO($dsn,$user,$password);
$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

foreach($cart as $key => $val)
{
  $sql='SELECT code,name,price,image FROM mst_item WHERE code=?';
  $stmt=$dbh->prepare($sql);
  $data[0]=$val;
  $stmt->execute($data);

  $rec=$stmt->fetch(PDO::FETCH_ASSOC);

  $item_name[]=$rec['name'];
  $item_price[]=$rec['price'];
  if($rec['image']=='')
  {
    $item_image[]='';
  }
  else
  {
    $item_image[]='<img src="../item/image/'.$rec['image'].'">';
  }
}
$dbh=null;

}

catch(Exception $e)
{
  print 'ただいま障害により大変ご迷惑をお掛けしております。';
  exit();
}

?>

カートの中身<br/>
<br/>
<form method="post" action="kazu_change.php">
<table>
<tr>
<td>商品</td>
<td>商品画像</td>
<td>価格</td>
<td>数量</td>
<td>小計</td>
<td>削除</td>
</tr>

<?php for($i=0; $i<$max; $i++)
  {
?>
<tr>
  <td><?php print $item_name[$i];?></td>
  <td><?php print $item_image[$i];?></td>
  <td><?php print $item_price[$i]; ?> 円</td>
  <td><input type="text" name="kazu<?php print $i; ?>" value="<?php print $kazu[$i]; ?>"></td>
  <td><?php print $item_price[$i] * $kazu[$i]; ?> 円</td>
  <td><input type="checkbox" name="sakujo<?php print $i; ?>"></td>
</tr>
<?php
  }
?>
</table>

<input type="hidden" name="max" value="<?php print $max; ?>">
<input type="submit" value="数量変更"><br/>
<input type="button" onclick="history.back()" value="戻る">
</form>
<br/>
<a href="shop_form.html">ご購入手続きへ進む</a><br/>

<?php

if(isset($_SESSION['member_login'])==true)
{
  print '<a href="shop_kantan_check.php">会員かんたん注文へ進む</a><br/>';
}
?>

</body>
</html>