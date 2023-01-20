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

$sql='SELECT name,price,comment,image FROM mst_item WHERE code=?';
$stmt=$dbh->prepare($sql);
$data[]=$item_code;
$stmt->execute($data);

$rec=$stmt->fetch(PDO::FETCH_ASSOC);
$item_name=$rec['name'];
$item_price=$rec['price'];
$item_comment=$rec['comment'];
$item_image_name_old=$rec['image'];

$dbh=null;

if($item_image_name_old=='')
{
  $disp_image='';
}
else
{
  $disp_image='<img src="./image/'.$item_image_name_old.'">';
}

}
catch(Exception $e)
{
  print 'ただいま障害により大変ご迷惑をお掛けしております。';
  exit();
}


?>
<h3>商品修正</h3><br/>
<br/>
商品コード<br/>
<?php print $item_code; ?>
<br/>
<br/>
<form method="post" action="item_edit_check.php" enctype="multipart/form-data">
<input type="hidden" name="code" value="<?php print $item_code; ?>">
<input type="hidden" name="image_name_old" value="<?php print $item_image_name_old; ?>">
商品名<br/>
<input type="text" name="name" style="width:200px" value="<?php print $item_name; ?>"><br/>
価格<br/>
<input type="text" name="price" style="width:50px" value="<?php print $item_price; ?>">円<br/>
<br/>
商品コメント<br/>
<textarea name="comment" cols="50" rows="5"><?php print $item_comment; ?></textarea><br/>
<br>
<?php print $disp_image; ?>
<br/>
画像を選んでください。<br/>
<input type="file" name="image" style="width:400px"><br/>
<br/>
<input type="button" onclick="history.back()" value="戻る">
<input type="submit" value="OK">
</form>

</body>
</html>