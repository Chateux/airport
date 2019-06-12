<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 *
 *
 * *
 * DEFAULT : ['DEFAULT']
 * READ : ['DEFAULT', 'READ']
 * WRITE : ['DEFAULT', 'WRITE']
 * ADMIN : ['DEFAULT', 'READ', 'WRITE', 'ADMIN']
 *
 *
 *
 * @ApiResource(
 *     attributes={"access_control"="is_granted('ROLE_READ')"},
 *     collectionOperations={
 *         "get",
 *         "post"={"access_control"="is_granted('ROLE_READ')", "access_control_message"="Only reader can take a reservation"}
 *     },
 *     itemOperations={
 *           "get"={"access_control"="is_granted('ROLE_READ')", "access_control_message"="Only reader can see a reservation"},
 *     },
 *     normalizationContext={"groups"={"airport_read"}},
 *     denormalizationContext={"groups"={"airport_write"}}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\AirportRepository")
 */
class Airport
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     * @Assert\Type("string")
     * @Assert\NotBlank()
     * @Groups({"airport_read","airport_write"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\Type("string")
     * @Assert\NotBlank()
     * @Groups({"airport_read","airport_write"})
     */
    private $country;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Flight", mappedBy="airport")
     * @Groups({"airport_read"})
     * @ApiSubresource(maxDepth=1)
     */
    private $flightDeparture;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Flight", mappedBy="airport")
     * @Groups({"airport_read"})
     * @ApiSubresource(maxDepth=1)
     */
    private $flightDestination;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Flight", mappedBy="airportDeparture")
     * @Groups({"airport_read"})
     */
    private $flights;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Escale", mappedBy="airportDeparture")
     * @Groups({"airport_read"})
     */
    private $escales;

    public function __construct()
    {
        $this->flightDeparture = new ArrayCollection();
        $this->flightDestination = new ArrayCollection();
        $this->flights = new ArrayCollection();
        $this->escales = new ArrayCollection();
    }

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
    
    /**
     * @return Collection|Flight[]
     */
    public function getFlightDeparture(): Collection
    {
        return $this->flightDeparture;
    }

    public function addFlightDeparture(Flight $flightDeparture): self
    {
        if (!$this->flightDeparture->contains($flightDeparture)) {
            $this->flightDeparture[] = $flightDeparture;
            $flightDeparture->setAirport($this);
        }

        return $this;
    }

    public function removeFlightDeparture(Flight $flightDeparture): self
    {
        if ($this->flightDeparture->contains($flightDeparture)) {
            $this->flightDeparture->removeElement($flightDeparture);
            // set the owning side to null (unless already changed)
            if ($flightDeparture->getAirport() === $this) {
                $flightDeparture->setAirport(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Flight[]
     */
    public function getFlightDestination(): Collection
    {
        return $this->flightDestination;
    }

    public function addFlightDestination(Flight $flightDestination): self
    {
        if (!$this->flightDestination->contains($flightDestination)) {
            $this->flightDestination[] = $flightDestination;
            $flightDestination->setAirport($this);
        }

        return $this;
    }

    public function removeFlightDestination(Flight $flightDestination): self
    {
        if ($this->flightDestination->contains($flightDestination)) {
            $this->flightDestination->removeElement($flightDestination);
            // set the owning side to null (unless already changed)
            if ($flightDestination->getAirport() === $this) {
                $flightDestination->setAirport(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Flight[]
     */
    public function getFlights(): Collection
    {
        return $this->flights;
    }

    public function addFlight(Flight $flight): self
    {
        if (!$this->flights->contains($flight)) {
            $this->flights[] = $flight;
            $flight->setAirportDeparture($this);
        }

        return $this;
    }

    public function removeFlight(Flight $flight): self
    {
        if ($this->flights->contains($flight)) {
            $this->flights->removeElement($flight);
            // set the owning side to null (unless already changed)
            if ($flight->getAirportDeparture() === $this) {
                $flight->setAirportDeparture(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Escale[]
     */
    public function getEscales(): Collection
    {
        return $this->escales;
    }

    public function addEscale(Escale $escale): self
    {
        if (!$this->escales->contains($escale)) {
            $this->escales[] = $escale;
            $escale->setAirportDeparture($this);
        }

        return $this;
    }

    public function removeEscale(Escale $escale): self
    {
        if ($this->escales->contains($escale)) {
            $this->escales->removeElement($escale);
            // set the owning side to null (unless already changed)
            if ($escale->getAirportDeparture() === $this) {
                $escale->setAirportDeparture(null);
            }
        }

        return $this;
    }
}
