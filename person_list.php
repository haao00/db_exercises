<HTML>
<HEAD>
  <TITLE>人物リスト</TITLE>
  <META http-equiv="Content-Type" content="text/html; charset=UTF-8">
</HEAD>
<BODY>

<CENTER>

検索結果を表示します。<BR><BR>

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

// SQLを作成
$sql = "select person.id, person.name, person.age, person.height, clothes.color, year.generation from person, clothes, year where person.name = clothes.name and person.age = year.age order by id asc";

// Queryを実行して検索結果をresultに格納
$result = pg_query( $conn, $sql );
if ( $result == null )
{
	print( "クエリー実行処理でエラーが発生しました。<BR>" );
	exit;
}

// 検索結果の行数・列数を取得
$rows = pg_num_rows( $result );
$cols = pg_num_fields( $result );


// 検索結果をテーブルとして表示
print( "<TABLE BORDER=1>\n" );

// 各列の名前を表示
print( "<TR>" );
print( "<TH>人物番号</TH>" );
print( "<TH>名前</TH>" );
print( "<TH>年齢</TH>" );
print( "<TH>身長</TH>" );
print( "<TH>服の色</TH>" );
print( "<TH>世代</TH>" );
print( "</TR>\n" );

// 各行のデータを表示
for ( $j=0; $j<$rows; $j++ )
{
	print( "<TR>" );
	for ( $i=0; $i<$cols; $i++ )
	{
		// j行i列のデータを取得
		$data = pg_fetch_result( $result, $j, $i );
		
		// セルに列の名前を表示
		print( "<TD> $data </TD>" );
	}
	print( "</TR>\n" );
}

// ここまででテーブル終了
print( "</TABLE>" );
print( "<BR>\n" );


// 検索件数を表示
print( "以上、$rows 件のデータを表示しました。<BR>\n" );


// 検索結果の開放
pg_free_result( $result );

// データベースへの接続を解除
pg_close( $conn );

?>
<!-- ここまででPHPのスクリプト終わり -->

<BR>
<A HREF="reportmenu.html">操作メニューに戻る</A>

</CENTER>

</BODY>
</HTML>

