<?php
function each_compat(&$array) {
    $res = array();
    $key = key($array);
    if ($key !== null) {
        next($array);
        $res[1] = $res["value"] = $array[$key];
        $res[0] = $res["key"] = $key;
    } else {
        $res = false;
    }
    return $res;
}
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title>shoppingcart.php</title>
</head>
<body>
    <table border="1">
        <tr>
            <th>功能</th>
            <th>編號</th>
            <th>名稱</th>
            <th>價格</th>
            <th>數量</th>
        </tr>
<?php
$total = 0;

reset($_COOKIE);
while (list($arr, $value) = each_compat($_COOKIE)) {
    if (isset($_COOKIE[$arr]) && is_array($_COOKIE[$arr])) {
        echo "<tr><td>";
        echo "<a href='delete.php?Id=" . $arr . "'>";
        echo "刪除</a></td>";

        $price = 0;
        $quantity = 0;
        reset($_COOKIE[$arr]);

        while (list($name, $value) = each_compat($_COOKIE[$arr])) {
            echo "<td>" . htmlspecialchars($value) . "</td>";
            if ($name == "Price") {
                $price = $value;
            }
            if ($name == "Quantity") {
                $quantity = $value;
            }
        }

        $total += $price * $quantity;
        echo "</tr>";
    }
}
echo "<tr><td colspan='5' align='center'>";
echo "總金額 = NT$" . $total . "元";
echo "</td></tr>";
?>
    </table>

    <p>
        <a href="catalog.php">商品目錄</a> |
        <a href="shoppingcart.php">檢視購物車</a>
    </p>
</body>
</html>
