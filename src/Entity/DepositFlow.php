<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DepositFlowRepository")
 */
class DepositFlow
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Deposit", inversedBy="depositFlows")
     * @ORM\JoinColumn(nullable=false)
     */
    private $deposit;

    /**
     * @ORM\Column(type="smallint")
     */
    private $type_id;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $sum;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_created;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDeposit(): ?Deposit
    {
        return $this->deposit;
    }

    public function setDeposit(?Deposit $deposit): self
    {
        $this->deposit = $deposit;

        return $this;
    }

    public function getTypeId(): ?int
    {
        return $this->type_id;
    }

    public function setTypeId(int $typeId): self
    {
        $this->type_id = $typeId;

        return $this;
    }

    public function getSum()
    {
        return $this->sum;
    }

    public function setSum($sum): self
    {
        $this->sum = $sum;

        return $this;
    }

    public function getDateCreated(): ?\DateTimeInterface
    {
        return $this->date_created;
    }

    public function setDateCreated(\DateTimeInterface $date_created): self
    {
        $this->date_created = $date_created;

        return $this;
    }
}
