<?php
// 获取POST请求中的数值
$value = $_POST['value'];

// 保存数值到文件
$file = fopen('date.txt', 'w');
fwrite($file, $value);
fclose($file);

// 返回成功响应
echo "Data saved successfully!";
?>
