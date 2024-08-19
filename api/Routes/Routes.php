<?php

use Minuz\Api\Http\Router;

Router::post('/acess/login', 'AcessController||login');
Router::post('/acess/signup', 'AcessController||signup');
Router::delete('/acess/logout', 'AcessController||logout');

Router::get('/mailbox/inbox', 'MailboxController||inbox');
Router::post('/mailbox/send', 'MailboxController||send');

Router::get('/videos/search?{query}', 'VideoController||search');
Router::get('/videos/search/{id}', 'VideoController||link');
Router::post('/videos/publish', 'VideoController||publish');