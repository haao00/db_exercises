<HTML>
<HEAD>
  <TITLE>人物データ追加フォーム（動的生成版）</TITLE>
  <META http-equiv="Content-Type" content="text/html; charset=UTF-8">
</HEAD>
<BODY>

人物データ 追加フォーム<BR><BR>

<FORM ACTION="person_add.php" METHOD="GET">

<!-- ここからPHPのスクリプト始まり -->
<?php

// データベースに接続
// ※ your_db_name のところは自分のデータベース名に書き換える
$conn = pg_connect( "dbname=ayks2821" );

// 接続が成功したかどうか確認
if ( $conn == null )
{
	print( "データベース接続処理でエラーが発生しました。<BR>" );
	exit;
}


// 最も大きな従業員番号を取り出すSQLの作成
$sql = "select max(id) from person";

// Queryを実行して検索結果をresultに格納
$result = pg_query( $conn, $sql );
if ( $result == null )
{
	print( "クエリー実行処理bでエラーが発生しました。<BR>" );
	exit;
}

// 最大の従業員番号を取得
if ( pg_num_rows( $result ) > 0 )
	$max_id = pg_fetch_result( $result, 0, 0 );
$max_id ++;

// 従業員番号の初期値を指定して入力エリアを作成
print( "人物番号：\n" );
printf( "<INPUT TYPE=text SIZE=4 NAME=id VALUE=%04s>", $max_id ); // 必ず４桁で出力、空白があれば0で埋める
print( "<BR>\n" );

// 検索結果の開放
pg_free_result( $result );


// 部門一覧を取得するSQLの作成
$sql = "select person.id, clothes.color, person.name, person.age, person.height from person, clothes where person.name = clothes.name";

// Queryを実行して検索結果をresultに格納
$result = pg_query( $conn, $sql );
if ( $result == null )
{
	print( "クエリー実行処理cでエラーが発生しました。<BR>" );
	exit;
}

// 検索結果の行数を取得
$rows = pg_num_rows( $result );

// 部門の数だけ選択肢を出力
print( "服の色：\n" );
for ( $i=0; $i<$rows; $i++ )
{
	$name= pg_fetch_result( $result, $i, 0 );
	$color = pg_fetch_result( $result, $i, 1 );
	printf( "<INPUT TYPE=\"radio\" NAME=\"name\" VALUE=\"%s\"> %s </INPUT>\n", $name, $color );
}

// 検索結果の開放
pg_free_result( $result );

// データベースへの接続を解除
pg_close( $conn );

?>
<!-- ここまででPHPのスクリプト終わり -->

<BR>

名前：
<INPUT TYPE="text" SIZE="24" NAME="name">
　
年齢：
<INPUT TYPE="text" SIZE="4" NAME="age">

身長：
<INPUT TYPE="text" SIZE="4" NAME="height">

<BR><BR>
<INPUT TYPE="submit" VALUE="送信"><BR>

</FORM>

</BODY>
</HTML>
