<?php

require_once __DIR__.'/resources/partials/tools.php';

// Application par défaut
const DEFAULT_APP = 'Frontend';

// Si l'application n'est pas valide, on charge l'application par défaut qui se chargera de générer une erreur 404
if (!isset($_GET['app']) || !file_exists(__DIR__.'/App/'.$_GET['app']))
	$_GET['app'] = DEFAULT_APP;

// Classe qui permet de gérer tous les autoloads
require __DIR__ . '/library/Core/SplClassLoader.php';

// On enregistre les autoloads
$coreLoader = new SplClassLoader('Core', __DIR__.'/library');
$coreLoader->register();

$appLoader = new SplClassLoader('App', __DIR__.'/');
$appLoader->register();

$modelLoader = new SplClassLoader('Model', __DIR__.'/library');
$modelLoader->register();

$entityLoader = new SplClassLoader('Entity', __DIR__.'/library');
$entityLoader->register();

$formLoader = new SplClassLoader('FormBuilder', __DIR__.'/library');
$formLoader->register();

$formLoader = new SplClassLoader('External', __DIR__.'/library');
$formLoader->register();


// On récupère le nom de l'application à démarrer, puis on l'exécute
$appClass = 'App\\'.$_GET['app'].'\\'.$_GET['app'].'Application';


// Instanciation et execution de l'application
$app = new $appClass;
$app->run();