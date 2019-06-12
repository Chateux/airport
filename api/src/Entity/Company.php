<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ApiResource(
 *     * collectionOperations={
 *          "get",
 *          "post"={"validation_groups"={"Default", "postValidation"}}
 *     },
 *     itemOperations={
 *          "delete",
 *          "get",
 *          "put"={"validation_groups"={"Default", "putValidation"}}
 *     },
 *
 *     normalizationContext={"groups"={"company_read"}},
 *     denormalizationContext={"groups"={"company_write"}}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\CompanyRepository")
 */
class Company
{
    /**
     * @var integer id
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @Groups({"company_read","company_write"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @Groups({"company_read","company_write"})
     */
    private $country;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Plane", inversedBy="company")
     * @ApiSubresource(maxDepth=1)
     * @Groups({"company_read"})
     */
    private $plane;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getPlane(): ?Plane
    {
        return $this->plane;
    }

    public function setPlane(?Plane $plane): self
    {
        $this->plane = $plane;

        return $this;
    }
}
