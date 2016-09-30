<?php

namespace Model;

use Core\Manager;
use Entity\Member;
use Entity\Shop\Cart;

class OrderManager extends Manager
{
    public function getOrders($id_member = null)
    {
        if ($id_member === null) {
            $filter = '';
        } else {
            $filter = 'WHERE id_member = :id';
        }
        
        $sql = "SELECT * FROM myshop_order $filter";
        
        $query = $this->db->prepare($sql);
        
        if ($filter) {
            $query->bindValue(':id', $id_member, \PDO::PARAM_INT);
        }
    
        $query->execute();
        $query->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Shop\Order');

        $orders = $query->fetchAll();

        if ($orders) {
            $gamesManager = new GameManager($this->db);

            foreach ($orders as &$order) {
                $games = $gamesManager->getGamesFromOrder($order->getId());
                foreach ($games as $game) {
                    $order->addGame($game);
                }
            }
        }
        
        return $orders;
    }
    
    public function getOrderById($idOrder)
    {
        $query = $this->db->prepare(
            "SELECT *
            FROM myshop_order
            WHERE id_order = :idOrder"
        );
        
        $query->bindValue(':idOrder', $idOrder, \PDO::PARAM_INT);
    
        $query->execute();
        $query->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Shop\Order');
        
        $order = $query->fetch();
        
        if (!$order) {
            return null;
        }
    
        $games = (new GameManager($this->db))->getGamesFromOrder($order->getId());
        foreach ($games as $game) {
            $order->addGame($game);
        }
        
        return $order;
    }

    public function save(Cart $cart, Member $member)
    {
        $query = $this->db->prepare(
            "INSERT INTO myshop_order (total, created_at, id_member)
            VALUES (:total, NOW(), :idMember)"
        );

        $query->bindValue(':total', $cart->getTotal(), \PDO::PARAM_INT);
        $query->bindValue(':idMember', $member->getId(), \PDO::PARAM_INT);

        $query->execute();

        $orderId = $this->db->lastInsertId();


        $query = $this->db->prepare(
            "INSERT INTO myshop_order_has_game (id_order, id_game, id_platform)
            VALUES (:idOrder, :idGame, :idPlatform)"
        );

        $idGame = null;
        $idPlatform = null;
        $query->bindValue(':idOrder', $orderId, \PDO::PARAM_INT);
        $query->bindParam(':idGame', $idGame, \PDO::PARAM_INT);
        $query->bindParam(':idPlatform', $idPlatform, \PDO::PARAM_INT);

        foreach ($cart->getProducts() as $game) {
            $idGame = $game->getId();
            $idPlatform = $game->getOrderedPlatform()->getId();
            $query->execute();
        }
    }
}
