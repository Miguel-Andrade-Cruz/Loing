<?php
use Minuz\Loing\Model\User\Viewer;

require_once './vendor/autoload.php';


$miguel = new Viewer('miguelmiguel@gmail.com', '123123', new SplStack());

$miguel->search('#nina');
