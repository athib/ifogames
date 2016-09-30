<?php
namespace Core;

/**
 * Class PDOFactory
 * Cette classe possède une méthode statique qui permet de créér puis de retourner une instance de
 * la coonnexion à la base de Données
 *
 * TODO : déplacer la configuration des paramètres dans un fichier de config
 *
 * @package Core
 */
class PDOFactory
{
    public static function getMysqlConnexion()
    {
        $db = new \PDO(
            'mysql:host=localhost;dbname=ifocop_myshop;charset=utf8',
            'root',
            'root'
        );
        $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);

        return $db;
    }
}
