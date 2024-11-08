<HTML>
<HEAD>
  <TITLE>人物データ更新フォーム</TITLE>
  <META http-equiv="Content-Type" content="text/html; charset=UTF-8">
</HEAD>
<BODY>

人物データ 更新フォーム<BR><BR>

<FORM ACTION="person_update.php" METHOD="GET">

<!-- ここからPHPのスクリプト始まり -->
<?php

// 引数の人物番号を取得
$id = (string) $_GET[ id ];

// データベースに接続
// ※ your_db_name のところは自分のデータベース名に書き換える
$conn = pg_connect( "dbname=ayks2821" );

// 接続が成功したかどうか確認
if ( $conn == null )
{
	print( "データベース接続処理aでエラーが発生しました。<BR>" );
	exit;
}

// 指定された従業員番号の従業員情報を取得するSQLを作成
$sql = sprintf( "select id, name, age, height from person where id='%s'", $id );

// Queryを実行して検索結果をresultに記録
$result = pg_query( $conn, $sql );
if ( $result == null )
{
	print( "クエリー実行処理bでエラーが発生しました。<BR>" );
	exit;
}

// 従業員が見つからなければエラーメッセージを表示
if ( pg_num_rows( $result ) == 0 )
{
	print( "指定された人物番号のデータが見つかりません。<BR>\n" );
	exit;
}

// 検索結果の従業員の情報を変数に記録
$curr_id = pg_fetch_result( $result, 0, 0 );
$curr_name = pg_fetch_result( $result, 0, 1 );
$curr_age = pg_fetch_result( $result, 0, 2 );
$curr_height = pg_fetch_result( $result, 0, 3 );

// 検索結果の開放
pg_free_result( $result );

// 従業員番号を更新スクリプトに渡す
printf( "<INPUT TYPE=hidden NAME=id VALUE=%s>\n", $id );


// 部門一覧を取得するSQLの作成
$sql = "select name, color from clothes";

// Queryを実行して検索結果をresultに記録
$result = pg_query( $conn, $sql );
if ( $result == null )
{
	print( "クエリー実行処理cでエラーが発生しました。<BR>" );
	exit;
}

// 検索結果の行数を取得
$rows = pg_num_rows( $result );

// 部門の数だけ選択肢を出力

// 検索結果の開放
pg_free_result( $result );

// データベースへの接続を解除
pg_close( $conn );

// 番号の入力フィールドを出力
print( "<BR>\n" );
print( "人物番号：\n" );
printf( "<INPUT TYPE=text SIZE=24 NAME=id VALUE=\"%s\">\n", $curr_id );
print( "　\n" );

// 名前の入力フィールドを出力
print( "名前：\n" );
printf( "<INPUT TYPE=text SIZE=4 NAME=name VALUE=%s>\n", $curr_name );

// 年齢の入力フィールドを出力
print( "年齢：\n" );
printf( "<INPUT TYPE=text SIZE=4 NAME=age VALUE=%s>\n", $curr_age );

// 身長の入力フィールドを出力
print( "身長：\n" );
printf( "<INPUT TYPE=text SIZE=4 NAME=height VALUE=%s>\n", $curr_height );

?>
<!-- ここまででPHPのスクリプト終わり -->

<BR>



<BR><BR>
<INPUT TYPE="submit" VALUE="送信"><BR>

</FORM>

</BODY>
</HTML>
