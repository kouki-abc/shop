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

require_once('../common/common.php');

$post=sanitize($_POST);
$item_name=$post['name'];
$item_price=$post['price'];
$item_comment=$post['comment'];
$item_image=$_FILES['image'];

if($item_name=='')
{
  print '商品名が入力されていません。<br/>';
}
else
{
  print '商品名:';
  print $item_name;
  print '<br/>';
}

if(preg_match('/\A[0-9]+\z/',$item_price)==0)
{
  print '値段をきちんと入力してください。<br/>';
}
else
{
  print '値段:';
  print $item_price;
  print '円 <br/>';
}

if($item_comment!='')
{
  if(mb_strlen($item_comment)>50)
  {
    print'コメント数が50文字を超えています。<br/>';
    print'コメントは50文字以内で入力してください。<br/>';
  }
  else
  {
  print '説明<br/>';
  print $item_comment;
  print '<br/>';
  }
}

if($item_image['size']>0)
{
  if($item_image['size']>1000000)
  {
    print'画像が大き過ぎます。';
  }
  else
  {
    move_uploaded_file($item_image['tmp_name'],'./image/'.$item_image['name']);
    print '<img src="./image/'.$item_image['name'].'">';
    print '<br/>';
  }
}

if($item_name=='' || preg_match('/\A[0-9]+\z/',$item_price)==0 || mb_strlen($item_comment)>50 || $item_image['size']>1000000)
{
  print '<form>';
  print '<input type="button" onclick="history.back()" value="戻る">';
  print '</form>';
}
else
{
  print '上記の商品を追加します。<br/>';
  print '<form method="post" action="item_add_done.php">';
  print '<input type="hidden" name="name" value="'.$item_name.'">';
  print '<input type="hidden" name="price" value="'.$item_price.'">';
  print '<input type="hidden" name="comment" value="'.$item_comment.'">';
  print '<input type="hidden" name="image_name" value="'.$item_image['name'].'">';
  print '<br/>';
  print '<input type="button" onclick="history.back()" value="戻る">';
  print '<input type="submit" value="OK">';
  print '</form>';
}

?>

</body>
</html>