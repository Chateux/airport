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
 *     normalizationContext={"groups"={"flight_read"}},
 *     denormalizationContext={"groups"={"flight_write"}}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\FlightRepository")
 */
class Flight
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
     * @Assert\Type("alnum")
     * @Groups({"flight_read","flight_write"})
     */
    private $reference;

    /**
     * @var \DateTime $depatureDate
     * @ORM\Column(type="datetime")
     * @Assert\DateTime
     * @Assert\GreaterThanOrEqual(
     *     "NOW",
     *     message="Greather than date"
     * )
     * @Groups({"flight_read", "flight_write"})
     */
    private $depatureDate;

    /**
     * @var \DateTime arrivalDate
     * @ORM\Column(type="datetime")
     * @Assert\DateTime
     * @Assert\Expression(
     *     "this.getDepartureDate() <= this.getArrivalDate()",
     *     message="Error date arrival and departure"
     * )
     * @Groups({"flight_read", "flight_write"})
     */
    private $arrivalDate;

    /**
     * @var Plane plane
     * @ORM\OneToMany(targetEntity="App\Entity\Plane", mappedBy="flight")
     * @Groups({"flight_read", "flight_write"})
     */
    private $plane;

    /**
     * @var Passenger passenger
     * @ORM\ManyToMany(targetEntity="App\Entity\Passenger", inversedBy="flights")
     * @Groups({"flight_read", "flight_write"})
     */
    private $passenger;

    /**
     * @var Escale escale
     * @ORM\ManyToMany(targetEntity="App\Entity\Escale", inversedBy="flights")
     * @Groups({"flight_read", "flight_write"})
     */
    private $escale;

    /**
     * @var CrewMember crewMember
     * @ORM\ManyToMany(targetEntity="App\Entity\Flight", inversedBy="flights")
     * @Groups({"flight_read", "flight_write"})
     *
     */
    private $crewMember;

    /**
     * @var Airport airport
     * @ORM\ManyToOne(targetEntity="App\Entity\Airport", inversedBy="flightDeparture")
     * @Groups({"flight_read"})
     */
    private $airport;

    /**
     * @var Reservation reservation
     * @ORM\OneToMany(targetEntity="App\Entity\Reservation", mappedBy="flight")
     * @Groups({"flight_read", "flight_write"})
     */
    private $reservations;

    /**
     * @var Airport AirportDeparture
     * @ORM\ManyToOne(targetEntity="App\Entity\Airport", inversedBy="flights")
     * @Groups({"flight_read", "flight_write"})
     */
    private $airportDeparture;

    /**
     * @var Airport AirportDestinaton
     * @ORM\ManyToOne(targetEntity="App\Entity\Airport", inversedBy="flights")
     * @Assert\Expression(
     *     "this.getAirportDeparture() !== this.getAirportDestination()",
     *     message="You must choose a different airport"
     * )
     * @Groups({"flight_read", "flight_write"})
     */
    private $airportDestination;

    public function __construct()
    {
        $this->plane = new ArrayCollection();
        $this->passenger = new ArrayCollection();
        $this->escale = new ArrayCollection();
        $this->crewMember = new ArrayCollection();
        $this->reservations = new ArrayCollection();
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

    public function getDepatureDate(): ?\DateTimeInterface
    {
        return $this->depatureDate;
    }

    public function setDepatureDate(\DateTimeInterface $depatureDate): self
    {
        $this->depatureDate = $depatureDate;

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
            $plane->setFlight($this);
        }

        return $this;
    }

    public function removePlane(Plane $plane): self
    {
        if ($this->plane->contains($plane)) {
            $this->plane->removeElement($plane);
            // set the owning side to null (unless already changed)
            if ($plane->getFlight() === $this) {
                $plane->setFlight(null);
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

    /**
     * @return Collection|Escale[]
     */
    public function getEscale(): Collection
    {
        return $this->escale;
    }

    public function addEscale(Escale $escale): self
    {
        if (!$this->escale->contains($escale)) {
            $this->escale[] = $escale;
        }

        return $this;
    }

    public function removeEscale(Escale $escale): self
    {
        if ($this->escale->contains($escale)) {
            $this->escale->removeElement($escale);
        }

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getCrewMember(): Collection
    {
        return $this->crewMember;
    }

    public function addCrewMember(self $crewMember): self
    {
        if (!$this->crewMember->contains($crewMember)) {
            $this->crewMember[] = $crewMember;
        }

        return $this;
    }

    public function removeCrewMember(self $crewMember): self
    {
        if ($this->crewMember->contains($crewMember)) {
            $this->crewMember->removeElement($crewMember);
        }

        return $this;
    }

    public function getAirport(): ?Airport
    {
        return $this->airport;
    }

    public function setAirport(?Airport $airport): self
    {
        $this->airport = $airport;

        return $this;
    }

    /**
     * @return Collection|Reservation[]
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations[] = $reservation;
            $reservation->setFlight($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->contains($reservation)) {
            $this->reservations->removeElement($reservation);
            // set the owning side to null (unless already changed)
            if ($reservation->getFlight() === $this) {
                $reservation->setFlight(null);
            }
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
