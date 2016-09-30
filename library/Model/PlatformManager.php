<?php

namespace Model;

use Core\Manager;
use Entity\Shop\Game;

/**
 * Class PlatformManager
 *
 * Modélise le Manager des entités Platform.
 * Permet d'intéragir avec la base de données pour échanger des informations sur les Plateformes
 */
class PlatformManager extends Manager
{
    /**
     * Renvoie toutes les plateformes existantes dans la base de données
     *
     * @return mixed
     */
    public function getAllPlatforms()
    {
        $query = $this->db->query("SELECT * FROM myshop_platform ORDER BY full_name");
        $query->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Shop\Platform');
        
        return $query->fetchAll();
    }
    
    public function getPlatforms(Game $game)
    {
        $query = $this->db->prepare(
            'SELECT id_platform, short_name, full_name, owner, release_date, stock
            FROM myshop_game_has_platform 
            NATURAL JOIN myshop_platform
            WHERE id_game = :id'
        );
        
        $query->bindValue(':id', $game->getId(), \PDO::PARAM_INT);
        
        $query->execute();
        $query->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Shop\Platform');
        
        return $query->fetchAll();
    }
    
    /**
     * Renvoie l'instance de Platform correspondant à l'id donné
     *
     * @param $id
     *
     * @return mixed
     */
    public function getPlatform($id)
    {
        $query = $this->db->prepare(
            "SELECT * 
            FROM myshop_platform
            WHERE id_platform = :id"
        );
        
        $query->bindValue(':id', $id, \PDO::PARAM_INT);
        
        $query->execute();
        $query->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Shop\Platform');
        
        return $query->fetch();
    }
}
