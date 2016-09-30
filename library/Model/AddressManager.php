<?php

namespace Model;

use Core\Manager;
use Entity\Address;
use Entity\Member;

class AddressManager extends Manager
{
    public function getAddress($id)
    {
        $query = $this->db->prepare(
            "SELECT *
            FROM myshop_address
            WHERE id_address = :id"
        );

        $query->bindValue(':id', $id, \PDO::PARAM_INT);

        $query->execute();
        $query->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Address');
        
        return $query->fetch();
    }
    
    public function save(Address &$address, Member $member, $whatAddress)
    {
        $whatAddress = 'id_'.$whatAddress.'_address';

        if ($address->isNew()) {
            $query = $this->db->prepare(
                "INSERT INTO myshop_address (street, postal_code, city)
                VALUES (:street, :postalCode, :city)"
            );
            $query->bindValue(':street', $address->getStreet(), \PDO::PARAM_STR);
            $query->bindValue(':postalCode', $address->getPostalCode(), \PDO::PARAM_INT);
            $query->bindValue(':city', $address->getCity(), \PDO::PARAM_INT);
            
            $query->execute();
            
            $lastId = $this->db->lastInsertId();
    
            $query = $this->db->prepare(
                "UPDATE myshop_member
                SET $whatAddress = :idAddress
                WHERE id_member = :idMember"
            );
            $query->bindValue(':idAddress', $lastId, \PDO::PARAM_INT);
            $query->bindValue(':idMember', $member->getId(), \PDO::PARAM_INT);
    
            $query->execute();
            $address->setId($lastId);
        } else {
            $query = $this->db->prepare(
                "UPDATE myshop_address
            SET 
                street = :street, 
                postal_code = :postalCode, 
                city = :city
            WHERE id_address = :id"
            );

            $query->bindValue(':street', $address->getStreet(), \PDO::PARAM_STR);
            $query->bindValue(':postalCode', $address->getPostalCode(), \PDO::PARAM_INT);
            $query->bindValue(':city', $address->getCity(), \PDO::PARAM_STR);
            $query->bindValue(':id', $address->getId(), \PDO::PARAM_INT);

            $query->execute();
        }
    }
}
