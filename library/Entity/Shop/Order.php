<?php

namespace Entity\Shop;

use Core\ArrayCollection;
use Core\Entity;
use Entity\Member;

class Order extends Entity
{
    private $id_order;
    private $total;
    private $created_at;
    private $id_member;

    private $member;
    private $games;


    public function __construct(array $data = [])
    {
        parent::__construct($data);
        $this->games = new ArrayCollection();
    }


    public function isNew()
    {
        return empty($this->id_order);
    }

    public function addGame(Game $game)
    {
        $this->games->addElement($game);

        return $this;
    }

    public function removeGame(Game $game)
    {
        $this->games->removeElement($game);

        return $this;
    }


    public function getId()
    {
        return $this->id_order;
    }

    public function getTotal()
    {
        return $this->total;
    }

    public function getCreatedAt()
    {
        if (!$this->created_at instanceof \DateTime) {
            $this->created_at = new \DateTime($this->created_at);
        }
        
        return $this->created_at;
    }

    public function getIdMember()
    {
        return $this->id_member;
    }

    public function getMember()
    {
        return $this->member;
    }

    public function getGames()
    {
        return $this->games;
    }


    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    public function setCreatedAt(\DateTime $created_at)
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function setIdMember($id_member)
    {
        $this->id_member = $id_member;

        return $this;
    }

    public function setMember(Member $member)
    {
        $this->member = $member;

        return $this;
    }
}
