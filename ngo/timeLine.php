<?php
define('ROOT_PATH', __DIR__);
require_once(ROOT_PATH . "/libraries/Language.php");
$lang = new Language();
$lang->load("language");
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<title>Timeline</title>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" type="text/css" href="../css/uisearch/default.css" />
		<link rel="stylesheet" type="text/css" href="../css/uisearch/component.css" />
		<link rel="stylesheet" type="text/css" href="../css/menucss/normalize.css" />
		<link rel="stylesheet" type="text/css" href="../css/menucss/demo.css" />
		<link rel="stylesheet" type="text/css" href="../css/menucss/icons.css" />
		<link rel="stylesheet" type="text/css" href="../css/menucss/style3.css" />
		<link rel="stylesheet" type="text/css" href="../css/timelinecss/default.css" />
		<link rel="stylesheet" type="text/css" href="../css/timelinecss/component.css" />
		<link rel="stylesheet" type="text/css" href="../css/timeline_overlay.css" />
		<link rel="stylesheet" type="text/css" href="../css/unsemantic-grid-responsive.css" />
		<script src="../js/uisearch/modernizr.custom.js"></script>
		<script src="../js/menujs/modernizr.custom.js"></script>
		<script src="../js/timelinejs/modernizr.custom.js"></script>
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
		<div class="overlay"></div>
		<div class="modal">
			<div id="dialog"></div>
			<div id="divMap" style="width: 200px; height: 200px"></div>
		</div>
		<div class="main">
			<ul class="cbp_tmtimeline">
				<li>
					<time class="cbp_tmtime" datetime="1960">
						<span>60s</span>
					</time>
					<div class="cbp_tmicon cbp tmicon-earth"></div>
					<div class="cbp_tmlabel">
						<h2>From 1960</h2>
						<p>
							<div class="year" id="60_1">1963 <?php echo $lang->line("language.heephong")?></div>
							<br />
							<div class="year" id="60_2">1964 <?php echo $lang->line("language.rehabilitation")?></div>
							<br />
							<div class="year" id="60_3">1965 <?php echo $lang->line("language.faithfulness")?></div>
							<br />
							<div class="year" id="60_4">1968 <?php echo $lang->line("language.habitat")?></div>
							<br />
							<div class="year" id="60_5">1968 <?php echo $lang->line("language.deaf")?></div>
							<br />
							<div class="year" id="60_6">1968 <?php echo $lang->line("language.conservancy")?></div>
							<br />
							<div class="year" id="60_7">1969 <?php echo $lang->line("language.friendsofearth")?></div>
						</p>
					</div>
				</li>
				<li>
					<time class="cbp_tmtime" datetime="1970">
						<span>70s</span>
					</time>
					<div class="cbp_tmicon cbp tmicon-earth"></div>
					<div class="cbp_tmlabel">
						<h2>From 1970</h2>
						<p>
							<div class="year" id="70_1">1970 <?php echo $lang->line("language.handicap")?></div>
							<br />
							<div class="year" id="70_2">1971 <?php echo $lang->line("language.msf")?></div>
							<br />
							<div class="year" id="70_3">1972 <?php echo $lang->line("language.greenpeace")?></div>
							<br />
							<div class="year" id="70_4">1973 <?php echo $lang->line("language.adventureship")?></div>
							<br />
							<div class="year" id="70_5">1975 <?php echo $lang->line("language.disabledassociation")?></div>
						</p>
					</div>
				</li>
				<li>
					<time class="cbp_tmtime" datetime="1980">
						<span>80s</span>
					</time>
					<div class="cbp_tmicon cbp_tmicon-earth"></div>
					<div class="cbp_tmlabel">
						<h2>From 1980</h2>
						<p>
							<div class="year" id="80_1">1982 <?php echo $lang->line("language.orbis")?></div>
							<br />
							<div class="year" id="80_2">1986 <?php echo $lang->line("language.bethune")?></div>
							<br />
							<div class="year" id="80_3">1987 <?php echo $lang->line("language.motherchoice")?></div>
							<br />
							<div class="year" id="80_4">1987 <?php echo $lang->line("language.barnabss")?></div>
							<br />
							<div class="year" id="80_5">1988 <?php echo $lang->line("language.greenpower")?></div>
							<br />
							<div class="year" id="80_6">1989 <?php echo $lang->line("language.greenlantau")?></div>
						</p>
					</div>
				</li>
				<li>
					<time class="cbp_tmtime" datetime="1990">
						<span>90s</span>
					</time>
					<div class="cbp_tmicon cbp_tmicon-earth"></div>
					<div class="cbp_tmlabel">
						<h2>From 1990</h2>
						<p>
							<div class="year" id="90_1">1990 <?php echo $lang->line("language.environmentalcampaign")?></div>
							<br />
							<div class="year" id="90_2">1991 <?php echo $lang->line("language.rootsshoots")?></div>
							<br />
							<div class="year" id="90_3">1992 <?php echo $lang->line("language.careministries")?></div>
							<br />
							<div class="year" id="90_4">1992 <?php echo $lang->line("language.redress")?></div>
							<br />
							<div class="year" id="90_5">1993 <?php echo $lang->line("language.nesbitt")?></div>
							<br />
							<div class="year" id="90_6">1995 <?php echo $lang->line("language.crossroads")?></div>
							<br />
							<div class="year" id="90_7">1995 <?php echo $lang->line("language.dolphinwatch")?></div>
							<br />
							<div class="year" id="90_8">1996 <?php echo $lang->line("language.jockeyclub")?></div>
							<br />
							<div class="year" id="90_9">1997 <?php echo $lang->line("language.cleartheair")?></div>
							<br />
							<div class="year" id="90_10">1998 <?php echo $lang->line("language.chiheng")?></div>
						</p>
					</div>
				</li>
				<li>
					<time class="cbp_tmtime" datetime="2000">
						<span>00s</span>
					</time>
					<div class="cbp_tmicon cbp_tmicon-earth"></div>
					<div class="cbp_tmlabel">
						<h2>From 2000</h2>
						<p>
							<div class="year" id="00_1">2000 <?php echo $lang->line("language.greencouncil")?></div>
							<br />
							<div class="year" id="00_2">2002 <?php echo $lang->line("language.orphandisease")?></div>
							<br />
							<div class="year" id="00_3">2003 <?php echo $lang->line("language.cws")?></div>
							<br />
							<div class="year" id="00_4">2006 <?php echo $lang->line("language.childmedical")?></div>
							<br />
							<div class="year" id="00_5">2006 <?php echo $lang->line("language.vision")?></div>
							<br />
							<div class="year" id="00_6">2008 <?php echo $lang->line("language.kids4kids")?></div>
							<br />
							<div class="year" id="00_7">2008 <?php echo $lang->line("language.hksf")?></div>
							<br />
							<div class="year" id="00_8">2009 <?php echo $lang->line("language.feedinghk")?></div>
							<br />
							<div class="year" id="00_9">2009 <?php echo $lang->line("language.go2serve")?></div>
							<br />
							<div class="year" id="00_10">2009 <?php echo $lang->line("language.clearairnetwork")?></div>
						</p>
					</div>
				</li>
			</ul>
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
						<a href="timeline.php?lang=zh-TW" class="bt-icon icon-bubble">中文(繁體)</a>
					</li>
					<li>
						<a href="timeline.php?lang=en-US" class="bt-icon icon-bubble">Eng(US)</a>
					</li>
				</ul>
		</nav>
		<script src="../js/uisearch/classie.js"></script>
		<script src="../js/uisearch/uisearch.js"></script>
		<script src="../js/menujs/classie.js"></script>
		<script src="../js/menujs/borderMenu.js"></script>
		<!--<script type="text/javascript" src="../js/jquery.ui.map.full.min.js"></script>-->
		<script type="text/javascript" src="../js/jquery-1.10.2.js"></script>
		<script type="text/javascript" src="//maps.google.com/maps/api/js?sensor=false"></script>
		<script src="createTimeline.js"></script>
		<script>
			new UISearch(document.getElementById('sb-search'));
		</script>
	</body>
</html>