<?php

namespace Minuz\Api\Config\PDOQueries;


class PDOQueries
{
    public const SEARCH_VIDEO_QUERY =
    "
    SELECT
        videos.Title,
        videos.Channel,
        videos.Link,    
        videos.Content,
	    videos.Views,
        rating.likes,
        rating.dislikes

    FROM
	    loingdb.videos videos
    LEFT JOIN
	    loingdb.rating rating
    ON
	    rating.link = videos.Link

    WHERE
        videos.Title LIKE ':search'
    OR	videos.Channel LIKE ':search'
    ;
    "
    ;


    public const INBOX_QUERY = 
    "
    SELECT emailReciever, emailSender, text, date
    FROM loingdb.mailbox m
    WHERE m.emailReciever = ':email';
    "
    ;


    public const SEND_MAIL_QUERY = 
    "
    INSERT INTO loingdb.mailbox (emailReciever, emailSender, text, date)
    VALUES (':recieverMail', ':senderMail', ':textMail', ':dateMail');
    "
    ;


    public const LOGIN_QUERY = 
    "
    SELECT nickname, email FROM loingdb.accounts acc
    WHERE acc.email = ':email'
    AND acc.password = ':password';
    "
    ;


    public const SIGN_UP_CHECK_QUERY =
    "
    SELECT COUNT(*) AS checking
    FROM loingdb.accounts acc
    WHERE acc.email = ':email';
    "
    ;


    public const SIGN_UP_QUERY = 
    "
    INSERT INTO loingdb.accounts (nickname, email, password)
    VALUES (:nickname, :email, :password);
    "
    ;
}