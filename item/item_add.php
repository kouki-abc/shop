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
  <title>商品追加</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
  
<h3>商品追加</h3><br/>
<br/>
<form method="post" action="item_add_check.php" enctype="multipart/form-data">
商品名を入力してください。<br/>
<input type="text" name="name" style="width:200px"><br/><br/>
値段を入力してください。<br/>
<input type="text" name="price" style="width:50px"><br/><br/>
商品に関するコメントがあれば入力してください。<br/>
(コメントは50文字以内で入力してください。)<br/>
<textarea name="comment" cols="50" rows="5"></textarea><br/>
画像を選んでください。<br/>
<input type="file" name="image" style="width:400px"><br/>
<br/>
<input type="button" onclick="history.back()" value="戻る">
<input type="submit" value="OK">
</form>

</body>
</html>