<HTML>
<HEAD>
  <TITLE>人物の削除フォーム（動的生成版）</TITLE>
  <META http-equiv="Content-Type" content="text/html; charset=UTF-8">
</HEAD>
<BODY>

<CENTER>

人物データ 削除フォーム<BR><BR>

削除したい人物を選択して送信ボタンを押してください。<BR><BR>

<FORM ACTION="person_delete.php" METHOD="GET">

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
$sql = "select person.id, person.name, person.age, person.height, clothes.color, year.generation from person, clothes, year where person.name=clothes.name and person.age=year.age order by id";

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
	
	// 従業員番号と選択のためのラジオボタンを表示
	$data = pg_fetch_result( $result, $j, 0 );
	print( "<TD> <INPUT TYPE=\"radio\" NAME=\"id\" VALUE=\"$data\"> $data </INPUT> </TD>\n" );
	
	// 残りの属性値を表示（$iが1から始まっている点に注意）
	for ( $i=1; $i<$cols; $i++ )
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
print( "以上、$rows 人の人物が登録されています。<BR>\n" );


// 検索結果の開放
pg_free_result( $result );

// データベースへの接続を解除
pg_close( $conn );

?>
<!-- ここまででPHPのスクリプト終わり -->

<BR>
<INPUT TYPE="submit" VALUE="送信"><BR>

</FORM>

<BR>
<A HREF="reportmenu.html">操作メニューに戻る</A>

</CENTER>

</BODY>
</HTML>

