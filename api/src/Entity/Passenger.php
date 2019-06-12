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
 * @ApiResource(
 *      collectionOperations={
 *         "get",
 *         "post"={"validation_groups"={"Default", "postValidation"}}
 *     },
 *     itemOperations={
 *         "delete",
 *         "get",
 *         "put"={"validation_groups"={"Default", "putValidation"}}
 *     },
 *     normalizationContext={"groups"={"passenger_read"}},
 *     denormalizationContext={"groups"={"passenger_write"}}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\PassengerRepository")
 */
class Passenger
{
    /**
     * @var Integer ID
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string Firstname
     * @ORM\Column(type="string", length=30)
     * @Groups({"passenger_read","passenger_write"})
     * @Assert\NotBlank
     */
    private $firstname;

    /**
     * @var string lastname
     * @ORM\Column(type="string", length=30)
     * @Groups({"passenger_read","passenger_write"})
     * @Assert\NotBlank
     */
    private $lastname;

    /**
     * @var \DateTime Date of birth
     * @ORM\Column(type="datetime")
     * @Groups({"passenger_read","passenger_write"})
     */
    private $dateBirth;

    /**
     * @var string tel number
     * @ORM\Column(type="string", length=20)
     * @Groups({"passenger_read","passenger_write"})
     * @Assert\NotBlank
     */
    private $phone;

    /**
     * @var string email
     * @ORM\Column(type="string", length=50)
     * @Groups({"passenger_read","passenger_write"})
     * @Assert\NotBlank
     * @Assert\Email(message="Your email is not valid", checkMX=true)
     */
    private $email;

    /**
     * @var Flight flight
     * @ORM\ManyToMany(targetEntity="App\Entity\Flight", mappedBy="passenger")
     * @Groups({"passenger_read"})
     */
    private $flights;

    /**
     * @var Baggage baggage
     * @ORM\OneToOne(targetEntity="App\Entity\Baggage", cascade={"persist", "remove"})
     * @Groups({"passenger_read"})
     * @ApiSubresource()
     */
    private $baggage;

    /**
     * @var Escale escale
     * @ORM\ManyToMany(targetEntity="App\Entity\Escale", mappedBy="passenger")
     * @Groups({"passenger_read"})
     */
    private $escales;

    public function __construct()
    {
        $this->flights = new ArrayCollection();
        $this->escales = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getDateBirth(): ?\DateTimeInterface
    {
        return $this->dateBirth;
    }

    public function setDateBirth(\DateTimeInterface $dateBirth): self
    {
        $this->dateBirth = $dateBirth;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

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
            $flight->addPassenger($this);
        }

        return $this;
    }

    public function removeFlight(Flight $flight): self
    {
        if ($this->flights->contains($flight)) {
            $this->flights->removeElement($flight);
            $flight->removePassenger($this);
        }

        return $this;
    }

    public function getBaggage(): ?Baggage
    {
        return $this->baggage;
    }

    public function setBaggage(?Baggage $baggage): self
    {
        $this->baggage = $baggage;

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
            $escale->addPassenger($this);
        }

        return $this;
    }

    public function removeEscale(Escale $escale): self
    {
        if ($this->escales->contains($escale)) {
            $this->escales->removeElement($escale);
            $escale->removePassenger($this);
        }

        return $this;
    }
}
