<?php
error_reporting(0);
if(!empty($_POST['url'])){
	$ch = curl_init();
	$url = "http://192.168.0.171:9999/callnode?url=".strval($_POST['url']);
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_TIMEOUT_MS, 100);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	$output = curl_exec($ch);
	curl_close($ch);
	exit("<script language='javascript'>alert('已提交播放！');window.history.back(-1);</script>");
}
?>
<!DOCTYPE html>
<html>
<meta name="referrer" content="no-referrer" />
<title>WEB控制树莓派播放音乐</title>
<meta name="viewport" content="width=device-width" />
<link href="https://lib.baomitu.com/mdui/1.0.2/css/mdui.min.css" rel="stylesheet">
<script src="https://lib.baomitu.com/mdui/1.0.2/js/mdui.min.js"></script>
<style>
.mdui-card{
margin:15px auto auto auto;
}
</style>
<body class="mdui-drawer-body-left mdui-drawer-body-right">
    <div class="mdui-appbar mdui-color-blue-accent">
        <div class="mdui-toolbar mdui-color-theme">
            <a href="/" class="mdui-typo-title">首页</a>
            <div class="mdui-toolbar-spacer"></div>
            <a href="javascript:location.reload();" class="mdui-btn mdui-btn-icon"><i class="mdui-icon material-icons">refresh</i></a>
        </div>
        <div class="mdui-tab mdui-color-theme" mdui-tab>
            <a href="#example1-tab1" class="mdui-ripple mdui-ripple-white">搜索音乐</a>
            <a href="#example1-tab2" class="mdui-ripple mdui-ripple-white">URL播放</a>
        </div>
    </div>
    <div class="mdui-container">
        <!--  URL播放  -->
        <div id="example1-tab2" class="mdui-p-a-2 mdui-card">
            <form action="" method="post">
                <div class="mdui-textfield mdui-textfield-floating-label">
                    <label class="mdui-textfield-label">音乐URL：</label>
                    <input class="mdui-textfield-input" type="text" name="url"/>
                </div>
            </form>
        </div>

        <!--  搜索播放  -->
        <div id="example1-tab1" class="mdui-p-a-2 mdui-card">
            <form action="" method="post">
                <div class="mdui-textfield mdui-textfield-floating-label">
                    <label class="mdui-textfield-label">音乐名称：</label>
                    <input class="mdui-textfield-input" type="text" name="name"/>
                </div>
            </form>
<?php
if(!empty($_POST['name'])){
$Name=$_POST['name'];
//CURL $url=>需要访问链接;$guise=>伪装来源地址;
function Curl($url,$guise){
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_REFERER, $guise);
curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Linux; Android 11; PCLM10 Build/RKQ1.200928.002; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/90.0.4430.82 Mobile Safari/537.36');
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
$data = curl_exec($curl);
curl_close($curl);
return $data;
}

$Json=curl('https://m.music.migu.cn/migu/remoting/scr_search_tag?rows=20&type=2&keyword='.urlencode($Name).'&pgc=1','m.music.migu.cn','','');
$arr=json_decode($Json,true);
echo '<ul class="mdui-list">';
foreach ($arr['musics'] as $value => $key) {
        $key['mp3']=str_replace('https://','http://',$key['mp3']);
        echo '<li class="mdui-list-item mdui-ripple"><div class="mdui-list-item-avatar"><img src="'.$key['cover'].'"/></div><div class="mdui-list-item-content">'.$key['songName'].' - '.$key['artist'].'</div><form action="" method="post"><input type="text" name="url" value="'.$key['mp3'].'" style="display:none"/><input class="mdui-btn mdui-btn-raised" type="submit" value="播放"></form></li>';
}
echo '</ul>';
}
?>
        </div>
    </div>
</div>
</body>
</html>