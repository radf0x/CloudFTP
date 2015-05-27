<?php
define('ROOT_PATH', __DIR__);
require_once(ROOT_PATH . "/libraries/Language.php");
$lang = new Language();
$lang->load("language");
?>
<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="UTF-8" />
		<title><?php echo $lang->line("language.contacttitle")?></title>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" type="text/css" href="../css/uisearch/default.css" />
		<link rel="stylesheet" type="text/css" href="../css/uisearch/component.css" />
		<link rel="stylesheet" type="text/css" href="../css/menucss/normalize.css" />
		<link rel="stylesheet" type="text/css" href="../css/menucss/demo.css" />
		<link rel="stylesheet" type="text/css" href="../css/menucss/icons.css" />
		<link rel="stylesheet" type="text/css" href="../css/menucss/style3.css" />
		<link rel="stylesheet" type="text/css" href="../css/formcss/default.css" />
		<link rel="stylesheet" type="text/css" href="../css/formcss/component.css" />
		<link rel="stylesheet" type="text/css" href="../css/unsemantic-grid-responsive.css" />
		<script src="../js/uisearch/modernizr.custom.js"></script>
		<script src="../js/menujs/modernizr.custom.js"></script>
		<script src="../js/formjs/modernizr.custom.js"></script>
	</head>
	<body>
		<div class="container">
			<div class="column">
				<div id="sb-search" class="sb-search">
					<form>
						<input class="sb-search-input" placeholder="<?php echo $lang->line("language.searchbarplaceholder")?>" type="text" value="" name="search" id="search">
						<input class="sb-search-submit" type="submit" value="">
						<span class="sb-icon-search"></span>
					</form>
				</div>
			</div>
		</div>
		<div class="container">	
			<!--<div class="main">-->
				<form class="cbp-mc-form">
					<div class="cbp-mc-column">
						<label for="first_name"><?php echo $lang->line("language.firstname")?></label>
	  					<input type="text" id="first_name" name="first_name" placeholder="<?php echo $lang->line("language.firstnameplaceholder")?>">
	  					<label for="last_name"><?php echo $lang->line("language.lastname")?></label>
	  					<input type="text" id="last_name" name="last_name" placeholder="<?php echo $lang->line("language.lastnameplaceholder")?>">
	  					<label for="email"><?php echo $lang->line("language.emailaddress")?></label>
	  					<input type="text" id="email" name="email" placeholder="<?php echo $lang->line("language.emailaddressplaceholder")?>">
	  					<label for="country"><?php echo $lang->line("language.nationality")?></label>
	  					<select id="country" name="country">
	  						<option><?php echo $lang->line("language.choosenation")?></option>
	  						<option><?php echo $lang->line("language.na_hk")?></option>
	  						<option><?php echo $lang->line("language.na_us")?></option>
	  						<option><?php echo $lang->line("language.na_brit")?></option>
	  					</select>
	  				</div>
	  				<div class="cbp-mc-column">
	  					<label for="phone"><?php echo $lang->line("phonenum")?></label>
	  					<input type="text" id="phone" name="phone" placeholder="1234-5678">
						<label for="affiliations"><?php echo $lang->line("message")?></label>
	  					<textarea id="affiliations" name="msg"></textarea>
	  					<label><?php echo $lang->line("occupation")?></label>
	  					<select id="occupation" name="occupation">
	  						<option><?php echo $lang->line("chooseoccupation")?></option>
	  						<option><?php echo $lang->line("student")?></option>
	  						<option><?php echo $lang->line("normalpeople")?></option>
	  						<option><?php echo $lang->line("specialpeople")?></option>
	  						<option><?php echo $lang->line("programmer")?></option>
	  						<option><?php echo $lang->line("webdeveloper")?></option>
	  						
	  					</select>
	  				</div>
	  				<div class="cbp-mc-submit-wrap"><input class="cbp-mc-submit" type="submit" value="Send" /></div>
				</form>
			<!--</div>-->
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
						<a href="contact.php?lang=zh-TW" class="bt-icon icon-bubble">中文(繁體)</a>
					</li>
					<li>
						<a href="contact.php?lang=en-US" class="bt-icon icon-bubble">Eng(US)</a>
					</li>
				</ul>
		</nav>
		</div>

		<script src="../js/uisearch/classie.js"></script>
		<script src="../js/uisearch/uisearch.js"></script>
		<script src="../js/menujs/classie.js"></script>
		<script src="../js/menujs/borderMenu.js"></script>
		<script>
			new UISearch(document.getElementById('sb-search'));
		</script>
	</body>
</html>