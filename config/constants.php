<?php

//Start Session
session_start();

// Create Constants to Store non repeating  values
const SITEURL ='http://food-order.loc/';
const LOCALHOST = 'food-order.loc';
const DB_USERNAME = 'slava';
const DB_PASSWORD = '$Sl22061990';
const DB_NAME = 'food_order';

$connect = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME) or die(mysqli_error()); // Database connection

