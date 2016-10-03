<?php

namespace Model;

use Core\ArrayCollection;
use Core\Tools;
use Entity\Shop\Game;
use Core\Manager;

/**
 * Class GameManager
 *
 * Modélise le Manager des entités Game.
 * Permet d'intéragir avec la base de données pour échanger des informations sur les Jeux
 */
class GameManager extends Manager
{
    /**
     * Récupère la liste de tous les jeux en base de données, avec éditeur et genres
     *
     * @return ArrayCollection
     */
    public function getAllGames($limit = null)
    {
        $sql = 'SELECT * FROM myshop_game';

        if ($limit !== null) {
            $sql .= " ORDER BY id_game DESC LIMIT $limit";
        }

        $query = $this->db->prepare($sql);
    
        $query->execute();
        $query->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Shop\Game');
        
        $games = new ArrayCollection();
        $editorManager = new EditorManager($this->db);
        $genreManager = new GenreManager($this->db);
        $platformManager = new PlatformManager($this->db);
        
        while ($game = $query->fetch()) {
            $editor = $editorManager->getEditorById($game->getIdEditor());
            $genres = $genreManager->getGenre($game);
            $platforms = $platformManager->getPlatforms($game);
            
            $game->setEditor($editor);
            $game->setGenres($genres);
            $game->setPlatforms($platforms);

            $games->addElement($game);
        }
    
        return $games;
    }
    
    /**
     * Renvoie une instance de Game selon un id donné
     *
     * @param $id
     *
     * @return \Entity\Game
     */
    public function getGame($id)
    {
        $query = $this->db->prepare(
            "SELECT * 
            FROM myshop_game
            WHERE id_game = :id"
        );
        
        $query->bindValue(':id', $id, \PDO::PARAM_INT);
    
        $query->execute();
        $query->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Shop\Game');

        $game = $query->fetch();

        if (!$game) {
            return null;
        }

        $platforms = (new PlatformManager($this->db))->getPlatforms($game);
        $genres = (new GenreManager($this->db))->getGenre($game);
        $editor = (new EditorManager($this->db))->getEditorById($game->getIdEditor());
        $game->setPlatforms($platforms);
        $game->setGenres($genres);
        $game->setEditor($editor);


        return $game;
    }
    
    /**
     * Renvoie tous les jeux d'une commande donnée
     *
     * @param $id_order
     *
     * @return mixed
     */
    public function getGamesFromOrder($id_order)
    {
        $query = $this->db->prepare(
            "SELECT * 
            FROM myshop_game
            NATURAL JOIN myshop_order_has_game
            WHERE id_order = :id"
        );

        $query->bindValue(':id', $id_order, \PDO::PARAM_INT);

        $query->execute();
        $query->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Shop\Game');

        $games = $query->fetchAll();
        $platformMgr = new PlatformManager($this->db);

        foreach ($games as &$game) {
            $game->setOrderedPlatform($platformMgr->getPlatform($game->id_platform));
        }

        return $games;
    }

    public function save(\Entity\Shop\Game $game)
    {
        if ($game->isNew()) {
            /*** Ajout Game ***/
            $game->setSlug(Tools::slugify($game->getTitle()));

            $query = $this->db->prepare(
                "INSERT INTO myshop_game (title, description, id_editor, release_date, price, pegi, slug)
                VALUES (:title, :description, :idEditor, :releaseDate, :price, :pegi, :slug)"
            );

            $query->bindValue(':title', $game->getTitle(), \PDO::PARAM_STR);
            $query->bindValue(':description', $game->getDescription(), \PDO::PARAM_STR);
            $query->bindValue(':idEditor', $game->getIdEditor(), \PDO::PARAM_INT);
            $query->bindValue(':releaseDate', $game->getReleaseDate(), \PDO::PARAM_STR);
            $query->bindValue(':price', $game->getPrice(), \PDO::PARAM_STR);
            $query->bindValue(':pegi', $game->getPegi(), \PDO::PARAM_STR);
            $query->bindValue(':slug', $game->getSlug(), \PDO::PARAM_STR);

            $query->execute();

            $lastGameId = $this->db->lastInsertId();
            $game->setId($lastGameId);


            /*** Ajout des correspondances Game / Genres ***/

            $idGenre = null;
            $query = $this->db->prepare(
                "INSERT INTO myshop_game_has_genre (id_game, id_genre)
                VALUES (:idGame, :idGenre)"
            );
            $query->bindValue(':idGame', $lastGameId, \PDO::PARAM_INT);
            $query->bindParam(':idGenre', $idGenre, \PDO::PARAM_INT);

            foreach ($game->getGenres() as $genre) {
                $idGenre = $genre->getId();
                $query->execute();
            }

            /*** Ajout correspondances Game / Platforms ***/

            $idPlatform = null;
            $query = $this->db->prepare(
                "INSERT INTO myshop_game_has_platform (id_game, id_platform)
                VALUES (:idGame, :idPlatform)"
            );
            $query->bindValue(':idGame', $lastGameId, \PDO::PARAM_INT);
            $query->bindParam(':idPlatform', $idPlatform, \PDO::PARAM_INT);

            foreach ($game->getPlatforms() as $platform) {
                $idPlatform = $platform->getId();
                $query->execute();
            }
        } else { /* UPDATE Game */
            $game->setSlug(Tools::slugify($game->getTitle()));

            $query = $this->db->prepare(
                "UPDATE myshop_game
                 SET 
                    title = :title, 
                    description = :description,
                    id_editor = :idEditor, 
                    release_date = :releaseDate, 
                    price = :price, 
                    pegi = :pegi, 
                    slug = :slug
                 WHERE id_game = :idGame"
            );

            $query->bindValue(':idGame', $game->getId(), \PDO::PARAM_INT);
            $query->bindValue(':title', $game->getTitle(), \PDO::PARAM_STR);
            $query->bindValue(':description', $game->getDescription(), \PDO::PARAM_STR);
            $query->bindValue(':idEditor', $game->getIdEditor(), \PDO::PARAM_INT);
            $query->bindValue(':releaseDate', $game->getReleaseDate(), \PDO::PARAM_STR);
            $query->bindValue(':price', $game->getPrice(), \PDO::PARAM_STR);
            $query->bindValue(':pegi', $game->getPegi(), \PDO::PARAM_STR);
            $query->bindValue(':slug', $game->getSlug(), \PDO::PARAM_STR);

            $query->execute();


            /*** Ajout des correspondances Game / Genres ***/
            $query = $this->db->prepare(
                "DELETE FROM myshop_game_has_genre 
                WHERE id_game = :idGame"
            );
            $query->bindValue(':idGame', $game->getId(), \PDO::PARAM_INT);
            $query->execute();

            $idGenre = null;
            $query = $this->db->prepare(
                "INSERT INTO myshop_game_has_genre (id_game, id_genre)
                VALUES (:idGame, :idGenre)"
            );
            $query->bindValue(':idGame', $game->getId(), \PDO::PARAM_INT);
            $query->bindParam(':idGenre', $idGenre, \PDO::PARAM_INT);

            foreach ($game->getGenres() as $genre) {
                $idGenre = $genre->getId();
                $query->execute();
            }

            /*** Ajout correspondances Game / Platforms ***/
            $query = $this->db->prepare(
                "DELETE FROM myshop_game_has_platform 
                WHERE id_game = :idGame"
            );
            $query->bindValue(':idGame', $game->getId(), \PDO::PARAM_INT);
            $query->execute();

            $idPlatform = null;
            $query = $this->db->prepare(
                "INSERT INTO myshop_game_has_platform (id_game, id_platform)
                VALUES (:idGame, :idPlatform)"
            );
            $query->bindValue(':idGame', $game->getId(), \PDO::PARAM_INT);
            $query->bindParam(':idPlatform', $idPlatform, \PDO::PARAM_INT);

            foreach ($game->getPlatforms() as $platform) {
                $idPlatform = $platform->getId();
                $query->execute();
            }
        }

        return $game;
    }
    
    public function delete($id)
    {
        $query = $this->db->prepare("SELECT * FROM myshop_game WHERE id_game = :idGame");
        $query->bindValue(':idGame', $id, \PDO::PARAM_INT);
        $query->execute();
        $res = $query->fetch();

        $queryDeleteGame = $this->db->prepare("DELETE FROM myshop_game WHERE id_game = :idGame");
        $queryDeleteGame->bindValue(':idGame', $id, \PDO::PARAM_INT);

        $queryDeleteGameGenres = $this->db->prepare("DELETE FROM myshop_game_has_genre WHERE id_game = :idGame");
        $queryDeleteGameGenres->bindValue(':idGame', $id, \PDO::PARAM_INT);

        $queryDeleteGamePlatforms = $this->db->prepare("DELETE FROM myshop_game_has_platform WHERE id_game = :idGame");
        $queryDeleteGamePlatforms->bindValue(':idGame', $id, \PDO::PARAM_INT);

        $queryDeleteGamePlatforms->execute();
        $queryDeleteGameGenres->execute();
        $queryDeleteGame->execute();

        if ($res && !empty($res['jacket'])) {
            $filePath = sprintf(
                '%s%s%s%s',
                $_SERVER['DOCUMENT_ROOT'],
                ROOTADDRESS,
                '/resources/img/games/',
                $res['jacket']
            );

            unlink($filePath);
        }
    }

    public function getMostSold($limit)
    {
        $query = $this->db->prepare(
            "SELECT title, ohg.id_game, ohg.id_platform, COUNT(*) AS nb
            FROM myshop_order_has_game AS ohg
            INNER JOIN myshop_game AS g ON g.id_game = ohg.id_game
            GROUP BY ohg.id_game
            ORDER BY nb DESC
            LIMIT :limit"
        );
        
        $query->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $query->execute();
        
        $games = new ArrayCollection();
        
        while ($res = $query->fetch()) {
            $games->addElement($this->getGame($res['id_game']));
        }

        return $games;
    }

    public function searchGame($words)
    {
        $words = explode(',', $words);

        $like = implode(' OR title LIKE ', array_map(function ($word) {
            return "'%$word%'";
        }, $words));

        $query = $this->db->prepare(
            "SELECT *
            FROM myshop_game
            WHERE title LIKE $like"
        );

        $query->execute();
        $results = $query->fetchAll();

        $games = array();
        foreach ($results as $result) {
            $games[] = $this->getGame($result['id_game']);
        }

        return $games;
    }

    public function savePicture($id, Game $game, $requestFile)
    {
        $fileParts = pathinfo($requestFile['name']);
        $rootAddress = $_SERVER['DOCUMENT_ROOT'].ROOTADDRESS.'/resources/img/games';
        $fileName = sprintf('%d_%s.%s', $id, $game->getSlug(), $fileParts['extension']);

        $fullPath = $rootAddress.'/'.$fileName;

        move_uploaded_file($requestFile['tmp_name'], $fullPath);

        $query = $this->db->prepare(
            "UPDATE myshop_game 
            SET jacket = :jacket
            WHERE id_game = :idGame"
        );

        $query->bindValue(':jacket', $fileName, \PDO::PARAM_STR);
        $query->bindValue(':idGame', $id, \PDO::PARAM_INT);
        $query->execute();
    }
    
    public function getStockOnPlatform(Game $game, $idPlatform)
    {
        $query = $this->db->prepare(
            "SELECT *
            FROM myshop_game_has_platform
            WHERE id_game = :idGame
            AND id_platform = :idPlatform"
        );

        $query->bindValue(':idGame', $game->getId(), \PDO::PARAM_INT);
        $query->bindValue(':idPlatform', $idPlatform, \PDO::PARAM_INT);
        $query->execute();
        
        $res = $query->fetch();
        
        return $res['stock'];
    }
}
