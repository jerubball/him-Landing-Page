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
        // update all mission related radio button.
        function updateRadioButton(tag, type, tower) {
            var tables = document.getElementsByTagName("TABLE");
            for (var i = 0; i < tables.length; i++) {
                var mission = tables[i].dataset["mission"], element = document.getElementById(mission);
                var all = tables[i].getElementsByTagName(tag);
                    if (mission == "location") {
                    var state = true;
                    for (var j = 0; state && j < all.length; j++) {
                        if (all[j].type == type && all[j].dataset["mission"] == mission && all[j].dataset["tower"] == tower) {
                            state = all[j].checked;
                        }
                    }
                    if (state) {
                        element.checked = true;
                    }
                } else {
                    var state = true;
                    for (var j = 0; state && j < all.length; j++) {
                        if (all[j].type == type && all[j].dataset["mission"] == mission) {
                            state = all[j].checked;
                        }
                    }
                    if (state) {
                        element.checked = true;
                    }
                }
            }
        }
        // Toggle all other CheckBox when CheckBox is clicked.
        function toggleCheckBoxClicked(item) {
            var data = item.dataset;
            setCheckBox(item.nodeName, item.type, data["tower"], data["index"], item.checked);
            updateRadioButton(item.nodeName, item.type, data["tower"]);
        }
        // Toggle all matching CheckBox when image is clicked.
        function toggleImageClicked(item) {
            var tag = "INPUT", type = "checkbox", data = item.dataset;
            var check = !getCheckBox(tag, type, data["tower"], data["index"]);
            setCheckBox(tag, type, data["tower"], data["index"], check);
            updateRadioButton(tag, type, data["tower"]);
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
    $width="150";
    $height="100";
    $cutoff = 6;
    $collection = [
        ["mission" => "strangehobby", "description" => "이상한 사람의 취미생활 : 보스 시민 3기", "preface" => "(★ 리버를 제외한 모든 <b>U</b> 유닛 1기씩 ★)<br>",
         "data" => [
            ["class" => "U",
             "tower" => [
                ["name" => "U Guardian", "index" => 1, "title" => "가디언"],
                ["name" => "U Dark Archon", "index" => 1, "title" => "다크 아칸"],
                ["name" => "U Marine", "index" => 1, "title" => "마린"],
                ["name" => "U Valkyrie", "index" => 1, "title" => "발키리"],
                ["name" => "U Zergling", "index" => 1, "title" => "저글링"],
                ["name" => "U High Templar", "index" => 1, "title" => "하이 템플러"],
                ["name" => "U Hydralisk", "index" => 1, "title" => "히드라"],
            ]],
        ]],
        ["mission" => "location", "description" => "자리 미션 : 유니크 시민 1기", "preface" => "<font color=\"blue\">(★ 파랑은 타워 7, 게이트 1 생산으로 클리어 가능 ★)</font><br>",
         "data" => [
            ["class" => "<font color=\"red\">빨강</font> M",
             "tower" => [
                ["name" => "M Defiler", "index" => 7, "title" => "디파일러 7"],
            ]],
            ["class" => "<font color=\"blue\">파랑</font> M",
             "tower" => [
                ["name" => "M Dark Templar", "index" => 8, "title" => "다크 템플러 7+1"],
            ]],
            ["class" => "<font color=\"teal\">연두</font> M",
             "tower" => [
                ["name" => "M FGhost", "index" => 7, "title" => "여자 고스트 7"],
            ]],
            ["class" => "<font color=\"purple\">보라</font> M",
             "tower" => [
                ["name" => "M Firebat", "index" => 7, "title" => "파이어뱃 7"],
            ]],
            ["class" => "<font color=\"orange\">주황</font> M",
             "tower" => [
                ["name" => "M Tank", "index" => 7, "title" => "탱크 7"],
            ]],
            ["class" => "<font color=\"brown\">갈색</font> M",
             "tower" => [
                ["name" => "M Archon", "index" => 7, "title" => "아칸 7"],
            ]],
        ]],
        ["mission" => "themanthewoman", "description" => "그 남자 그리고 그 여자 : 미네랄 400",
         "data" => [
            ["class" => "M",
             "tower" => [
                ["name" => "M MGhost", "index" => 1, "title" => "남자 고스트"],
                ["name" => "M FGhost", "index" => 1, "title" => "여자 고스트"],
            ]],
        ]],
        ["mission" => "starship", "description" => "스타쉽 : 유니크 시민 1기",
         "data" => [
            ["class" => "U",
             "tower" => [
                ["name" => "U Valkyrie", "index" => 1, "title" => "발키리"],
                ["name" => "U Guardian", "index" => 1, "title" => "가디언"],
            ]],
            ["class" => "R",
             "tower" => [
                ["name" => "R Firebat", "index" => 1, "title" => "파이어뱃"],
                ["name" => "R Devourer", "index" => 1, "title" => "디바우러"],
            ]],
            ["class" => "M",
             "tower" => [
                ["name" => "M Tank", "index" => 1, "title" => "탱크"],
                ["name" => "M Defiler", "index" => 1, "title" => "디파일러"],
            ]],
            ["class" => "N",
             "tower" => [
                ["name" => "N Vulture", "index" => 1, "title" => "벌쳐"],
                ["name" => "N Mutalisk", "index" => 1, "title" => "뮤탈"],
            ]],
        ]],
        ["mission" => "independence", "description" => "인디펜던스 : 유니크 시민 1기",
         "data" => [
            ["class" => "U",
             "tower" => [
                ["name" => "U Valkyrie", "index" => 1, "title" => "발키리"],
                ["name" => "U Reaver", "index" => 1, "title" => "리버"],
            ]],
            ["class" => "R",
             "tower" => [
                ["name" => "R Firebat", "index" => 1, "title" => "파이어뱃"],
                ["name" => "R Dragoon", "index" => 1, "title" => "드라군"],
            ]],
            ["class" => "M",
             "tower" => [
                ["name" => "M Tank", "index" => 1, "title" => "탱크"],
                ["name" => "M Archon", "index" => 1, "title" => "아칸"],
            ]],
            ["class" => "N",
             "tower" => [
                ["name" => "N Vulture", "index" => 1, "title" => "벌쳐"],
                ["name" => "N Dragoon", "index" => 1, "title" => "드라군"],
            ]],
        ]],
        ["mission" => "district9", "description" => "디스트릭트 9 (= 디나인) : 레어 시민 2기",
         "data" => [
            ["class" => "R",
             "tower" => [
                ["name" => "R Sunken", "index" => 3, "title" => "촉수 3"],
                ["name" => "R Arbiter", "index" => 3, "title" => "아비터 3"],
            ]],
            ["class" => "M",
             "tower" => [
                ["name" => "M FGhost", "index" => 3, "title" => "여자 고스트 3"],
                ["name" => "M Archon", "index" => 3, "title" => "아칸 3"],
            ]],
        ]],
        ["mission" => "nadanada", "description" => "나빼고 다 깼네 나빼고 다 : 에픽 시민 1기",
         "data" => [
            ["class" => "U",
             "tower" => [
                ["name" => "U Reaver", "index" => 3, "title" => "리버 3"],
            ]],
            ["class" => "R",
             "tower" => [
                ["name" => "R Wraith", "index" => 3, "title" => "레이스 3"],
                ["name" => "R Sunken", "index" => 3, "title" => "촉수 3"],
            ]],
        ]],
        ["mission" => "angelgame", "description" => "천사의 게임들 : 에픽 시민 1기, 미네랄 1000, 가스 4",
         "data" => [
            ["class" => "E",
             "tower" => [
                ["name" => "E Giant", "index" => 1, "title" => "거인"],
                ["name" => "E Nuclear", "index" => 1, "title" => "핵"],
            ]],
            ["class" => "U",
             "tower" => [
                ["name" => "U Reaver", "index" => 1, "title" => "리버"],
                ["name" => "U High Templar", "index" => 1, "title" => "하이 템플러"],
                ["name" => "U Dark Archon", "index" => 1, "title" => "다크 아칸"],
            ]],
            ["class" => "R",
             "tower" => [
                ["name" => "R Dragoon", "index" => 1, "title" => "드라군"],
                ["name" => "R Sunken", "index" => 1, "title" => "촉수"],
                ["name" => "R Devourer", "index" => 1, "title" => "디바우러"],
            ]],
            ["class" => "M",
             "tower" => [
                ["name" => "M Archon", "index" => 1, "title" => "아칸"],
                ["name" => "M Scout", "index" => 1, "title" => "스카웃"],
                ["name" => "M Tank", "index" => 1, "title" => "탱크"],
            ]],
            ["class" => "N",
             "tower" => [
                ["name" => "N Dragoon", "index" => 1, "title" => "드라군"],
                ["name" => "N Scout", "index" => 1, "title" => "스카웃"],
            ]],
        ]],
        ["mission" => "heart", "description" => "버림받은 자들의 심장 : 라이프 6", "preface" => "<font color=\"red\">(★ 빨강은 <b>N</b> 2마리씩 보유하면 클리어 ★)</font><br>",
         "data" => [
            ["class" => "R",
             "tower" => [
                ["name" => "R Goliath", "index" => 3, "title" => "골리앗 3"],
                ["name" => "R Defiler", "index" => 3, "title" => "디파일러 3"],
            ]],
            ["class" => "N",
             "tower" => [
                ["name" => "N Ultralisk", "index" => 3, "title" => "울트라 3"],
                ["name" => "N Mutalisk", "index" => 3, "title" => "뮤탈 3"],
            ]],
        ]],
        ["mission" => "flying", "description" => "날아올라라 주작이여 : 보스 시민 2기", "preface" => "(★ 에픽 제외 모든 공중유닛 1기씩 ★)<br>",
         "data" => [
            ["class" => "U",
             "tower" => [
                ["name" => "U Valkyrie", "index" => 1, "title" => "발키리"],
                ["name" => "U Guardian", "index" => 1, "title" => "가디언"],
            ]],
            ["class" => "R",
             "tower" => [
                ["name" => "R Devourer", "index" => 1, "title" => "디바우러"],
                ["name" => "R Arbiter", "index" => 1, "title" => "아비터"],
                ["name" => "R Wraith", "index" => 1, "title" => "레이스"],
            ]],
            ["class" => "M",
             "tower" => [
                ["name" => "M Scout", "index" => 1, "title" => "스카웃"],
            ]],
            ["class" => "N",
             "tower" => [
                ["name" => "N Mutalisk", "index" => 1, "title" => "뮤탈"],
                ["name" => "N Scout", "index" => 1, "title" => "스카웃"],
                ["name" => "N Wraith", "index" => 1, "title" => "레이스"],
            ]],
        ]],
        ["mission" => "bsss", "description" => "비선실세 : 가스 503",
         "data" => [
            ["class" => "U",
             "tower" => [
                ["name" => "U Guardian", "index" => 1, "title" => "가디언"],
                ["name" => "U Dark Archon", "index" => 1, "title" => "다크 아칸"],
                ["name" => "U High Templar", "index" => 1, "title" => "하이 템플러"],
            ]],
            ["class" => "R",
             "tower" => [
                ["name" => "R Devourer", "index" => 1, "title" => "디바우러"],
                ["name" => "R Sunken", "index" => 1, "title" => "촉수"],
            ]],
            ["class" => "M",
             "tower" => [
                ["name" => "M Defiler", "index" => 1, "title" => "디파일러"],
                ["name" => "M Dark Templar", "index" => 1, "title" => "다크 템플러"],
                ["name" => "M Scout", "index" => 1, "title" => "스카웃"],
            ]],
        ]],
        ["mission" => "hidra", "description" => "하이드라의 저주 : 미네랄 400, 가스 400",
         "data" => [
            ["class" => "U",
             "tower" => [
                ["name" => "U Hydralisk", "index" => 3, "title" => "히드라 3"],
            ]],
        ]],
        ["mission" => "crazy", "description" => "어느 미치광이의 폭주 : 미네랄 100, 가스 525",
         "data" => [
            ["class" => "E",
             "tower" => [
                ["name" => "E Nuclear", "index" => 2, "title" => "핵 2"],
            ]],
            ["class" => "M",
             "tower" => [
                ["name" => "M MGhost", "index" => 2, "title" => "남자 고스트 2"],
            ]],
        ]],
        ["mission" => "hellgate", "description" => "더 키스 오브 헬 게이트 : 유니크 시민 2기",
         "data" => [
            ["class" => "E",
             "tower" => [
                ["name" => "E Hell Fire", "index" => 3, "title" => "지옥불 3"],
            ]],
        ]],
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
    /*
        ["mission" => "", "description" => "", "preface" => "", "appendix" => "",
         "data" => [
            ["class" => "",
             "tower" => [
                ["name" => "", "index" => 0, "title" => ""],
            ]],
        ]],
    */
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
    </fieldset></form>
    <br>
    <form><fieldset>
        <legend><strong>언럭키세븐 : 미네랄 300</strong></legend>
        (★ <strong>R</strong> 종류 상관없이 7기 ★)<br>
    </fieldset></form>
    <br>
    <form><fieldset>
        <legend><strong>악운도 운이다 : 미네랄 300</strong></legend>
        (★ <strong>U</strong> 종류 상관없이 6기 ★)<br>
    </fieldset></form>
    <br>
    <form><fieldset>
        <legend><strong>천년의 기다림 : 유니크 시민 1기</strong></legend>
        (★ 보스 시민 5기 보유 ★)<br>
    </fieldset></form>
    <br>
<?php
    $missions = count($collection);
    for ($i = 0; $i < $missions; $i++) {
        $missionset = $collection[$i];
?>
    <form data-mission="<?php echo $missionset["mission"]; ?>"><fieldset>
        <legend><input type="radio" disabled=true
            id="<?php echo $missionset["mission"]; ?>" data-mission="<?php echo $missionset["mission"]; ?>"/>
        <strong><?php echo $missionset["description"]; ?></strong></legend>
<?php
        if (isset($missionset["preface"])) {
?>
        <?php echo $missionset["preface"]; ?> 
<?php
        }
?>
        <table data-mission="<?php echo $missionset["mission"]; ?>">
<?php
        $classes = count($missionset["data"]);
        for ($j = 0; $j < $classes; $j++) {
            $classset = $missionset["data"][$j];
?>
        <tr><td><strong><?php echo $classset["class"]; ?></strong></td>
<?php
            $towers = count($classset["tower"]);
            for ($k = 0; $k < $towers; $k++) {
                $towerset = $classset["tower"][$k];
?>
            <td><?php echo $towerset["title"]; ?> 
<?php
                if ($towerset["index"] > 1) {
                    $align = $towerset["index"] > $cutoff ? "right" : "left";
?>
            </td><td align="<?php echo $align; ?>">
<?php
                }
                for ($l = 0; $l < $towerset["index"]; $l++) {
                    if ($l == $cutoff) {
?>
            </td><td>
<?php
                    }
?>
                <input type="checkbox" onclick="toggleClicked(this)"
                    data-mission="<?php echo $missionset["mission"]; ?>" data-tower="<?php echo $towerset["name"]; ?>" data-index=<?php echo $l; ?> />
<?php
                }
                $temp = $towerset["index"] - 2 - ($towerset["index"] > $cutoff ? 1 : 0);
                for ($l = 0; $l < $temp; $l++) {
?>
            </td><td>
<?php
                }
?>
            </td>
<?php
            }
?>
        </tr><tr>
            <td></td>
<?php
            for ($k = 0; $k < $towers; $k++) {
                $towerset = $classset["tower"][$k];
                for ($l = 0; $l < $towerset["index"]; $l++) {
?>
            <td><img src="./image/<?php echo $towerset["name"]; ?>.png" width="<?php echo $width; ?>" height="<?php echo $height; ?>" onclick="toggleClicked(this)" 
                data-mission="<?php echo $missionset["mission"]; ?>" data-tower="<?php echo $towerset["name"]; ?>" data-index=<?php echo $l; ?> ></td>
<?php
                }
            }
?>
        </tr>
<?php
        }
?>
        </table>
<?php
        if (isset($missionset["appendix"])) {
?>
        <?php echo $missionset["appendix"]; ?> 
<?php
        }
?>
    </fieldset></form>
    <br>
<?php
    }
?>
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