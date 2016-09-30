<?php

namespace Model;

use Core\Manager;

/**
 * Class EditorManager
 *
 * Modélise le Manager des entités Editor.
 * Permet d'intéragir avec la base de données pour échanger des informations sur les Editeurs
 */
class EditorManager extends Manager
{
    public function getAllEditors()
    {
        $query = $this->db->prepare("SELECT * FROM myshop_editor ORDER BY name");

        $query->execute();
        $query->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Shop\Editor');

        return $query->fetchAll();
    }

    public function getEditorById($id)
    {
        $query = $this->db->prepare("SELECT * FROM myshop_editor WHERE id_editor = :id");
        $query->bindValue(':id', $id, \PDO::PARAM_INT);
        
        $query->execute();
        $query->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Shop\Editor');
        
        return $query->fetch();
    }
}
