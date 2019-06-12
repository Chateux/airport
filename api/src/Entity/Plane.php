<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ApiResource(
 * collectionOperations={
 *          "get",
 *          "post"={"validation_groups"={"Default", "postValidation"}}
 *     },
 *     itemOperations={
 *          "delete",
 *          "get",
 *          "put"={"validation_groups"={"Default", "putValidation"}}
 *     },
 *     normalizationContext={"groups"={"plane_read"}},
 *     denormalizationContext={"groups"={"plane_write"}}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\PlaneRepository")
 */
class Plane
{
    /**
     * @var Int Id
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string Reference
     * @ORM\Column(type="string", length=30)
     * @Assert\NotBlank()
     * @Assert\Type("alnum")
     * @Groups({"plane_read","plane_wirte", "company_read"})
     */
    private $reference;

    /**
     * @var Flight Flight
     * @ORM\ManyToOne(targetEntity="App\Entity\Flight", inversedBy="plane")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"user_read"})
     */
    private $flight;

    /**
     * @var Model model
     * @ORM\ManyToOne(targetEntity="App\Entity\Model", inversedBy="plane")
     */
    private $model;

    /**
     * @var Company Company
     * @ORM\OneToMany(targetEntity="App\Entity\Company", mappedBy="plane")
     */
    private $company;

    /**
     * @var Escale escale
     * @ORM\ManyToOne(targetEntity="App\Entity\Escale", inversedBy="plane")
     * @Groups({"plane_read"})
     */
    private $escale;

    public function __construct()
    {
        $this->company = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getFlight(): ?Flight
    {
        return $this->flight;
    }

    public function setFlight(?Flight $flight): self
    {
        $this->flight = $flight;

        return $this;
    }

    public function getModel(): ?Model
    {
        return $this->model;
    }

    public function setModel(?Model $model): self
    {
        $this->model = $model;

        return $this;
    }

    /**
     * @return Collection|Company[]
     */
    public function getCompany(): Collection
    {
        return $this->company;
    }

    public function addCompany(Company $company): self
    {
        if (!$this->company->contains($company)) {
            $this->company[] = $company;
            $company->setPlane($this);
        }

        return $this;
    }

    public function removeCompany(Company $company): self
    {
        if ($this->company->contains($company)) {
            $this->company->removeElement($company);
            // set the owning side to null (unless already changed)
            if ($company->getPlane() === $this) {
                $company->setPlane(null);
            }
        }

        return $this;
    }

    public function getEscale(): ?Escale
    {
        return $this->escale;
    }

    public function setEscale(?Escale $escale): self
    {
        $this->escale = $escale;

        return $this;
    }
}
