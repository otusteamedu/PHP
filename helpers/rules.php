<?php

/**
 * This helper function returns validation request rules defined in config/rules.php
 */
function rules()
{
    return require_once './config/rules.php';
}
