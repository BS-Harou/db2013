<?php

if ($app->user) {
	session_destroy();
}

$app->redirect('main');