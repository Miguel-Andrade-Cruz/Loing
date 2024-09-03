<?php
namespace Minuz\Api\Statements;

class Statements
{
    public static string $LOGIN_EMPTY = 'Username or password fields sent empty';
    public static string $INVALID_EMAIL_FORMAT = 'Email format not valid';
    public static string $INVALID_LOGIN = 'Incorrect email or password';
    public static string $ACCOUNT_ALREADY_EXISTS = 'Account already exists with this email';

    public static string $LOGIN_EXPIRED = 'Login session expired, make a new login';
    public static string $OTHER_LOGIN_TOKEN = 'Wrong login session, make a new login';
    public static string $INVALID_LOGIN_TOKEN = 'Invalid sent token';
}
