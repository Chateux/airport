<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
/**
 *  @ApiResource(
 *     attributes={"access_control"="is_granted('ROLE_USER')"},
 *     collectionOperations={
 *         "get",
 *         "post"={"access_control"="is_granted('ROLE_ADMIN')", "access_control_message"="Only admins can add a member"}
 *     },
 *     itemOperations={
 *          "get"={"access_control"="is_granted('ROLE_ADMIN')", "access_control_message"="Only admins can see a member"},
 *     },
 *     normalizationContext={"groups"={"user_read"}},
 *     denormalizationContext={"groups"={"user_write"}}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="user_account")
 * @ApiFilter(OrderFilter::class, properties={"id": "ASC", "name": "DESC"})
 */
class User implements UserInterface
{
    /**
     * @var Integer Id
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var String email
     *
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups({"user_write", "user_read"})
     * @Assert\Email(checkMX=true)
     */
    private $email;

    /**
     * @var string the User Role(s)
     *
     * @ORM\Column(type="json_array", nullable=true)
     * @Groups({"user_write", "user_read"})
     * @Assert\Expression(
     *     "this.getRoles() != NULL ? this.getRoles() in ['ROLE_USER','ROLE_ADMIN','ROLE_READ', 'ROLE_WRITE', 'ROLE_DEFAULT'] : true",
     *     message="User role error"
     * )
     */
    private $roles;

    /**
     * @var string The hashed password
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Groups({"user_read"})
     */
    private $password;

    /**
     * @var string The password
     *
     * @Assert\Length(
     *     min="6"
     * )
     * @Groups({"user_write"})
     */
    private $plainPassword;

    /**
     * @var String Firstname
     *
     * @ORM\Column(type="string", length=50)
     * @Groups({"user_write", "user_read"})
     * @Assert\Type("string")
     *
     */
    private $firstname;

    /**
     * @var String LastName
     *
     * @ORM\Column(type="string", length=50)
     * @Groups({"user_write", "user_read"})
     * @Assert\Type("string")
     */
    private $lastname;


    public function getId(): ?int
    {
        return $this->id;
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
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string)$this->email;
    }

    /**
     * @return array
     */
    public function getRoles()
    {

        $roles = $this->roles;

        return $roles;
    }


    public function setRoles($roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string)$this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }

    /**
     * @return string
     */
    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    /**
     * @param string $plainPassword
     */
    public function setPlainPassword(string $plainPassword): void
    {
        $this->plainPassword = $plainPassword;
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

}
