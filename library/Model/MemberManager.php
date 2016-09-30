<?php
namespace Model;

use Entity\Member;
use Core\Manager;

/**
 * Class MemberManager
 *
 * Modélise le Manager des entités Members.
 * Permet d'intéragir avec la base de données pour échanger des informations sur les Membres
 */
class MemberManager extends Manager
{
    const PASSWORD_NOT_CONFIRMED = -1;


    public function getAll()
    {
        $query = $this->db->prepare(
            "SELECT *
            FROM myshop_member"
        );
        
        $query->execute();
        $query->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Member');

        $members = $query->fetchAll();

        foreach ($members as &$member) {
            $this->loadData($member);
        }

        return $members;
    }
    /**
     * Méthode permettant de récupérer une instance de Member en fonction d'un login, le login étant
     * soit une adresse email, soit un username
     *
     * @param $login L'email ou le username du membre à récupérer en base de données.
     *
     * @return Member Le membre correspondant au login
     */
    public function getMember($login)
    {
        $query = $this->db->prepare(
            'SELECT * 
            FROM myshop_member 
            WHERE username=:username OR email=:email'
        );
        
        $query->bindValue(':username', $login, \PDO::PARAM_STR);
        $query->bindValue(':email', $login, \PDO::PARAM_STR);
        
        $query->execute();
        $query->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Member');

        $member = $query->fetch();
    
        if (!$member) {
            return null;
        }

        $this->loadData($member);
        
        return $member;
    }

    private function loadData(Member $member)
    {
        $addrMgr = new AddressManager($this->db);
        $billingAddress = $addrMgr->getAddress($member->getIdBillingAddress());
        $mailingAddress = $addrMgr->getAddress($member->getIdMailingAddress());

        if ($billingAddress != null) {
            $member->setBillingAddress($billingAddress);
        }
        if ($mailingAddress != null) {
            $member->setMailingAddress($mailingAddress);
        }

        $orderMgr = new OrderManager($this->db);
        $orders = $orderMgr->getOrders($member->getId());

        $member->setOrders($orders);
    }
    
    /**
     * Méthode permettant de récupérer une instance de Member en fonction de l'ID
     *
     * @param $id L'id du membre à récupérer en base de données.
     *
     * @return Member Le membre correspondant à l'ID
     */
    public function getMemberById($id)
    {
        $query = $this->db->prepare('SELECT * FROM myshop_member WHERE id_member = :id');
        
        $query->bindValue(':id', $id, \PDO::PARAM_INT);
        
        $query->execute();
        $query->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Member');

        $member = $query->fetch();

        if (!$member) {
            return null;
        }

        $this->loadData($member);

        return $member;
    }
    
    /**
     * Méthode qui enregistre un membre en base de données.
     * On commence par vérifier si le membre est nouveau, car si oui on doit faire une insertion dans la base, si non, c'est une mise à jour.
     *
     * @param Member $member Le membre à enregistrer dans la base
     *
     * @return mixed
     */
    public function save(Member $member)
    {
        // Si le membre est nouveau (il n'a pas d'id)
        if ($member->isNew()) {
            // On vient du controlleur, le formulaire a été validé, on hash le password
            $pwd = password_hash($member->getPassword(), PASSWORD_BCRYPT);
            $member->setPassword($pwd);

            $query = $this->db->prepare(
                "INSERT INTO myshop_member (username, password, email, created_at)
                    VALUES (:username, :password, :email, NOW())"
            );
            
            $query->execute([
                ':username' => $member->getUsername(),
                ':password' => $member->getPassword(),
                ':email'    => $member->getEmail(),
            ]);
        } else {
            $query = $this->db->prepare(
                "UPDATE myshop_member
                SET username = :username,
                    firstname = :firstname,
                    lastname = :lastname,
                    email = :email,
                    phone = :phone
                WHERE id_member = :id"
            );
            
            $query->bindValue(':id', $member->getId(), \PDO::PARAM_INT);
            $query->bindValue(':username', $member->getUsername(), \PDO::PARAM_STR);
            $query->bindValue(':firstname', $member->getFirstname(), \PDO::PARAM_STR);
            $query->bindValue(':lastname', $member->getLastname(), \PDO::PARAM_STR);
            $query->bindValue(':email', $member->getEmail(), \PDO::PARAM_STR);
            $query->bindValue(':phone', $member->getPhone(), \PDO::PARAM_STR);
            
            $query->execute();
            
            return true;
        }
    }
    
    /**
     * Méthode qui vérifie le mot de passe d'un membre et sa confirmation.
     *
     * @param Member $member Le membre dont on doit vérifier les informations
     *
     * @return bool TRUE si le mot de passe et sa confirmation sont identiques, FALSE sinon
     */
    public function checkPasswordConfirmation(Member $member)
    {
        return $member->getPassword() === $member->getPasswordConfirm();
    }
    
    /**
     * Méthode appelée lors de la connexion d'un utilisateur, et qui met à jour sa date de dernière connexion
     *
     * @param Member $member Le membre dont on veut mettre à jour la date de dernière connexion
     */
    public function updateLastLogin(Member $member)
    {
        $query = $this->db->prepare("UPDATE myshop_member SET last_login = NOW() WHERE id_member = :id");

        $query->execute([':id' => $member->getId()]);
    }
    
    /**
     * Vérifie que le pseudo et l'email postés ne sont pas déjà pris
     *
     * @param Member $postedMember
     * @param Member $currentMember
     *
     * @return null|string
     */
    public function checkBeforeUpdate(Member $postedMember, Member $currentMember)
    {
        if ($postedMember->getUsername() != $currentMember->getUsername()) {
            $query = $this->db->prepare("SELECT * FROM myshop_member WHERE username = :username");
            $query->bindValue(':username', $postedMember->getUsername(), \PDO::PARAM_STR);
            $query->execute();
            if ($query->rowCount() > 0) {
                return 'username';
            }
        }
    
        if ($postedMember->getEmail() != $currentMember->getEmail()) {
            $query = $this->db->prepare("SELECT * FROM myshop_member WHERE email = :email");
            $query->bindValue(':email', $postedMember->getEmail(), \PDO::PARAM_STR);
            $query->execute();
            if ($query->rowCount() > 0) {
                return 'email';
            }
        }
        
        return null;
    }

    /**
     * Supprime un membre de la base de données
     *
     * @param $id
     */
    public function delete($id)
    {
        $query = $this->db->prepare("DELETE FROM myshop_member WHERE id_member = :idMember");

        $query->bindValue('idMember', $id, \PDO::PARAM_INT);
        $query->execute();
    }
}
