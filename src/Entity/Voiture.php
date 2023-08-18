<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[Vich\Uploadable]
#[ORM\Entity(repositoryClass:"App\Repository\VoitureRepository")]
class Voiture
{

    const MOTORISATION = [
        "Diesel" => "Diesel",
        "Essence" => "Essence",
        "Electique" => "Electique"
    ];
    const PORTE = [
        0 => "3",
        1 => "5"
    ];
    const GPS = [
        0 => "Oui",
        1 => "Non"
    ];
    const CAMERA = [
        0 => "Oui",
        1 => "Non"
    ];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id;

    /**
     * @var string|null
     */
    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private $filename;

    /**
     * @var File|null
     * @Assert\Image(
     * mimeTypes="image/jpeg"
     * )
     */
    #[Vich\UploadableField(mapping:"voiture_image", fileNameProperty:"filename")]
    private $imageFile;

    #[ORM\Column(length: 255)]
    private ?string $title;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description;

    #[ORM\Column]
    #[Assert\Range(min:1900, max:2023)]
    private ?int $annee;

    #[ORM\Column]
    #[Assert\Range(min:1, max:9999999)]
    private ?int $kilometrage;

    #[ORM\Column]
    #[Assert\Range(min:50, max:1000)]
    private ?int $chevaux;

    #[ORM\Column]
    #[Assert\Range(min:1, max:9999999)]
    private ?int $prix;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_enregistrement;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $detail = null;

    #[ORM\Column]
    #[Assert\Range(min:3, max:5)]
    private ?int $porte = null;

    #[ORM\Column(length: 255)]
    private ?string $motorisation = null;

    #[ORM\Column(length: 255)]
    private ?string $gps = null;

    #[ORM\Column(length: 255)]
    private ?string $camera = null;

    #[ORM\Column(type:"boolean")]
    private $visible = false;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $updated_at = null;

    public function __construct() {
        $this->id = null;
        $this->date_enregistrement = new \DateTime();
        $this->updated_at = new \DateTime();
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }
    public function getSlug(): string
    {
        return (new Slugify())->slugify($this->title);
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getAnnee(): ?int
    {
        return $this->annee;
    }

    public function setAnnee(int $annee): static
    {
        $this->annee = $annee;

        return $this;
    }

    public function getKilometrage(): ?int
    {
        return $this->kilometrage;
    }

    public function setKilometrage(int $kilometrage): static
    {
        $this->kilometrage = $kilometrage;

        return $this;
    }

    public function getChevaux(): ?int
    {
        return $this->chevaux;
    }

    public function setChevaux(int $chevaux): static
    {
        $this->chevaux = $chevaux;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getFormatPrix(): string
    { 
        return number_format($this->prix,0,""," ") . " €";
    }
    public function getDate_enregistrement(): ?\DateTimeInterface
    {
        return $this->date_enregistrement;
    }

    public function setDate_enregistrement(\DateTimeInterface $date_enregistrement): static
    {
        $this->date_enregistrement = $date_enregistrement;

        return $this;
    }

    public function getDetail(): ?string
    {
        return $this->detail;
    }

    public function setDetail(string $detail): static
    {
        $this->detail = $detail;

        return $this;
    }

    public function getPorte(): ?string
    {
        return $this->porte;
    }

    public function setPorte(string $porte): self
    {
        $this->porte = $porte;

        return $this;
    }

    public function getMotorisation(): ?string
    {
    return $this->motorisation;
    }

    public function setMotorisation(?string $motorisation): self
    {
    $this->motorisation = $motorisation;

    return $this;
    }

    public function getGps(): ?string
    {
        return $this->gps;
    }

    public function setGps(string $gps): self
    {
        $this->gps = $gps;

        return $this;
    }

    public function getCamera(): ?string
    {
        return $this->camera;
    }

    public function setCamera(string $camera): self
    {
        $this->camera = $camera;

        return $this;
    }
    public function isVisible(): bool
    {
        return $this->visible;
    }

    public function setVisible(bool $visible): self
    {
        $this->visible = $visible;

        return $this;
    }
    /**
     * @return null|string
     */
    public function getFilename(): ?string
    {
        return $this->filename;
    }

    /**
     * @param null|string $filename
     * @return Voiture
     */
    public function setFilename(?string $filename): Voiture
    {
        $this->filename = $filename;
        return $this;
    }
    /**
     * @return null|File
     */
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    /**
     * @param null|File $imageFile
     * @return Voiture
     */

    public function setImageFile(?File $imageFile): Voiture
    {
        $this->imageFile = $imageFile;
        if ($this->imageFile instanceof UploadedFile) {
            $this->updated_at = new \DateTime('now');
        }
        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;
        return $this;
    }
}