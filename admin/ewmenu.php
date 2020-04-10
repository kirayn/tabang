<?php
namespace PHPMaker2019\tabelo_admin;

// Menu Language
if ($Language && $Language->LanguageFolder == $LANGUAGE_FOLDER)
	$MenuLanguage = &$Language;
else
	$MenuLanguage = new Language();

// Navbar menu
$topMenu = new Menu("navbar", TRUE, TRUE);
echo $topMenu->toScript();

// Sidebar menu
$sideMenu = new Menu("menu", TRUE, FALSE);
$sideMenu->addMenuItem(9, "mi_news", $MenuLanguage->MenuPhrase("9", "MenuText"), "newslist.php", -1, "", IsLoggedIn() || AllowListMenu('{69E18FAC-2EFC-47EE-A765-B17249FAF990}news'), FALSE, FALSE, "", "", FALSE);
$sideMenu->addMenuItem(10, "mi_comments", $MenuLanguage->MenuPhrase("10", "MenuText"), "commentslist.php", -1, "", IsLoggedIn() || AllowListMenu('{69E18FAC-2EFC-47EE-A765-B17249FAF990}comments'), FALSE, FALSE, "", "", FALSE);
$sideMenu->addMenuItem(11, "mi_queries", $MenuLanguage->MenuPhrase("11", "MenuText"), "querieslist.php", -1, "", IsLoggedIn() || AllowListMenu('{69E18FAC-2EFC-47EE-A765-B17249FAF990}queries'), FALSE, FALSE, "", "", FALSE);
$sideMenu->addMenuItem(12, "mi_topics", $MenuLanguage->MenuPhrase("12", "MenuText"), "topicslist.php", -1, "", IsLoggedIn() || AllowListMenu('{69E18FAC-2EFC-47EE-A765-B17249FAF990}topics'), FALSE, FALSE, "", "", FALSE);
$sideMenu->addMenuItem(1, "mi_adverts", $MenuLanguage->MenuPhrase("1", "MenuText"), "advertslist.php?cmd=resetall", -1, "", IsLoggedIn() || AllowListMenu('{69E18FAC-2EFC-47EE-A765-B17249FAF990}adverts'), FALSE, FALSE, "", "", FALSE);
$sideMenu->addMenuItem(6, "mi_media", $MenuLanguage->MenuPhrase("6", "MenuText"), "medialist.php?cmd=resetall", -1, "", IsLoggedIn() || AllowListMenu('{69E18FAC-2EFC-47EE-A765-B17249FAF990}media'), FALSE, FALSE, "", "", FALSE);
$sideMenu->addMenuItem(2, "mi_categories", $MenuLanguage->MenuPhrase("2", "MenuText"), "categorieslist.php", -1, "", IsLoggedIn() || AllowListMenu('{69E18FAC-2EFC-47EE-A765-B17249FAF990}categories'), FALSE, FALSE, "", "", FALSE);
$sideMenu->addMenuItem(3, "mi_locations", $MenuLanguage->MenuPhrase("3", "MenuText"), "locationslist.php", -1, "", IsLoggedIn() || AllowListMenu('{69E18FAC-2EFC-47EE-A765-B17249FAF990}locations'), FALSE, FALSE, "", "", FALSE);
$sideMenu->addMenuItem(4, "mi_userprofiles", $MenuLanguage->MenuPhrase("4", "MenuText"), "userprofileslist.php?cmd=resetall", -1, "", IsLoggedIn() || AllowListMenu('{69E18FAC-2EFC-47EE-A765-B17249FAF990}userprofiles'), FALSE, FALSE, "", "", FALSE);
$sideMenu->addMenuItem(5, "mi_users", $MenuLanguage->MenuPhrase("5", "MenuText"), "userslist.php", -1, "", IsLoggedIn() || AllowListMenu('{69E18FAC-2EFC-47EE-A765-B17249FAF990}users'), FALSE, FALSE, "", "", FALSE);
echo $sideMenu->toScript();
?>
