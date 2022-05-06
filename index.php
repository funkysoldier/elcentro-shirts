<!DOCTYPE html>
<?php include '../main.php'; ?>
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

            <!-- div id="globalnav" class="dimmed">
                <div class="container">
                        <ul class="apps">
                           <?php getHeaderNav('1'); ?>
                        </ul>
                    <div class="clear-both"></div>
                     
                </div>
            </div -->

        <div class="container extendednav" id="header-container">

    <ul class="pages">
                 <!--?php 
                 getMenu('terms');
                 ? -->                       
    </ul>
      
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
	<p>После предыдущих Джемов и РеДжемов у нас осталось некоторое колличество сувенирных футболок, которые вы сможете приобрести со скидками. 
В форме ниже можно выбрать дизайн и посмотреть оставшиеся размеры.</p>
<style>
.float-logo {
	float: left; width: 14em; text-align: center; border: 1px solid #ccc; margin: 5px; cursor: pointer
}
.float-logo > img {
	height: 10em;
}
.float-logo:hover {
	border: 1px solid #c33
}
.float-logo.selected {
	border: 1px solid #c33
}
</style>
<script type="text/javascript">
var jam;
$( document ).ready(function() {
	$('#logo').html('<img src="img/loading1.gif" />');
	$('#cart').html('<img src="img/loading1.gif" />');
	$.post("data.php", {load: 1}, function (d){
		$('#logo').html(d);
	});
	$.post("data.php", {cart: 1}, function (d){
		$('#cart').html(d);
	});
    // автозагрузка
    let params = (new URL(document.location)).searchParams;
    if (params) {
        let jam = params.get("jam");
        if (jam)
            loadMe(jam);
    }
});

function loadMe(a){
	$('#result').html('<img src="img/loading1.gif" />');
	$.post("data.php", {jam: a}, function (d){
        $('.float-logo').removeClass('selected');
        $('#float_'+ a).addClass('selected');
		$('#form').html(d);
        jam = a;
		$('#result').html('');
	});
}

function confirmMe(a){
	$('#result').html('<img src="img/loading1.gif" />');
	$.post("data.php", {confirm: 1}, function (d){
		$('#confirm').html(d);
		$('#result').html(''); 
	});
}

function addToCart(a){
	$('#result').html('<img src="img/loading1.gif" />');
	$.post("data.php", {add: a}, function (c){
		$('#result').html(c);
		// обновить данные по джему
		var i = a.indexOf(";");
		loadMe(a.substring(0, i));
		$.post("data.php", {cart: 1}, function (d){
			$('#cart').html(d);
			$('#result').html('');
		});
	});	
}

function delFromCart(a){
	$('#result').html('<img src="img/loading1.gif" />');
	$.post("data.php", {del: a}, function (c){
		$('#result').html(c);
		// обновить данные по джему
		var i = a.indexOf(";");
		loadMe(a.substring(0, i));
		$.post("data.php", {cart: 1}, function (d){
			$('#cart').html(d);
			$('#result').html('');
		});
	});	
}

function clearCart(){
	$('#result').html('<img src="img/loading1.gif" />');
	$.post("data.php", {clear: 1}, function (d){
		$('#result').html(d);
        loadMe(jam);
        $.post("data.php", {cart: 1}, function (d){
			$('#cart').html(d);
			$('#result').html('');
		});
	});
}

function done(){
	$('#result').html('<img src="img/loading1.gif" />');
	$.post("data.php", {done: $('#name').val()}, function (d){
		$('#form').html(d);
		clearCart();
	});	
}
</script>
	<div id="logo"></div>
    <input id="jam" type="hidden" value="" />
	<div class="clear-both"></div>
	<div id="form"></div><br />
	<div id="result"></div>
	<div id="cart"></div>
</div> 

    
</article>

            </div>
        </div>
    </main>
    
    <!-- FOOTER -->
    <footer class="globalfooter" role="contentinfo">
        <div class="container">
            <div class="footer-block" id="copyright">
                <?php getFooter(); ?>
            </div>
        </div>       
    </footer>
    
</body>
</html>