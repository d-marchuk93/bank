<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CurrencyRepository")
 */
class Currency
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=3)
     */
    private $value;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Deposit", mappedBy="currency")
     */
    private $deposits;

    public function __construct()
    {
        $this->deposits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return Collection|Deposit[]
     */
    public function getDeposits(): Collection
    {
        return $this->deposits;
    }

    public function addDeposit(Deposit $deposit): self
    {
        if (!$this->deposits->contains($deposit)) {
            $this->deposits[] = $deposit;
            $deposit->setCurrency($this);
        }

        return $this;
    }

    public function removeDeposit(Deposit $deposit): self
    {
        if ($this->deposits->contains($deposit)) {
            $this->deposits->removeElement($deposit);
            // set the owning side to null (unless already changed)
            if ($deposit->getCurrency() === $this) {
                $deposit->setCurrency(null);
            }
        }

        return $this;
    }
}
