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
 *      collectionOperations={
 *          "get",
 *          "post"={"validation_groups"={"Default", "postValidation"}}
 *     },
 *     itemOperations={
 *          "delete",
 *          "get",
 *          "put"={"validation_groups"={"Default", "putValidation"}}
 *     },
 *     normalizationContext={"groups"={"escale_read"}},
 *     denormalizationContext={"groups"={"escale_write"}}
 *  )
 * @ORM\Entity(repositoryClass="App\Repository\EscaleRepository")
 */
class Escale
{
    /**
     * @var integer id
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string reference
     * @ORM\Column(type="string", length=30)
     * @Assert\NotBlank()
     * @Groups({"escale_read", "escale_write"})
     */
    private $reference;

    /**
     * @var \DateTime datetime
     * @ORM\Column(type="datetime")
     * @Assert\DateTime
     * @Assert\GreaterThanOrEqual(
     *     "NOW",
     *     message="Greather than date"
     * )
     * @Groups({"escale_read", "escale_write"})
     */
    private $departureDate;

    /**
     * @var DateTime arrivalDate
     * @ORM\Column(type="datetime")
     * @Assert\DateTime
     * @Assert\Expression(
     *     "this.getDepartureDate() <= this.getArrivalDate()",
     *     message="Error date arrival and departure"
     * )
     * @Groups({"escale_read", "escale_write"})
     */
    private $arrivalDate;

    /**
     * @var Plane plane
     * @ORM\OneToMany(targetEntity="App\Entity\Plane", mappedBy="escale")
     * @Groups({"escale_read", "escale_write"})
     */
    private $plane;

    /**
     * @var Passenger passenger
     * @ORM\ManyToMany(targetEntity="App\Entity\Passenger", inversedBy="escales")
     * @Groups({"escale_read", "escale_write"})
     */
    private $passenger;

    /**
     * @var Airport airportDeparture
     * @ORM\ManyToOne(targetEntity="App\Entity\Airport", inversedBy="escales")
     * @Groups({"escale_read", "escale_write"})
     */
    private $airportDeparture;

    /**
     * @var Airport airportDestination
     * @ORM\ManyToOne(targetEntity="App\Entity\Airport", inversedBy="escales")
     * @Groups({"escale_read", "escale_write"})
     */
    private $airportDestination;

    public function __construct()
    {
        $this->plane = new ArrayCollection();
        $this->airportDeparture = new ArrayCollection();
        $this->airportDestination = new ArrayCollection();
        $this->passenger = new ArrayCollection();
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

    public function getDepartureDate(): ?\DateTimeInterface
    {
        return $this->departureDate;
    }

    public function setDepartureDate(\DateTimeInterface $departureDate): self
    {
        $this->departureDate = $departureDate;

        return $this;
    }

    public function getArrivalDate(): ?\DateTimeInterface
    {
        return $this->arrivalDate;
    }

    public function setArrivalDate(\DateTimeInterface $arrivalDate): self
    {
        $this->arrivalDate = $arrivalDate;

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
            $plane->setEscale($this);
        }

        return $this;
    }

    public function removePlane(Plane $plane): self
    {
        if ($this->plane->contains($plane)) {
            $this->plane->removeElement($plane);
            // set the owning side to null (unless already changed)
            if ($plane->getEscale() === $this) {
                $plane->setEscale(null);
            }
        }

        return $this;
    }


    /**
     * @return Collection|Passenger[]
     */
    public function getPassenger(): Collection
    {
        return $this->passenger;
    }

    public function addPassenger(Passenger $passenger): self
    {
        if (!$this->passenger->contains($passenger)) {
            $this->passenger[] = $passenger;
        }

        return $this;
    }

    public function removePassenger(Passenger $passenger): self
    {
        if ($this->passenger->contains($passenger)) {
            $this->passenger->removeElement($passenger);
        }

        return $this;
    }

    public function getAirportDeparture(): ?Airport
    {
        return $this->airportDeparture;
    }

    public function setAirportDeparture(?Airport $airportDeparture): self
    {
        $this->airportDeparture = $airportDeparture;

        return $this;
    }

    public function getAirportDestination(): ?Airport
    {
        return $this->airportDestination;
    }

    public function setAirportDestination(?Airport $airportDestination): self
    {
        $this->airportDestination = $airportDestination;

        return $this;
    }
}
