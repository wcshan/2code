<?php
header("Access-Control-Allow-Origin: *");
$u = isset($_GET["u"]) ? $_GET["u"] : '';
$n = isset($_GET["n"]) ? $_GET["n"] : '';
$c = isset($_GET["c"]) ? $_GET["c"] : '';
// 连主库
session_start();
if ($_SESSION['code']!=$u) {
	exit('{"code":0,"msg":"非法操作!"}');
}
//$conn = mysqli_connect('路径'.':'.'端口','账号','密码','库名');
include 'conn_sql.php';

// Check connection
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
} 
 
class Content {
    public $code  = '00';
    public $content = '00';
}
$content =new Content();
$sql = "SELECT * 
FROM  `2code_code` 
WHERE name LIKE  '%".$n."%'
AND content LIKE  '%".$c."%'
AND user =  '".$u."'
ORDER BY `id` DESC ";

$result = $conn->query($sql);
$data = array();
if (mysqli_num_rows($result) > 0) {
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}
$content->code='1';
$content->content=$data; 
} else {
 $content->code='0';   
}
echo json_encode($content);
$conn->close();
?>