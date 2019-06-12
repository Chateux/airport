<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
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
 *     normalizationContext={"groups"={"crewmember_read"}},
 *     denormalizationContext={"groups"={"crewmember_write"}}
 *  )
 * @ORM\Entity(repositoryClass="App\Repository\CrewMemberRepository")
 */
class CrewMember
{
    /**
     * @var integer ID
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var String firstname
     * @ORM\Column(type="string", length=30)
     * @Groups({"crewmember_read","crewmember_write"})
     * @Assert\NotBlank
     */
    private $firstname;

    /**
     * @var string lastname
     * @ORM\Column(type="string", length=30)
     * @Groups({"crewmember_read","crewmember_write"})
     * @Assert\NotBlank
     */
    private $lastname;

    /**
     * @var string poste
     * @ORM\Column(type="string", length=255)
     * @Groups({"crewmember_read","crewmember_write"})
     * @Assert\NotBlank
     */
    private $poste;

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

    public function getPoste(): ?string
    {
        return $this->poste;
    }

    public function setPoste(string $poste): self
    {
        $this->poste = $poste;

        return $this;
    }
}
