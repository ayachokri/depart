<?php

namespace App\Entity;

use App\Repository\ClassroomRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClassroomRepository::class)]
class Classroom
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(targetEntity: etudiant::class, mappedBy: 'classroom')]
    private Collection $class;

    public function __construct()
    {
        $this->class = new ArrayCollection();
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

    /**
     * @return Collection<int, etudiant>
     */
    public function getClass(): Collection
    {
        return $this->class;
    }

    public function addClass(etudiant $class): static
    {
        if (!$this->class->contains($class)) {
            $this->class->add($class);
            $class->setClassroom($this);
        }

        return $this;
    }

    public function removeClass(etudiant $class): static
    {
        if ($this->class->removeElement($class)) {
            // set the owning side to null (unless already changed)
            if ($class->getClassroom() === $this) {
                $class->setClassroom(null);
            }
        }

        return $this;
    }
}
