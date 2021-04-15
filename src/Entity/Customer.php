<?php

declare(strict_types=1);

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Index;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CustomerRepository")
 * @ORM\Table(name="customer",
 *     indexes={
 *         @Index(name="idx_customer_email", columns={"email"})
 *     }
 * )
 */
class Customer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @Groups({"customer", "list"})
     */
    private int $id;
    
    /**
     * @ORM\Column(name="gender", type="string", length=10, nullable=true)
     * @Groups({"customer"})
     */
    private ?string $gender;
    
    /**
     * @ORM\Column(name="name_title", type="string", length=10, nullable=true)
     */
    private ?string $nameTitle;
    
    /**
     * @ORM\Column(name="first_name", type="string", length=64, nullable=false)
     */
    private string $firstName;
    
    /**
     * @ORM\Column(name="last_name", type="string", length=64, nullable=false)
     */
    private string $lastName;
    
    /**
     * @ORM\Column(name="street", type="string", length=128, nullable=true)
     */
    private ?string $street;
    
    /**
     * @ORM\Column(name="city", type="string", length=128, nullable=true)
     * @Groups({"customer"})
     */
    private ?string $city;
    
    /**
     * @ORM\Column(name="state", type="string", length=128, nullable=true)
     */
    private ?string $state;
    
    /**
     * @ORM\Column(name="country", type="string", length=128, nullable=true)
     * @Groups({"customer", "list"})
     */
    private ?string $country;
    
    /**
     * @ORM\Column(name="postcode", type="bigint", nullable=true)
     */
    private ?int $postcode;
    
    /**
     * @ORM\Column(name="latitude", type="string", length=12, nullable=true)
     */
    private ?string $latitude;
    
    /**
     * @ORM\Column(name="longitude", type="string", length=12, nullable=true)
     */
    private ?string $longitude;
    
    /**
     * @ORM\Column(name="timezone_offset", type="string", length=20, nullable=true)
     */
    private ?string $timezoneOffset;

    /**
     * @ORM\Column(name="timezone_description", type="string", length=64, nullable=true)
     */
    private ?string $timezoneDescription;

    /**
     * @ORM\Column(name="email", type="string", length=256, nullable=false, unique=true)
     * @Groups({"customer", "list"})
     */
    private string $email;
    
    /**
     * @ORM\Column(name="uuid", type="string", length=36, nullable=false)
     */
    private string $uuid;
    
    /**
     * @ORM\Column(name="username", type="string", length=64, nullable=false)
     * @Groups({"customer"})
     */
    private string $username;
    
    /**
     * @ORM\Column(name="password", type="string", length=64, nullable=false)
     */
    private string $password;
    
    /**
     * @ORM\Column(name="salt", type="string", length=64, nullable=false)
     */
    private string $salt;
    
    /**
     * @ORM\Column(name="hashmd5", type="string", length=32, nullable=false)
     */
    private string $hashmd5;
    
    /**
     * @ORM\Column(name="hashsha1", type="string", length=40, nullable=false)
     */
    private string $hashsha1;
    
    /**
     * @ORM\Column(name="hashsha256", type="string", length=64, nullable=false)
     */
    private string $hashsha256;

    /**
     * @ORM\Column(name="birthday", type="datetime", nullable=true)
     */
    private ?DateTime $birthday;
    
    /**
     * @ORM\Column(name="registered", type="datetime", nullable=false)
     */
    private DateTime $registered;
    
    /**
     * @ORM\Column(name="phone", type="string", length=20, nullable=true)
     * @Groups({"customer"})
     */
    private ?string $phone;
    
    /**
     * @ORM\Column(name="cell", type="string", length=20, nullable=true)
     */
    private ?string $cell;
    
    /**
     * @ORM\Column(name="id_name", type="string", length=10, nullable=true)
     */
    private ?string $idName;
    
    /**
     * @ORM\Column(name="id_value", type="string", length=10, nullable=true)
     */
    private ?string $idValue;
    
    /**
     * @ORM\Column(name="picture_lg", type="string", length=256, nullable=true)
     */
    private ?string $pictureLg;
    
    /**
     * @ORM\Column(name="picture_med", type="string", length=256, nullable=true)
     */
    private ?string $pictureMed;
    
    /**
     * @ORM\Column(name="picture_thumb", type="string", length=256, nullable=true)
     */
    private ?string $pictureThumb;
    
    /**
     * @ORM\Column(name="nationality", type="string", length=2, nullable=true)
     */
    private ?string $nationality;
    
    /**
     * @SerializedName("fullName")
     * @Groups({"customer", "list"})
     */
    public function getFullName()
    {
        return $this->getFirstName() . ' ' . $this->getLastName();
    }
    
    public function getId(): int
    {
        return $this->id;
    }
    
    public function setId(int $id): Customer
    {
        $this->id = $id;
        return $this;
    }
    
    public function getGender(): ?string
    {
        return $this->gender;
    }
    
    public function setGender(?string $gender): Customer
    {
        $this->gender = $gender;
        return $this;
    }
    
    public function getNameTitle(): ?string
    {
        return $this->nameTitle;
    }
    
    public function setNameTitle(?string $nameTitle): Customer
    {
        $this->nameTitle = $nameTitle;
        return $this;
    }
    
    public function getFirstName(): string
    {
        return $this->firstName;
    }
    
    public function setFirstName(string $firstName): Customer
    {
        $this->firstName = $firstName;
        return $this;
    }
    
    public function getLastName(): string
    {
        return $this->lastName;
    }
    
    public function setLastName(string $lastName): Customer
    {
        $this->lastName = $lastName;
        return $this;
    }
    
    public function getStreet(): ?string
    {
        return $this->street;
    }
    
    public function setStreet(?string $street): Customer
    {
        $this->street = $street;
        return $this;
    }
    
    public function getCity(): ?string
    {
        return $this->city;
    }
    
    public function setCity(?string $city): Customer
    {
        $this->city = $city;
        return $this;
    }
    
    public function getState(): ?string
    {
        return $this->state;
    }
    
    public function setState(?string $state): Customer
    {
        $this->state = $state;
        return $this;
    }
    
    public function getCountry(): ?string
    {
        return $this->country;
    }
    
    public function setCountry(?string $country): Customer
    {
        $this->country = $country;
        return $this;
    }
    
    public function getPostcode(): ?int
    {
        return $this->postcode;
    }
    
    public function setPostcode(?int $postcode): Customer
    {
        $this->postcode = $postcode;
        return $this;
    }
    
    public function getLatitude(): ?string
    {
        return $this->latitude;
    }
    
    public function setLatitude(?string $latitude): Customer
    {
        $this->latitude = $latitude;
        return $this;
    }
    
    public function getLongitude(): ?string
    {
        return $this->longitude;
    }
    
    public function setLongitude(?string $longitude): Customer
    {
        $this->longitude = $longitude;
        return $this;
    }
    
    public function getEmail(): string
    {
        return $this->email;
    }
    
    public function setEmail(string $email): Customer
    {
        $this->email = $email;
        return $this;
    }
    
    public function getUuid(): string
    {
        return $this->uuid;
    }
    
    public function setUuid(string $uuid): Customer
    {
        $this->uuid = $uuid;
        return $this;
    }
    
    public function getUsername(): string
    {
        return $this->username;
    }
    
    public function setUsername(string $username): Customer
    {
        $this->username = $username;
        return $this;
    }
    
    public function getPassword(): string
    {
        return $this->password;
    }
    
    public function setPassword(string $password): Customer
    {
        $this->password = $password;
        return $this;
    }
    
    public function getSalt(): string
    {
        return $this->salt;
    }
    
    public function setSalt(string $salt): Customer
    {
        $this->salt = $salt;
        return $this;
    }
    
    public function getBirthday(): ?DateTime
    {
        return $this->birthday;
    }
    
    public function setBirthday(?DateTime $birthday): Customer
    {
        $this->birthday = $birthday;
        return $this;
    }
    
    public function getRegistered(): DateTime
    {
        return $this->registered;
    }
    
    public function setRegistered(DateTime $registered): Customer
    {
        $this->registered = $registered;
        return $this;
    }
    
    public function getPhone(): ?string
    {
        return $this->phone;
    }
    
    public function setPhone(?string $phone): Customer
    {
        $this->phone = $phone;
        return $this;
    }
    
    public function getCell(): ?string
    {
        return $this->cell;
    }
    
    public function setCell(?string $cell): Customer
    {
        $this->cell = $cell;
        return $this;
    }
    
    public function getIdName(): ?string
    {
        return $this->idName;
    }
    
    public function setIdName(?string $idName): Customer
    {
        $this->idName = $idName;
        return $this;
    }
    
    public function getIdValue(): ?string
    {
        return $this->idValue;
    }
    
    public function setIdValue(?string $idValue): Customer
    {
        $this->idValue = $idValue;
        return $this;
    }
    
    public function getPictureLg(): ?string
    {
        return $this->pictureLg;
    }
    
    public function setPictureLg(?string $pictureLg): Customer
    {
        $this->pictureLg = $pictureLg;
        return $this;
    }
    
    public function getPictureMed(): ?string
    {
        return $this->pictureMed;
    }
    
    public function setPictureMed(?string $pictureMed): Customer
    {
        $this->pictureMed = $pictureMed;
        return $this;
    }
    
    public function getPictureThumb(): ?string
    {
        return $this->pictureThumb;
    }
    
    public function setPictureThumb(?string $pictureThumb): Customer
    {
        $this->pictureThumb = $pictureThumb;
        return $this;
    }
    
    public function getNationality(): ?string
    {
        return $this->nationality;
    }
    
    public function setNationality(?string $nationality): Customer
    {
        $this->nationality = $nationality;
        return $this;
    }
    
    public function getTimezoneOffset(): ?string
    {
        return $this->timezoneOffset;
    }
    
    public function setTimezoneOffset(?string $timezoneOffset): Customer
    {
        $this->timezoneOffset = $timezoneOffset;
        return $this;
    }
    
    public function getTimezoneDescription(): ?string
    {
        return $this->timezoneDescription;
    }
    
    public function setTimezoneDescription(?string $timezoneDescription): Customer
    {
        $this->timezoneDescription = $timezoneDescription;
        return $this;
    }
    
    public function getHashmd5(): string
    {
        return $this->hashmd5;
    }
    
    public function setHashmd5(string $hashmd5): Customer
    {
        $this->hashmd5 = $hashmd5;
        return $this;
    }
    
    public function getHashsha1(): string
    {
        return $this->hashsha1;
    }
    
    public function setHashsha1(string $hashsha1): Customer
    {
        $this->hashsha1 = $hashsha1;
        return $this;
    }
    
    public function getHashsha256(): string
    {
        return $this->hashsha256;
    }
    
    public function setHashsha256(string $hashsha256): Customer
    {
        $this->hashsha256 = $hashsha256;
        return $this;
    }
    
    public function toArray()
    {
        return get_object_vars($this);
    }
}
