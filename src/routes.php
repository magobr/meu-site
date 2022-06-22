<?php
require_once __DIR__.'/controllers/ViewController.php';

use Pecee\SimpleRouter\SimpleRouter;
use View\Controller\ViewController;

SimpleRouter::get('/', [ViewController::class, "renderPage"]);