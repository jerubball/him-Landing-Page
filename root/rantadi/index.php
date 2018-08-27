<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>랜타디 ReZero 미션 목록</title>
</head>
<body>
    <script type='text/javascript'>
        // set all qualifying CheckBox to state.
        function setCheckBox(tag, type, tower, index, check) {
            var all = document.getElementsByTagName(tag);
            for (var i = 0; i < all.length; i++) {
                if (all[i].type == type && all[i].dataset["tower"] == tower && all[i].dataset["index"] == index) {
                    all[i].checked = check;
                }
            }
        }
        // get CheckBox state from first matching CheckBox.
        function getCheckBox(tag, type, tower, index) {
            var all = document.getElementsByTagName(tag);
            for (var i = 0; i < all.length; i++) {
                if (all[i].type == type && all[i].dataset["tower"] == tower && all[i].dataset["index"] == index) {
                    return all[i].checked;
                }
            }
        }
        // Toggle all other CheckBox when CheckBox is clicked.
        function toggleCheckBoxClicked(item) {
            var data = item.dataset;
            setCheckBox(item.nodeName, item.type, data["tower"], data["index"], item.checked);
        }
        // Toggle all matching CheckBox when image is clicked.
        function toggleImageClicked(item) {
            var tag = "INPUT", type = "checkbox", data = item.dataset;
            var check = !getCheckBox(tag, type, data["tower"], data["index"]);
            setCheckBox(tag, type, data["tower"], data["index"], check);
        }
        // Choose between functions.
        function toggleClicked(item) {
            if (item.nodeName == "INPUT" && item.type == "checkbox") {
                toggleCheckBoxClicked(item);
            } else {
                toggleImageClicked(item);
            }
        }
    </script>
    <?php
        $cutoff = 6;
        $collection = [
            ["mission" => "orangeannoying", "description" => "귤먹다가 짜증이 : 미네랄 300",
             "data" => [
                ["class" => "U",
                 "tower" => [
                    ["name" => "U Reaver", "index" => 3, "title" => "리버 3"],
                ]],
             ]],
            ["mission" => "bigbigreaver", "description" => "카리스마 대빵 큰 리버 : 미네랄 800, 가스 800",
             "data" => [
                ["class" => "U",
                 "tower" => [
                    ["name" => "U Reaver", "index" => 5, "title" => "리버 5"],
                ]],
             ]],
        ];
    ?>
    <h1>랜타디 ReZero 미션 목록</h1>
    <br>
    <form><fieldset>
        <legend><strong>타워 설명</strong></legend>
        <strong>E</strong> : 에픽<br>
        <strong>U</strong> : 유니크<br>
        <strong>R</strong> : 레어<br>
        <strong>M</strong> : 매직<br>
        <strong>N</strong> : 노말<br>
    </fieldset></form>
    <br>
    <form><fieldset>
        <legend><strong>기본 미션들</strong></legend>
        <strong>1. 편식은 금물 : 미네랄 300<br></strong>== <strong>N</strong> 종류별로 1기씩<br>
        <strong>2. 지긋지긋해 하늘이 Gray색이야 : 미네랄 300, 가스 100<br></strong>== <strong>M</strong> 종류별로 1기씩<br>
        <strong>3. 그 남자 그리고 그 여자 : 미네랄 400<br></strong>== <strong>M</strong> 남자 고스트 1 여자 고스트 1<br>
        <strong>4. 언럭키세븐 : 미네랄 300<br></strong>== <strong>R</strong> 종류 상관없이 7기<br>
        <strong>5. 악운도 운이다 : 미네랄 300<br></strong>== <strong>U</strong> 종류 상관없이 6기<br>
    </fieldset></form>
    <br>
    <form><fieldset>
        <legend><strong>이상한 사람의 취미생활 : 보스 시민 3기</strong></legend>
        <strong>U</strong> 리버를 제외한 모든 유닛 1기씩<br>
    </fieldset></form>
    <br>
    <form><fieldset>
        <legend><strong>천년의 기다림 : 유니크 시민 1기</strong></legend>
        보스 시민 5기 보유<br>
    </fieldset></form>
    <br>
    <?php
        $missions = count($collection);
        for ($i = 0; $i < $missions; $i++) {
            $missionset = $collection[$i];
    ?>
    <form><fieldset>
        <legend><strong><?php echo $missionset["description"]; ?></strong></legend>
        <table data-mission="<?php echo $missionset["mission"]; ?>">
            <?php
                $classes = count($missionset["data"]);
                for ($j = 0; $j < $classes; $j++) {
                    $classset = $missionset["data"][$j];
            ?>
            <tr><td><strong><?php echo $classset["class"]; ?></strong></td>
                <td>
                <?php
                    $towers = count($classset["tower"]);
                    for ($k = 0; $k < $towers; $k++) {
                        $towerset = $classset["tower"][$k];
                ?>
                    <?php
                        echo $towerset["title"];
                        if ($towerset["index"] > 1) {
                            $align = $towerset["index"] > $cutoff ? "right" : "left";
                    ?>
                        </td><td align="<?php echo $align; ?>">
                    <?php } ?>
                    <?php
                        for ($l = 0; $l < $towerset["index"]; $l++) {
                    ?>
                        <?php
                            if ($l == $cutoff) {
                        ?>
                            </td><td>
                        <?php } ?>
                        <input type="checkbox" onclick="toggleClicked(this)"
                            data-mission="<?php echo $missionset["mission"]; ?>" data-tower="<?php echo $towerset["name"]; ?>" data-index="<?php echo $l; ?>"/>
                    <?php } ?>
                    <?php
                        $temp = $towerset["index"] - 2 - ($towerset["index"] > $cutoff ? 1 : 0);
                        for ($l = 0; $l < $temp; $l++) {
                    ?>
                        </td><td>
                    <?php } ?>
                <?php } ?>
                </td>
            </tr><tr>
                <td></td>
                <?php
                    for ($k = 0; $k < $towers; $k++) {
                        $towerset = $classset["tower"][$k];
                ?>
                    <?php
                        for ($l = 0; $l < $towerset["index"]; $l++) {
                    ?>
                        <td><img width=150 height=100 onclick="toggleClicked(this)" src="./image/<?php echo $towerset["name"]; ?>.png" 
                            data-mission="<?php echo $missionset["mission"]; ?>" data-tower="<?php echo $towerset["name"]; ?>" data-index="<?php echo $l; ?>"></td>
                    <?php } ?>
                <?php } ?>
            </tr>
            <?php } ?>
        </table>
        <?php
            if (isset($missionset["appendix"])) {
                echo $missionset["appendix"];
            }
        ?>
    </fieldset></form><br>
    <?php } ?>
    
    
    <br>
    <form><fieldset>
        <legend><strong>변경사항</strong></legend>
        <strong>2018.02.03</strong> : 오탈자, 보상 잘못 기록되어 있던 것 수정<br>
        <strong>2018.02.03</strong> : 미치광이 미션 조건 수정, 쩜드라의 저주 -> 하이드라의 저주 수정<br>
        <strong>2018.02.04</strong> : 귤짜증, 카리스마 미션 추가 / 자리미션 보상 기재<br>
        <strong>2018.08.24</strong> : 체크 박스 스크립트 추가<br>
        <strong>2018.08.25</strong> : 타워 스크린샷 추가<br>
        <strong>2018.08.26</strong> : 체크 박스 개수 추가<br>
    </fieldset></form>
    <br>
    <font color="blue"><strong>Made by aMythos (Mythical#31274)</strong></font>
    <br>
    <strong>Edit & Host by him.nyit@gmail.com</strong>
    <br>
</body>
</html>