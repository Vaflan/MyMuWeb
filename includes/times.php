<?
$servertime = date("F d, Y H:i:s", time()+1);
$hour = date("H");
$min = date("i");
$duotime = $hour.$min;

if($min>30) {$bcht = $hour+1; $bct = "'".$bcht."','30'";}
else {$bct = "'".$hour."','30'";}

if($duotime<145) {$cct = "1";} elseif($duotime<345) {$cct = "3";}
elseif($duotime<545) {$cct = "5";} elseif($duotime<745) {$cct = "7";}
elseif($duotime<945) {$cct = "9";} elseif($duotime<1145) {$cct = "11";}
elseif($duotime<1345) {$cct = "13";} elseif($duotime<1545) {$cct = "15";}
elseif($duotime<1745) {$cct = "17";} elseif($duotime<1945) {$cct = "19";}
elseif($duotime<2145) {$cct = "21";} else {$cct = "23";}

if($duotime<100) {$dst = "1";} elseif($duotime<300) {$dst = "3";}
elseif($duotime<500) {$dst = "5";} elseif($duotime<700) {$dst = "7";}
elseif($duotime<900) {$dst = "9";} elseif($duotime<1100) {$dst = "11";}
elseif($duotime<1300) {$dst = "13";} elseif($duotime<1500) {$dst = "15";}
elseif($duotime<1700) {$dst = "17";} elseif($duotime<1900) {$dst = "19";}
elseif($duotime<2100) {$dst = "21";} else {$dst = "23";}

if($duotime<100) {$get = "1";} elseif($duotime<400) {$get = "4";}
elseif($duotime<700) {$get = "7";} elseif($duotime<1000) {$get = "10";}
elseif($duotime<1300) {$get = "13";} elseif($duotime<1600) {$get = "16";}
elseif($duotime<1900) {$get = "19";} elseif($duotime<2200) {$get = "22";}
?>

<script type="text/javascript" src="scripts/timejs.js">//script_by_vaflan</script>

<span id="time"><?echo date("d.m.Y H:i:s");?></span><br>
Devil Square: <span id="dstime">ОШИБКА: Пожалуйста, включите JavaScript</span><br>
Blood Castle: <span id="bctime">ОШИБКА: Пожалуйста, включите JavaScript</span><br>
Chaos Castle: <span id="cctime">ОШИБКА: Пожалуйста, включите JavaScript</span><br>

<script type="text/javascript">
var currenttime = '<?echo $servertime;?>' //PHP method of getting server date "F d, Y H:i:s"
var serverdate=new Date(currenttime)

function padlength(what){
var output=(what.toString().length==1)? "0"+what : what
return output
}

function displaytime(){
serverdate.setSeconds(serverdate.getSeconds()+1);
month = serverdate.getMonth() + 1; if(month<10) {month = "0"+month}
var datestring=padlength(serverdate.getDate())+"."+month+"."+serverdate.getFullYear()
var timestring=padlength(serverdate.getHours())+":"+padlength(serverdate.getMinutes())+":"+padlength(serverdate.getSeconds())
document.getElementById("time").innerHTML=datestring+" "+timestring
}

window.onload=function(){
setInterval("displaytime()", 1000)
}

dstime('<?echo $dst;?>','00');
bctime(<?echo $bct;?>);
cctime('<?echo $cct;?>','45');
//script_by_vaflan
</script>
