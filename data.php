<?php
//константы
$aType = array (
	"f" => "футболка с рукавом", 
	"m" => "майка борцовка", 
	"m43" => "майка прямая",
	"f+" =>"футболка большемерка"
);
$aGender = array (
	"w" => "женская", "m" => "мужская"
);
$aColor = array (
	"w" => "белая",
	"b" => "чёрная",
	"o" => "оранжевая"
);
$aJam = array (
	"1rj2" => "РеДжем 2. 2014",
	"2rj3" => "РеРеДжем 3. 2015",
	"3j8" => "Танго Джем 8. 2016",
	"4rj4" => "РеДжем 4. 2016",
	"5j9" => "Танго Джем 9. 2017",
	"6rj5" => "РеДжем 5. 2017",
	"7j10" => "Танго Джем 10. 2018",
	"8rj6" => "РеДжем 6. 2018",
	"9j11" => "Танго Джем 11. 2019",
	"9rj7" => "РеДжем 7. 2019",
    "02020" => "elcentro 2020",
    "019tj21" => "Танго Джем 2021"
);
$aJamLogo = array (
	"1rj2" => "rejam2.jpg",
	"2rj3" => "rejam3.jpg",
	"3j8" => "jam8.jpg",
	"4rj4" => "rejam4.png",
	"5j9" => "jam9.jpg",
	"6rj5" => "rejam5.jpg",
	"7j10" => "jam10.jpg",
	"8rj6" => "rejam6.png",
	"9j11" => "jam11.jpg",
	"9rj7" => "rejam7.jpg",
    "02020" => "w2020.png",
    "019tj21" => "jam21.png"
);

function getNumCart() {
    $files = scandir('.');
    $c = 0;
    foreach ($files as $f) {
      	if (strpos($f, '.cart') !== false) {
	    $af = explode(".", $f);
	    // сборка мусора
	    if ((int)$af[1] < time()) {
	 	unlink($f);
	    } else {
		if ($c < (int)$af[0]) $c = (int)$af[0];
	    }
	}
    }
    return $c + 1;
}

function getNumOrder() {
    $files = scandir('.');
    $c = 0;
    foreach ($files as $f) {
      	if (strpos($f, '.order') !== false) {
	    $af = explode(".", $f);
 	    if ($c < (int)$af[0]) $c = (int)$af[0];
	}
    }
    return ++$c;
}

function saveCarts($cart, $add, $del) {
    // перебираем корзинки формат номер_заказа.время_хранения.cart
    $files = scandir('.');
    $ok = 0;
    foreach ($files as $f) {
      	if (strpos($f, '.cart') !== false) {
	    $af = explode(".", $f);
	    // сборка мусора
	    if ((int)$af[1] < time()) {
	 	unlink($f);
	    } elseif ((int)$af[0] == $cart) {
		$ok = $f;
	    }
        }
    }

    if ($ok == 0) {
	$t = time() + 3600;
	$ok = $cart.".".(string)$t.".cart";
    }

    if ($add) {
        $savefile = @fopen($ok, "a");
	if (filesize($ok) > 0) 	fwrite($savefile, "\n");
	fwrite($savefile, $add);
	fclose($savefile);
	if ($t)	setcookie("jamshirts", $cart, $t); // на час 
    } elseif ($del) {
    	$file = file($ok);
        $savefile = @fopen($ok, "w");
	if ($savefile) {
	    $done = 0;
	    foreach ($file as $f) {
		if (($done == 0) && (preg_replace("/\r\n|\r|\n/u", "", $f) == $del)) {
		    $done = 1;
		    continue;
		}
		fwrite($savefile, $f);
	    }
	}
	fclose($savefile);

	if (filesize($ok) == 0) {
	    unlink($ok);
	    setcookie("jamshirts", "");
	}
    } else {
	if ($ok != 0) unlink($ok);
	setcookie("jamshirts", "");
    }

    return;
}

if (isset($_POST["add"])) {
    if (isset($_COOKIE["jamshirts"])) {
	$cart = $_COOKIE["jamshirts"];
    } else {
	$cart = getNumCart();
    }

    saveCarts($cart, $_POST["add"]);
}

if (isset($_POST["del"])) {
    if (isset($_COOKIE["jamshirts"])) {
	$cart = $_COOKIE["jamshirts"];
	saveCarts($cart, NULL, $_POST["del"]);
    }
}

if (isset($_POST["jam"])) {
    //тип;пол;цвет;размер;кол-во;стоимость
    $footies = file($_POST["jam"]);
    $finalfooties = array();
    // перебираем корзинки формат номер_заказа.время_хранения.cart
    foreach ($footies as $footie) {
	$footie = preg_replace("/\r\n|\r|\n/u", "", $footie);
	$afootie = explode(";", $footie);
	$c = 0;
	// пересканируем, т.к. некоторые могут быть удалены
    	$files = scandir('.');
        foreach ($files as $file) {
    	    $afile = explode(".", $file);
      	    if ($afile[2] == 'cart') {
	    	// сборка мусора
	    	if ((int)$afile[1] < time()) {
	 	    unlink($file);
		    continue;
	    	} 
	    }
	    if (($afile[2] == 'cart') || ($afile[1] == 'order')) {
		$cart = file($file);
		foreach ($cart as $f) {
		    $f = preg_replace("/\r\n|\r|\n/u", "", $f);
	 	    if (strpos($f, $_POST["jam"].";".$afootie[0].";".$afootie[1].";".$afootie[2].";".$afootie[3]) !== false) $c++;			    
		}
	    }
        }
	if ((int)$afootie[4] > $c) {
	    $afootie[4] = (int)$afootie[4] - $c;
	    $finalfooties[] = implode(";", $afootie);
	}
    }

    if (count($finalfooties) > 0) {
    	$html = "<br /><h3>{$aJam[$_POST['jam']]}</h3>";
    	$html .= '<table cellspacing="0" cellpadding="0">';
    	$html .= "<th>Наименование</th><th>Пол</th><th>Цвет</th><th>Размер</th><th>Кол-во</th><th>Стоимость</th><th>Корзина</th>";
    	foreach ($finalfooties as $footie) {
	    $a = explode(";",$footie);
	    $html .= "<tr><td>{$aType[$a[0]]}</td><td>{$aGender[$a[1]]}</td><td>{$aColor[$a[2]]}</td>";
	    $html .= "<td>".strtoupper($a[3])."</td><td>{$a[4]}</td><td>{$a[5]}</td>";
	    // добавить в корзину 1
	    $a[4] = 1;
	    $buffer = $_POST['jam'].";".implode(";", $a);
	    $html .= "<td><input type=\"button\" name=\"add\" value=\"Добавить\" class=\"jfk-button jfk-button-action\" onclick=\"addToCart('{$buffer}')\" /></td></tr>";
    	}
    	$html .= '</table>';
    } else {
	$html = "<br /><h3>{$aJam[$_POST['jam']]}</h3><p>К сожалению, всё закончилось :(</p>";
    }
    echo $html;
}

if (isset($_POST["load"])) {
    $files = scandir('.');
    foreach ($files as $f) {
      	if (strpos($f, '.') === false) {
	    echo "<div class=\"float-logo\" id=\"float_{$f}\" onclick=\"loadMe('{$f}');\"><img src=\"{$aJamLogo[$f]}\" /><br />{$aJam[$f]}</div>";
        }
    }
}

if (isset($_POST["clear"])) {
    if (isset($_COOKIE["jamshirts"])) {
	$cart = $_COOKIE["jamshirts"];
	saveCarts($cart,"");
    } else
	saveCarts();
}

if (isset($_POST["cart"])){
    $html = "<h3>Авоська</h3>";
    $ok = 0;
    if (isset($_COOKIE["jamshirts"]) && !isset($_POST["clear"])) {
	$cart = $_COOKIE["jamshirts"];
        $files = scandir('.');
	foreach ($files as $f) {
      	    if (strpos($f, '.cart') !== false) {
		$af = explode(".", $f);
		if ($af[0] == $cart) {
		    $ok = 1;
		    break;
		}
            }
    	}
	if ($ok == 1) {
	    $html .= "<span style=\"font-size: smaller\">Доступна до ".date('H:i', $af[1])."</span>";
    	    $html .= '<table cellspacing="0" cellpadding="0">'."\n";
    	    $html .= "<th>Джем</th><th>Наименование</th><th>Пол</th><th>Цвет</th><th>Размер</th><th>Кол-во</th><th>Стоимость</th><th>Корзина</th>";
	    $count = 0;
	    $cost = 0;
    	    $file = file($f);
	    foreach ($file as $f){
                $f = preg_replace("/\r\n|\r|\n/u", "", $f);
	    	$a = explode(";", $f);
	    	$count += (int)$a[5];
	    	$cost += (int)$a[5] * (int)$a[6];
	    	$html .= "<tr><td>{$aJam[$a[0]]}</td><td>{$aType[$a[1]]}</td><td>{$aGender[$a[2]]}</td><td>{$aColor[$a[3]]}</td>";
	    	$html .= "<td>".strtoupper($a[4])."</td><td>{$a[5]}</td><td>{$a[6]}</td>";
	    	$html .= "<td><input type=\"button\" name=\"del\" value=\"Удалить\" class=\"jfk-button jfk-button-action\" onclick=\"delFromCart('{$f}')\" /></td></tr>";
	    }
	    $html .= "<tr><td colspan=\"5\"><strong>Итого</strong></td><td>{$count}</td><td>{$cost}</td>";
	    $html .= "<td><input type=\"button\" name=\"clear\" value=\"Очистить\" class=\"jfk-button jfk-button-action\" onclick=\"clearCart()\" /></td></tr>";
	    $html .= "</table>";
	    $html .= "<div id=\"confirm\"><input type=\"button\" name=\"confirm\" value=\"Подтвердить\" class=\"jfk-button jfk-button-action\" onclick=\"confirmMe()\" /></div>";
	}
    }
    if ($ok == 0) {
	$html .= '<p>Тут пока ничего нет, но ты можешь нажать на любой логотип и добавить сюда футболочку.</p>';
    }
    $html .= "<hr style=\"width: 10%\" align=\"left\" />";
    $html .= "<span style=\"font-size: smaller\">* И, да, страничка использует куки-файлы. Мы там храним только номер заказа, но вы просто должны об этом знать ¯\_(ツ)_/¯</span><br />";
    $html .= "<span style=\"font-size: smaller\">** По всем вопросам можно связаться с Сергеем Поповым в ФБ =)</span>";
    echo $html;
}

if (isset($_POST["confirm"])) {
    $html = "<span>Введи своё имя и фамилию</span><br />";
    $html .= "<input type=\"text\" name=\"fullname\" id=\"name\" class=\"ss-q-short\" placeholder=\"Имя и фамилия\" /><br /><br />";
    $html .= "После отправки заказа можно будет связаться с Сергеем Поповым в ФБ, чтобы уточнить детали оплаты и получения.<br /><br />";
    $html .= "<input type=\"button\" name=\"done\" value=\"Отправить\" class=\"jfk-button jfk-button-action\" onclick=\"done()\" />";
    echo $html;
}

if (isset($_POST["done"])) {
    $ok = 0;
    if (isset($_COOKIE["jamshirts"])) {
	$cart = $_COOKIE["jamshirts"];
        $files = scandir('.');
	foreach ($files as $f) {
      	    if (strpos($f, '.cart') !== false) {
		$af = explode(".", $f);
		if ($af[0] == $cart) {
		    $ok = 1;
		    break;
		}
            }
    	}
    } 
    if ($ok = 0) {
	echo "<p>Кажется что-то пошло не так, возможно истёк срок хранения вашего заказа в Авоське :(</p><p>Необходимо <a href=\"/shirts/\">перезагрузить страницу</a>.</p>";
    } else {
	$ok = getNumOrder().".order";
	rename($f, $ok);
	$html = "<b>".$_POST["done"]."</b>\n";
    	    $html .= '<table cellspacing="0" cellpadding="0">'."\n";
    	    $html .= "<th>Джем</th><th>Наименование</th><th>Пол</th><th>Цвет</th><th>Размер</th><th>Кол-во</th><th>Стоимость</th>";
	    $count = 0;
	    $cost = 0;
    	    $file = file($ok);
	    foreach ($file as $f){
                $f = preg_replace("/\r\n|\r|\n/u", "", $f);
	    	$a = explode(";", $f);
	    	$count += (int)$a[5];
	    	$cost += (int)$a[5] * (int)$a[6];
	    	$html .= "<tr><td>{$aJam[$a[0]]}</td><td>{$aType[$a[1]]}</td><td>{$aGender[$a[2]]}</td><td>{$aColor[$a[3]]}</td>";
	    	$html .= "<td>".strtoupper($a[4])."</td><td>{$a[5]}</td><td>{$a[6]}</td></tr>";
	    }
	    $html .= "<tr><td colspan=\"5\"><strong>Итого</strong></td><td>{$count}</td><td>{$cost}</td></tr>";
	    $html .= "</table>";

	$headers = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset=utf-8;\r\n";		
	$headers .= "Date: " . date("r") . "\r\n";

	mail("mail4rumata@mail.ru", "Заказ футболок", $html, $headers);

	echo "<p></p><p>Заказ успешно отправлен!</p><p>Можно связаться с Сергеем Поповым в ФБ и узнать как оплатить и когда забраться заказ.</p><p>Спасибо!</p>";
    }
}
?>