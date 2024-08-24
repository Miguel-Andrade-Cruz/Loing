<?php

use Minuz\Api\Http\Router;

Router::get('/acess/login', 'AcessController||login');
Router::put('/acess/signup', 'AcessController||signup');
Router::get('/acess/logout', 'AcessController||logout');

Router::get('/mailbox/inbox', 'MailboxController||inbox');
Router::post('/mailbox/send', 'MailboxController||send');

Router::get('/videos/search?{query}', 'VideoController||search');
Router::get('/videos/search/{id}', 'VideoController||link');
Router::post('/videos/publish', 'VideoController||publish');