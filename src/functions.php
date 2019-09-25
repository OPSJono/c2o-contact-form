<?php
/**
 * Created by: Ben Lewis
 * Date: 24/09/2019
 * Time: 14:00
 */

function db_connect()
{
    return mysqli_connect('127.0.0.1', 'homestead', 'secret', 'devtest');
}

function db_query($sql, $link)
{
    return mysqli_query($link, $sql);
}

function db_fetch_assoc($query)
{
    return mysqli_fetch_assoc($query);
}