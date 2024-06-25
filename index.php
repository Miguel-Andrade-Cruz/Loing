<?php

use Minuz\Loing\Content\StreamFile\Short\ShortFile;
use Minuz\Loing\Content\StreamFile\Video\VideoFile;
use Minuz\Loing\User\Account\Producer;
use Minuz\Loing\User\User;


$Tais = new User("Taís Andrade da Cruz", new Producer("Tata", "taisgamer@gmail.com", "123123"));

$Tais->Login("Tata", "taisgamer@gmail.com", "123123'");


$comendoMiojo = new VideoFile("Comi miojo e olha no que deu!!!", "Tais comendo algo cancerígeno", "Tais perdendo 5 anos de vida");
$Tais->createVideo($comendoMiojo, "vivendo mais 5 anos");

$Tais->postVideo("Vivendo mais 5 anos");