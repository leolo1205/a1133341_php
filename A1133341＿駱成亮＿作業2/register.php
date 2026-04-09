<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>夏令營報名表</title>
</head>
<body>
   <form action="result.php" method="POST">
    <h1>夏令營報名表</h1>   
        <h3>基本資料</h3>
        
        <label>姓名：</label>
        <input type="text" name="name" required>
        <br><br>
        
        <label>性別：</label>
        <input type="radio" name="gender" value="男" required> 男
        <input type="radio" name="gender" value="女" required> 女
        <input type="radio" name="gender" value="其他" required> 其他
        <br><br>
        
        <label>生日：</label>
        <input type="date" name="birthday" required>
        <br><br>
        
        <label>年齡：</label>
        <input type="number" name="age" min="6" max="18" required>
        <br><br>
        
        <label>電子郵件：</label>
        <input type="email" name="email" placeholder="a1110000@mail.nuk.edu.tw" required>
        <br><br>
        
        <label>聯絡電話：</label>
        <input type="tel" name="phone" required>
        <br><br>

        <label>興趣活動（可複選）：</label><br>
        <input type="checkbox" name="activities[]" value="游泳"> 游泳
        <input type="checkbox" name="activities[]" value="爬山"> 爬山
        <input type="checkbox" name="activities[]" value="手作DIY"> 手作DIY
        <input type="checkbox" name="activities[]" value="遊戲"> 遊戲
        <input type="checkbox" name="activities[]" value="烹飪"> 烹飪
        <input type="checkbox" name="activities[]" value="攝影"> 攝影
        <br><br>
        
        <label>餐點需求：</label>
        <select name="meal" required>
            <option value="">請選擇</option>
            <option value="葷食">葷食</option>
            <option value="素食">素食</option>
            <option value="蛋奶素">蛋奶素</option>
        </select>
        <br><br>
        
        <h3>緊急聯絡資訊</h3>
        
        <label>緊急聯絡人：</label>
        <input type="text" name="emergency_contact" required>
        <br><br>
        
        <label>緊急聯絡電話：</label>
        <input type="tel" name="emergency_phone" required>
        <br><br>
        
        <label>特殊需求或備註：</label><br>
        <textarea name="special_needs" rows="5" cols="50"></textarea>
        <br><br>
        
        <button type="submit">報名</button>
    </form>
</body>
</html>