<!DOCTYPE html>
<html prefix="og: http://ogp.me/ns#">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=800" />

    <meta property="og:type" content="website">
    <meta property="og:image" content="http://jam.elcentro.ru/img/logo_black_xl.png" />
    <meta property="og:image:width" content="952" />
    <meta property="og:image:height" content="500" />
    <meta property="og:url" content="http://jam.elcentro.ru/shirts/">
    <meta property='og:title' content='Футболки Джемов' />
    <meta property="og:description" content="Выбрать и заказать футболки с прошедших Джемов со скидками!" />

    <title>Футболки Джемов</title>
    
    <link rel="shortcut icon" href="/favicon.ico"/>
           
    <!-- css -->
    <link href="/css/default.css" rel="stylesheet" type="text/css"/> 
    <link href="/css/formview.css" rel="stylesheet" type="text/css"/>        
    
    <!-- js -->
    <script type="text/javascript" src="/js/jquery-1.11.1.min.js" ></script>  
    <script type="text/javascript" src="/js/jquery-migrate-1.2.1.min.js"></script>
    <!-- script type="text/javascript" src="/js/default.js"></script -->
    
    <!--[if lt IE 9]>
    <script>
    document.createElement('header');
    document.createElement('nav');
    document.createElement('section');
    document.createElement('article');
    document.createElement('aside');
    document.createElement('footer');
    document.createElement('figure');
    document.createElement('hgroup');
    document.createElement('menu');
    </script>
    <![endif]-->
    
</head>
<body class="color_scheme_blue">
<div id="splash" style="position: fixed;z-index: 10;background: black;display: none;opacity: .65;filter: alpha(opacity=65);width: 100%;height: 100%;">
	<div style="background: url(/img/eclipse.gif) no-repeat center center;position:fixed;height:100%;width:100%"></div></div>
    <header class="globalheader">

        <div class="container extendednav" id="header-container">

     
            <div class="clear-both"></div> 
        </div>        
        
    </header>
    
    <main class="maincontent" role="main">
        <div class="banner abstract_blue">
            <div class="container">

                <div class="h">Футболки Джемов</div>
                
                <div class="clear-both"></div>
            </div>
        </div>
        <div class="container">
            <div class="page">
                <article class="page-content" itemscope itemtype="http://schema.org/WebPage">
       
<div id="page" role="main" itemprop="description">
<h3>Заказы</h3>
<?php
if ( isset($_POST["order"]) ) {
    $files = scandir('orders');
    foreach ($files as $f)
        if (strpos($f, '.order') !== false) 
            if ($f == $_POST["order"]) {
                unlink("orders/$f");
                break;
            }
}

if(isset($_GET["access"])) {
    include_once 'const.php';

    $html = "";
    $html .= '<table cellspacing="0" cellpadding="0">'."\n";
    $html .= "<th>Джем</th><th>Наименование</th><th>Пол</th><th>Цвет</th><th>Размер</th><th>Кол-во</th><th>Стоимость</th><th>Действия</th>\n";
    $files = scandir('orders');
    foreach ($files as $f)
        if (strpos($f, '.order') !== false) {
            $af = explode(".", $f);
            $html .= "<tr><td colspan=\"8\"><b>". str_replace("_", " ", $af[1]) ."</b></td></tr>\n";
            $count = 0;
            $cost = 0;
            $file = file("orders/$f");
            foreach ($file as $f1){
                $f2 = preg_replace("/\r\n|\r|\n/u", "", $f1);
                $a = explode(";", $f2);
                $count += (int)$a[5];
                $cost += (int)$a[5] * (int)$a[6];
                $html .= "<tr><td>{$aJam[$a[0]]}</td><td>{$aType[$a[1]]}</td><td>{$aGender[$a[2]]}</td><td>{$aColor[$a[3]]}</td>";
                $html .= "<td>".strtoupper($a[4])."</td><td>{$a[5]}</td><td>{$a[6]}</td>";
                $html .= "<td><form method=\"POST\">
                <input type=\"hidden\" name=\"order\" value=\"{$f}\" />
                <input type=\"submit\" value=\"Удалить\" class=\"jfk-button jfk-button-action\" /></form></td></tr>\n";
            }
        }

    $html .= "</table>";
    echo $html;
}
?>
</div> 

    
                </article>
            </div>
        </div>
    </main>
    
    <!-- FOOTER -->
    <footer class="globalfooter" role="contentinfo">
        <div class="container">
            <div class="footer-block" id="copyright">
            </div>
        </div>       
    </footer>
    
</body>
</html>