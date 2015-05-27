<?php
define('ROOT_PATH', __DIR__);
require_once(ROOT_PATH . "/libraries/Language.php");
$lang = new Language();
$lang->load("language");
?>
<!DOCTYPE html>
<html lang="en-US" class="no-js">
	<head>
		<meta charset="UTF-8" />
		<title><?php echo $lang->line("language.hometitle")?></title>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" type="text/css" href="../css/uisearch/default.css" />
		<link rel="stylesheet" type="text/css" href="../css/uisearch/component.css" />
		<link rel="stylesheet" type="text/css" href="../css/menucss/normalize.css" />
		<link rel="stylesheet" type="text/css" href="../css/menucss/demo.css" />
		<link rel="stylesheet" type="text/css" href="../css/menucss/icons.css" />
		<link rel="stylesheet" type="text/css" href="../css/menucss/style3.css" />
		<link rel="stylesheet" type="text/css" href="../css/nlpformcss/default.css" />
		<link rel="stylesheet" type="text/css" href="../css/nlpformcss/component.css" />
		<link rel="stylesheet" type="text/css" href="../css/unsemantic-grid-responsive.css" />
		<script src="../js/uisearch/modernizr.custom.js"></script>
		<script src="../js/menujs/modernizr.custom.js"></script>
		<script src="../js/nlpformjs/modernizr.custom.js"></script>
	</head>
	<body>
		<div class="container">
			<div class="column">
				<div id="sb-search" class="sb-search">
					<form action="result.html" method="action">
						<input class="sb-search-input" placeholder="<?php echo $lang->line("language.searchbarplaceholder")?>" type="text" value="" name="search" id="search">
						<input class="sb-search-submit" type="submit" value="" id="search-submit">
						<span class="sb-icon-search"></span>
					</form>
				</div>
			</div>
			<div class="main clearfix">
				<div id="nl-form" class="nl-form">
					<?php echo $lang->line("language.welcome")?>
					<select id="location">
						<option value="Any place" selected><?php echo $lang->line("language.anyplace")?></option>
						<option value="Kowloon"><?php echo $lang->line("language.kowloon")?></option>
						<option value="HK Island"><?php echo $lang->line("language.hkisland")?></option>
						<option value="Aberdeen"><?php echo $lang->line("language.aberdeen")?></option>
						<option value="Wanchai"><?php echo $lang->line("language.wanchai")?></option>
						<option value="Central"><?php echo $lang->line("language.central")?></option>
						<option value="Sheung Wan"><?php echo $lang->line("language.sheungwan")?></option>
						<option value="Tuen Mun"><?php echo $lang->line("language.tuenmun")?></option>
						<option value="Pok Fu Lam"><?php echo $lang->line("language.pokfulam")?></option>
						<option value="Yau Tong"><?php echo $lang->line("language.yautong")?></option>
						<option value="Tai Hang Tung"><?php echo $lang->line("language.taihangtung")?></option>
						<option value="New Territories"><?php echo $lang->line("language.newterritories")?></option>
						<option value="Kwun Tong"><?php echo $lang->line("language.kwuntong")?></option>
						<option value="Ho Man Tin"><?php echo $lang->line("language.homantin")?></option>
						<option value="Sai Wan"><?php echo $lang->line("language.saiwan")?></option>
						<option value="Sai Ying Pun"><?php echo $lang->line("language.saiyinpun")?></option>
						<option value="North Point"><?php echo $lang->line("language.northpoint")?></option>
						<option value="Causeway Bay"><?php echo $lang->line("language.causewaybay")?></option>
						<option value="Lantau Island"><?php echo $lang->line("language.lantauisland")?></option>
						<option value="Mong Kok"><?php echo $lang->line("language.mongkok")?></option>
					</select>
					<?php echo $lang->line("language.welcome2")?>
					<br />
					<div class="nl-submit-wrap">
						<button id="nl-submit-btn" class="nl-submit" type="submit">
							<?php echo $lang->line("language.find")?>
						</button>
					</div>
					<div class="nl-overlay"></div>
				</div>
			</div>

			<nav id="bt-menu" class="bt-menu">
				<a href="#" class="bt-menu-trigger"><span>Menu</span></a>
				<ul>
					<li>
						<a href="home.php" class="bt-icon icon-user-outline"><?php echo $lang->line("language.home")?></a>
					</li>
					<li>
						<a href="timeLine.php" class="bt-icon icon-sun"><?php echo $lang->line("language.timeline")?></a>
					</li>
					<li>
						<a href="NameIndex.php" class="bt-icon icon-windows"><?php echo $lang->line("language.index")?></a>
					</li>
					<li>
						<a href="showMap.php" class="bt-icon icon-bubble"><?php echo $lang->line("language.map")?></a>
					</li>
					<li>
						<a href="siteMap.php" class="bt-icon icon-star"><?php echo $lang->line("language.sitemap")?></a>
					</li>
					<li>
						<a href="contact.php" class="bt-icon icon-speaker"><?php echo $lang->line("language.contact")?></a>
					</li>
					<li>
						<a href="home.php?lang=zh-TW" class="bt-icon icon-bubble">中文(繁體)</a>
					</li>
					<li>
						<a href="home.php?lang=en-US" class="bt-icon icon-bubble">Eng(US)</a>
					</li>
				</ul>
			</nav>
		</div><!-- /container -->
		<script src="../js/uisearch/classie.js"></script>
		<script src="../js/uisearch/uisearch.js"></script>
		<script src="../js/menujs/classie.js"></script>
		<script src="../js/menujs/borderMenu.js"></script>
		<script src="../js/nlpformjs/nlform.js"></script>
		
		<script src="../js/jquery-1.10.2.js"></script>
		<script src="../js/jquery.cookie.js"></script>
		<script src="../js/jquery-ui-1.10.4.custom.min.js"></script>
		
		<script src="processSearch.js"></script>
		<script>
			new UISearch(document.getElementById('sb-search'));
			var nlform = new NLForm(document.getElementById('nl-form'));
		</script>
	</body>
</html>