<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DepositRepository")
 */
class Deposit
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="deposits")
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $balance;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $sum;

    /**
     * @ORM\Column(type="decimal", precision=5, scale=2)
     */
    private $percent;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Currency", inversedBy="deposits")
     * @ORM\JoinColumn(nullable=false)
     */
    private $currency;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_opened;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\DepositFlow", mappedBy="deposit")
     */
    private $depositFlows;

    public function __construct()
    {
        $this->depositFlows = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getBalance()
    {
        return $this->balance;
    }

    public function setBalance($balance): self
    {
        $this->balance = $balance;

        return $this;
    }

    public function getPercent()
    {
        return $this->percent;
    }

    public function setPercent($percent): self
    {
        $this->percent = $percent;

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

    public function getCurrency(): ?Currency
    {
        return $this->currency;
    }

    public function setCurrency(?Currency $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    public function getDateOpened(): ?\DateTimeInterface
    {
        return $this->date_opened;
    }

    public function setDateOpened(\DateTimeInterface $date_opened): self
    {
        $this->date_opened = $date_opened;

        return $this;
    }

    /**
     * @return Collection|DepositFlow[]
     */
    public function getDepositFlows(): Collection
    {
        return $this->depositFlows;
    }

    public function addDepositFlow(DepositFlow $depositFlow): self
    {
        if (!$this->depositFlows->contains($depositFlow)) {
            $this->depositFlows[] = $depositFlow;
            $depositFlow->setDeposit($this);
        }

        return $this;
    }

    public function removeDepositFlow(DepositFlow $depositFlow): self
    {
        if ($this->depositFlows->contains($depositFlow)) {
            $this->depositFlows->removeElement($depositFlow);
            // set the owning side to null (unless already changed)
            if ($depositFlow->getDeposit() === $this) {
                $depositFlow->setDeposit(null);
            }
        }

        return $this;
    }
}
