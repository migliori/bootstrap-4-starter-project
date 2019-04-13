<?php
use bootstrap\navbar\Navbar;
use bootstrap\navbar\NavbarNav;
use bootstrap\navbar\NavbarDropdown;
use bootstrap\navbar\NavbarForm;

$navbar = new Navbar('main-nav');
$navbar->addBrand('#', 'Brand');
$navbar_nav = new NavbarNav();
$navbar_nav->addLink('#', 'Link');
$dropdown = new NavbarDropdown('NavbarDropdown <b class="caret"></b>');
$dropdown->addLink('#', 'action');
$dropdown->addDivider();
$dropdown->addLink('#', 'Separated link');
$navbar_nav->addContent($dropdown);
$navbar->addContent($navbar_nav);
$navbar_form = new NavbarForm('class=navbar-form navbar-left, action=index.php, method=post, role=search');
$navbar_form->addInput('text', 'placeholder=Search');
$navbar_form->startButtonGroup();
$navbar_form->addButton('cancel', 'cancel', 'class=btn btn-default, value=cancel');
$navbar_form->addButton('submit', 'submit', 'class=btn btn-default');
$navbar_form->endButtonGroup();
$navbar->addContent($navbar_form);
$navbar->render();
