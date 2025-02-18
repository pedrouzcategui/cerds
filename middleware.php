<?php

function checkAuth()
{
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header("Location: ./signin");
        exit();
    }
}
