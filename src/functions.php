<?php
/**
 * Created by: Ben Lewis
 * Date: 24/09/2019
 * Time: 14:00
 */

function db_connect()
{
    return mysqli_connect('127.0.0.1', 'root', 'reverse', 'cto');
}

function db_error($connection)
{
    return mysqli_error($connection);
}

function db_query($sql, $link)
{
    return mysqli_query($link, $sql);
}

function db_fetch_assoc($query)
{
    return mysqli_fetch_assoc($query);
}

function sanitizeString(string $value = '') {
    if(empty($value)) {
        return null;
    }

    return $value;
}

function sanitizeInt($value) {
    if(empty($value)) {
        return null;
    }

    return (int) $value;
}