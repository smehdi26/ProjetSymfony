<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?bool $validation = null;

    /**
     * @var Collection<int, Market>
     */
    #[ORM\OneToMany(targetEntity: Market::class, mappedBy: 'client')]
    private Collection $cientm;

    public function __construct()
    {
        $this->cientm = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function isValidation(): ?bool
    {
        return $this->validation;
    }

    public function setValidation(bool $validation): static
    {
        $this->validation = $validation;

        return $this;
    }

    /**
     * @return Collection<int, Market>
     */
    public function getCientm(): Collection
    {
        return $this->cientm;
    }

    public function addCientm(Market $cientm): static
    {
        if (!$this->cientm->contains($cientm)) {
            $this->cientm->add($cientm);
            $cientm->setClient($this);
        }

        return $this;
    }

    public function removeCientm(Market $cientm): static
    {
        if ($this->cientm->removeElement($cientm)) {
            // set the owning side to null (unless already changed)
            if ($cientm->getClient() === $this) {
                $cientm->setClient(null);
            }
        }

        return $this;
    }
}
