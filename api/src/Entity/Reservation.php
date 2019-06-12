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
 *     attributes={"access_control"="is_granted('ROLE_USER')"},
 *     collectionOperations={
 *         "get",
 *         "post"={"access_control"="is_granted('ROLE_USER')", "access_control_message"="Only user can take a reservation"}
 *     },
 *     itemOperations={
 *           "get"={"access_control"="is_granted('ROLE_USER')", "access_control_message"="Only user can see a reservation"},
 *     },
 *     normalizationContext={"groups"={"reservation_read"}},
 *     denormalizationContext={"groups"={"reservation_write"}}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\ReservationRepository")
 */
class Reservation
{
    /**
     *
     * @var Int Reservation ID
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var Passenger passager
     * @ORM\OneToOne(targetEntity="App\Entity\Passenger", cascade={"persist", "remove"})
     * @Groups({"reservation_read","reservation_write"})
     */
    private $passenger;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Flight", inversedBy="reservations")
     * @Groups({"reservation_read","reservation_write"})
     */
    private $flight;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"reservation_read","reservation_write"})
     */
    private $seat;


    public function __construct()
    {
        $this->flight = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPassenger(): ?Passenger
    {
        return $this->passenger;
    }

    public function setPassenger(?Passenger $passenger): self
    {
        $this->passenger = $passenger;

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

    public function getSeat(): ?int
    {
        return $this->seat;
    }

    public function setSeat(int $seat): self
    {
        $this->seat = $seat;

        return $this;
    }

}
