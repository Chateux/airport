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
 *     normalizationContext={"groups"={"model_read"}},
 *     denormalizationContext={"groups"={"model_write"}}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\ModelRepository")
 */
class Model
{
    /**
     * @var integer Model
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string reference
     * @ORM\Column(type="string", length=30)
     * @Assert\NotBlank()
     * @Groups({"model_read", "model_write"})
     */
    private $reference;

    /**
     * @var integer seat
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     * @Assert\Type("integer")
     * @Groups({"model_read", "model_write"})
     *
     */
    private $seat;

    /**
     * @var float Weight
     * @ORM\Column(type="float")
     * @Assert\NotBlank()
     * @Assert\Type("float")
     * @Groups({"model_read", "model_write"})
     */
    private $weight;

    /**
     * @var float length
     * @ORM\Column(type="float")
     * @Assert\NotBlank()
     * @Assert\Type("float")
     * @Groups({"model_read", "model_write"})
     */
    private $length;

    /**
     * @var float width
     * @ORM\Column(type="float")
     * @Assert\NotBlank()
     * @Assert\Type("float")
     * @Groups({"model_read", "model_write"})
     *
     */
    private $width;

    /**
     * @var string brand
     * @ORM\Column(type="string", length=50)
     * @Groups({"model_read", "model_write"})
     */
    private $brand;

    /**
     * @var Plane plane
     * @ORM\OneToMany(targetEntity="App\Entity\Plane", mappedBy="model")
     * @Groups({"model_read"})
     */
    private $plane;

    public function __construct()
    {
        $this->plane = new ArrayCollection();
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

    public function getSeat(): ?int
    {
        return $this->seat;
    }

    public function setSeat(int $seat): self
    {
        $this->seat = $seat;

        return $this;
    }

    public function getWeight(): ?float
    {
        return $this->weight;
    }

    public function setWeight(float $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    public function getLength(): ?float
    {
        return $this->length;
    }

    public function setLength(float $length): self
    {
        $this->length = $length;

        return $this;
    }

    public function getWidth(): ?float
    {
        return $this->width;
    }

    public function setWidth(float $width): self
    {
        $this->width = $width;

        return $this;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * @return Collection|Plane[]
     */
    public function getPlane(): Collection
    {
        return $this->plane;
    }

    public function addPlane(Plane $plane): self
    {
        if (!$this->plane->contains($plane)) {
            $this->plane[] = $plane;
            $plane->setModel($this);
        }

        return $this;
    }

    public function removePlane(Plane $plane): self
    {
        if ($this->plane->contains($plane)) {
            $this->plane->removeElement($plane);
            // set the owning side to null (unless already changed)
            if ($plane->getModel() === $this) {
                $plane->setModel(null);
            }
        }

        return $this;
    }
}
