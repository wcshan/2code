<?php

header("Access-Control-Allow-Origin: *"); 
$u = isset($_POST["u"]) ? $_POST["u"] : '';
$c = isset($_POST["c"]) ? $_POST["c"]: '';
$a = isset($_POST["a"]) ? $_POST["a"] : '';
$n = isset($_POST["n"]) ? $_POST["n"]: '';
$title = isset($_POST["title"]) ? $_POST["title"]: '';
$org = isset($_POST["org"]) ? $_POST["org"]: '';
$mp = isset($_POST["mp"]) ? $_POST["mp"]: '';
$hp = isset($_POST["hp"]) ? $_POST["hp"]: '';
$emails = isset($_POST["emails"]) ? $_POST["emails"]: '';
session_start();
if ($_SESSION['code']!=$u) {
	exit('{"code":0,"msg":"非法操作!"}');
}
 
// 连主库
//$conn = mysqli_connect('路径'.':'.'端口','账号','密码','库名');
include 'conn_sql.php';

// Check connection
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
} 
 
$sql="INSERT INTO `2code_code` (`id`, `user`, `num`, `content`, `address`, `address_id`, `name`, `title`, `org`, `mp`, `hp`, `emails`)VALUES (NULL, '".$u."', '0', '".$c."', '".$a."', '', '".$n."','".$title."','".$org."','".$mp."','".$hp."','".$emails."')";

// echo ($sql);
$result = $conn->query($sql);

class Verify {
    public $code  = '00';
}
$verify = new Verify();

// var_dump($result);
if ($result){
    $verify->code = 1;
}else{
$verify->code = 0;
}
echo json_encode($verify);
mysqli_close($conn);

?>
