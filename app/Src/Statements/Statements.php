<?php
namespace Minuz\Api\Statements;

enum Statements: string
{
    case LOGIN_EMPTY = 'Username or password fields sent empty';
    case INVALID_EMAIL_FORMAT = 'Email format not valid';
    case INVALID_LOGIN = 'Incorrect email or password';
    case ACCOUNT_ALREADY_EXISTS = 'Account already exists with this email';

    case LOGIN_EXPIRED = 'Login session expired, make a new login';
    case OTHER_LOGIN_TOKEN = 'Wrong login session, make a new login';
    case INVALID_LOGIN_TOKEN = 'Invalid sent token';
}
