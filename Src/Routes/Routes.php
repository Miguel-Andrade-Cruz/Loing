<?php
use Minuz\Api\Http\Router;

Router::get('/acess/login', 'AcessController||login');
Router::put('/acess/signup', 'AcessController||signup');
Router::get('/acess/logout', 'AcessController||logout');

Router::get('/mail/inbox', 'MailboxController||inbox');
Router::post('/mail/send', 'MailboxController||send');

Router::get('/videos/search?{query}', 'VideoController||search');
Router::get('/videos/search/{id}', 'VideoController||link');

Router::post('/videos/publish', 'VideoController||publish');
Router::get('/videos/library', 'VideoController||library');
Router::delete('/videos/delete/{id}', 'VideoController||delete');