<?php
header("Content-Type: text/html;charset=utf-8");
$con = mysql_pconnect("127.0.0.1", "root", "aaaaaaaa"); 
if (!$con) {
    die('Could not connect: ' . mysql_error());
}

mysql_select_db("rdsays", $con);
//select * FROM rdsay order by rand() limit 1
$result = mysql_query("SELECT * FROM rdsay B JOIN (SELECT CEIL(MAX(p_id)*RAND()) AS ID FROM rdsay) AS m ON B.p_ID >= m.ID LIMIT 1;");
while ($row = mysql_fetch_array($result)) {
    $say     = $row['say'];
    $id      = $row['id'];
    $cat     = $row['cat'];
    $catname = $row['catname'];
    $source  = $row['source'];
}

if (is_array($_GET) && count($_GET) > 0) {
	if (isset($_GET["gogogo"])) {
        $paraa = $_GET["gogogo"]; //存在
		$result2 = mysql_query("UPDATE gogogo SET gogogo = '".$paraa."' WHERE id = '1' ");
    }
    if (isset($_GET["encode"])) {
        $para = $_GET["encode"]; //存在
		$result3 = mysql_query("SELECT * from gogogo WHERE id = '1' ");
		while ($row2 = mysql_fetch_array($result3)) {
			$go=$row2['gogogo'];
			$gourl=$row2['url'];
		}
		if($go=="0" || $go=="2"){
			if($go=="0"){
				//select * FROM rdsay order by rand() limit 1
				$result = mysql_query("SELECT * FROM rdsay B JOIN (SELECT CEIL(MAX(p_id)*RAND()) AS ID FROM rdsay) AS m ON B.p_ID >= m.ID LIMIT 1;");
			}else if($go=="2"){
				//select * FROM rdsay order by rand() limit 1
				$result = mysql_query("SELECT * FROM rdsay1 B JOIN (SELECT CEIL(MAX(p_id)*RAND()) AS ID FROM rdsay1) AS m ON B.p_ID >= m.ID LIMIT 1;");
			}	
			
			while ($row = mysql_fetch_array($result)) {
				$say     = $row['say'];
				$id      = $row['id'];
				$cat     = $row['cat'];
				$catname = $row['catname'];
				$source  = $row['source'];
			}
			if ($para == "json") {
				echo "<p>{\"say\":\"" . $say . "\",\"cat\":\"" . $cat . "\",\"catname\":\"" . $catname . "\",\"source\":\"" . $source . "\",\"id\":\"" . $id . "\"}</p>";
			}
			if ($para == "js") {
				echo "function randsay(){document.write(\"<span class='randsay'<p>".$say."</p></span>\");}" ;
			}
			if ($para == "say") {
				echo $say;
			}
			if ($para == "jsonp") {
			   echo "callback({\"say\":\"" . $say . "\",\"cat\":\"" . $cat . "\",\"catname\":\"" . $catname . "\",\"source\":\"" . $source . "\",\"id\":\"" . $id . "\"})";
			}
		}else if($go=="1"){
			echo "callback({\"say\":\"1\",\"cat\":\"gogogo\",\"catname\":\"gogogo\",\"source\":\"" .$gourl. "\",\"id\":\"gogogo\"})";
		}
    }
} else {
    echo "参数有:</br>";
	echo "encode=js</br>";
	echo "encode=json</br>";
	echo "encode=jsonp</br>";
	echo "encode=say</br>";
	echo "参数encode=js使用方法</br>";
	echo "脚本地址:http://xxx/say?encode=js</br>";
	echo "使用方法</br>";
	print '&lt;script type="text/javascript" src="http://xxx/say?encode=js"&gt;&lt;/script&gt;</br>';
	echo "放入展示位置</br>";
	echo '&lt;div id="randsay"&gt;&lt;script&gt;randsay()&lt;/script&gt;&lt;/div&gt;</br>';
	print "JsonP调用方法</br>";
	echo "<pre>";
	print '
&lt;script type="text/javascript" src="jquery.js"&gt;&lt;/script&gt;
&lt;script&gt;
  function getsay() {
  $.ajax({
            url: "http://xxx.xxx/say.php?encode=jsonp",
            dataType: "jsonp",
            async: true,
        jsonp: "callback",
        jsonpCallback: "callback",
            success: function(result) {
    $(".say").html("&lt;p&gt;" + result.say + "=="+result.source + "&lt;/p&gt;")
            },
            error: function() {
    $(".say").html("&lt;p&gt;读取失败&lt;/p&gt;")
            }
             });
   }
getsay();
&lt;/script&gt;
&lt;div class="say"&gt;&lt;/div&gt;
';

}
                        
?>


