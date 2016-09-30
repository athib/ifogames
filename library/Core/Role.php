<?php
namespace Core;

/**
 * Class Role
 * Charge le fichier de configuration des roles défini dans App/Backend/Config/roles.xml
 * Et implémente une méthode permettant de retourner une liste des accès en fonction d'un rôle, 
 * ou NULL si le rôle n'existe pas
 *
 * @package Core
 */
class Role extends ApplicationComponent
{
    private $rolesFromXml;
    private $roles;

    /**
     * Role constructor.
     * Charge le fichier de configuration des rôles
     * Puis convertit la structure (voir méthode convertRoles)
     */
    public function __construct()
    {
        $this->rolesFromXml = array();

        $this->loadFile();
        $this->convertRoles();
    }

    /**
     * Méthode qui charge en mémoire la structure des rôles définis dans le fichier de configuration
     * des rôles
     */
    private function loadFile()
    {
        // On charge le fichier xml
        $xml = new \DOMDocument;
        $xml->load(__DIR__.'/../../App/Config/roles.xml');

        // On récupère tous les rôles (balises <role>)
        $elements = $xml->getElementsByTagName('role');

        // Pour chaque "role"
        foreach ($elements as $element) {
            // S'il y a des enfants (sous-rôles), on les récupère
            if ($element->hasChildNodes()) {
                $children = $element->getElementsByTagName('granted');
                foreach ($children as $child) {
                    $this->rolesFromXml[$element->getAttribute('name')][] = $child->getAttribute('role');
                }
            } else {
                $this->rolesFromXml[$element->getAttribute('name')] = array();
            }
        }
    }

    /**
     * Méthode qui convertit la structure des rôles après chargement du fichier, en tableau qui,
     * pour chaque indice (rôle), contient la liste des accès spécifique au rôle
     *
     * On fait appel à la méthode récursive getRolesList() définie dans cette classe
     */
    private function convertRoles()
    {
        foreach ($this->rolesFromXml as $key => $value) {
            $this->roles[$key] = $this->getRolesList($key);
            $this->roles[$key][] = $key;
        }
    }

    /**
     * Méthode qui renvoie une liste des niveaux d'accès pour un rôle donné
     * Fonction récursive qui va chercher tous les sous-accès jusqu'à trouver un accès vide, signifiant
     * que l'on est au plus bas niveau
     *
     * @param $role_name Le rôle dont on souhaite connaître les accès
     * @return array La liste des accès
     */
    private function getRolesList($roleName)
    {
        // Si le rôle n'a pas de sous rôle (cas ANONYMOUS par exemple)
        if (empty($this->rolesFromXml[$roleName])) {
            return array();
        }

        // Initialisation de la liste des rôles pour un rôle donné (paramètre)
        $list = array();

        // Pour chaque sous-rôle du rôle passé en paramètre
        foreach ($this->rolesFromXml[$roleName] as $role) {
            $tmp = array();

            // Si le rôle n'est pas déjà dans la liste, on l'ajout
            if (!in_array($role, $list)) {
                $tmp[] = $role;
            }

            // Récursion : On fusionne le rôle actuel avec tous les sous-rôles
            $tmp = array_merge($tmp, $this->getRolesList($role));

            // On fusionne les listes de rôles
            $list = array_merge($list, $tmp);
        }
        
        return $list;
    }
    
    /**
     * Méthode publique qui permet de récupérer la liste des accès pour un rôle spécifique
     *
     * @param $name Le nom du rôle pour lequel on veut récupérer la liste d'accès
     * @return mixed La liste des accès pour le rôle, ou un tableau vide si le rôle n'existe pas
     */
    public function getRoles($name)
    {
        return isset($this->roles[$name]) ? $this->roles[$name] : array();
    }
}
