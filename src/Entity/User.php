<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface, \Serializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="id_user", type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(name="firstname", type="string", length=255, nullable=true)
     */
    private $firstname;

    /**
     * @ORM\Column(name="lastname", type="string", length=255, nullable=true)
     */
    private $lastname;

    /**
     * @ORM\Column(name="phone", type="string", length=255, nullable=true)
     */
    private $phone;

    /**
     * @ORM\Column(name="reset_password_token", type="string", length=255, nullable=true)
     */
    private $resetPasswordToken;

    /**
     * @ORM\Column(name="reset_password_token_validity_date", type="datetime", nullable=true)
     */
    private $resetPasswordTokenValidityDate;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return null|string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return User
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     * @return User
     */
    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     * @return User
     */
    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param null|string $phone
     * @return User
     */
    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return User
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getResetPasswordToken()
    {
        return $this->resetPasswordToken;
    }

    /**
     * @param mixed $resetPasswordToken
     */
    public function setResetPasswordToken($resetPasswordToken): void
    {
        $this->resetPasswordToken = $resetPasswordToken;
    }

    /**
     * @return mixed
     */
    public function getResetPasswordTokenValidityDate()
    {
        return $this->resetPasswordTokenValidityDate;
    }

    /**
     * @param mixed $resetPasswordTokenValidityDate
     */
    public function setResetPasswordTokenValidityDate($resetPasswordTokenValidityDate): void
    {
        $this->resetPasswordTokenValidityDate = $resetPasswordTokenValidityDate;
    }

    /**
     * @param $token
     * @throws \Exception
     */
    public function resetPasswordTokenProcess($token) {
        $validityDate = new \DateTime();
        $validityDate->add(new \DateInterval('PT1H'));

        $this->setResetPasswordToken($token);
        $this->setResetPasswordTokenValidityDate($validityDate);
    }

    /**
     * @return mixed|string
     */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->email,
            $this->password
        ));
    }

    /**
     * @param string $serialized
     */
    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->email,
            $this->password,
            ) = unserialize($serialized, array('allowed_classes' => false));
    }

    /**
     * @return array
     */
    public function getRoles()
    {
        return array('ROLE_ADMIN');
    }

    /**
     * @return null|string
     */
    public function getSalt()
    {
        return null;
    }

    public function eraseCredentials() {}

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->email;
    }
}
