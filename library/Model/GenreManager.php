<?php

namespace Model;

use Core\Manager;
use Entity\Shop\Game;

/**
 * Class genreManager
 *
 * Modélise le Manager des entités genre.
 * Permet d'intéragir avec la base de données pour échanger des informations sur les Genres
 */
class GenreManager extends Manager
{
    /**
     * Renvoie tous les genres existants dans la base de données
     *
     * @return mixed
     */
    public function getAllGenres()
    {
        $query = $this->db->query("SELECT * FROM myshop_genre");
        $query->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Shop\Genre');
        
        return $query->fetchAll();
    }

    /**
     * Renvoie la liste des genres d'un jeu donné
     *
     * @param Game $game
     *
     * @return mixed
     */
    public function getGenre(Game $game)
    {
        $query = $this->db->prepare(
            'SELECT id_genre, name 
            FROM myshop_game_has_genre 
            NATURAL JOIN myshop_genre
            WHERE id_game = :id'
        );
        
        $query->bindValue(':id', $game->getId(), \PDO::PARAM_INT);
        
        $query->execute();
        $query->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Shop\Genre');
        
        return $query->fetchAll();
    }
    
    public function getGenreById($idGenre)
    {
        $query = $this->db->prepare(
            'SELECT *
            FROM myshop_genre 
            WHERE id_genre = :id'
        );

        $query->bindValue(':id', $idGenre, \PDO::PARAM_INT);

        $query->execute();
        $query->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Shop\Genre');

        return $query->fetch();
    }
}
