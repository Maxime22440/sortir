<?php

namespace App\Entity;

use App\Repository\SortieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SortieRepository::class)]
class Sortie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\ManyToOne(inversedBy: 'sorties')]       //cascade: ["persist"]  supprimé de cet endroit car c'est SYLVAIN qui l'a dit
    #[ORM\JoinColumn(nullable: false)]
    private ?Etat $etat = null;

    #[Assert\NotBlank(message: 'Il n\'y a pas de lieu pour la sortie. Elle a lieu dans le néant du coup je suppose?')]
    #[ORM\ManyToOne(inversedBy: 'sorties')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Lieu $lieu = null;

    #[Assert\NotBlank(message: 'Choisissez un campus associé à cette sortie. C\'est pour des raisons juridiques')]
    #[ORM\ManyToOne(inversedBy: 'sorties')]
    private ?Campus $campus = null;

    #[Assert\NotBlank(message: 'Une sortie doit avoir un nom')]
    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    //ça serait bien de pouvoir mettre des assert sur les dates malheureusement on ne sait pas comment le faire.
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateHeureDebut = null;

    #[Assert\Positive(message: 'Une sortie dure un nombre de minutes strictement positif.')]
    #[ORM\Column]
    private ?int $duree = null;


    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateLimiteInscription = null;

    #[Assert\Positive(message: 'Un nombre négatif d\'inscrits n\'a pas de sens.')]
    #[ORM\Column]
    private ?int $nbInscriptionsMax = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $infosSortie = null;


    #[ORM\ManyToOne(inversedBy: 'sortiesOrganisees')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Participant $organisateur = null;

    #[ORM\ManyToMany(targetEntity: Participant::class, mappedBy: 'sortiesParticipe')]
    #[ORM\JoinColumn(nullable: true)]
    private Collection $participantsInscrits;



    

    public function __construct()
    {
        $this->participantsInscrits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEtat(): ?Etat
    {
        return $this->etat;
    }

    public function setEtat(?Etat $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getLieu(): ?Lieu
    {
        return $this->lieu;
    }

    public function setLieu(?Lieu $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function getCampus(): ?Campus
    {
        return $this->campus;
    }

    public function setCampus(?Campus $campus): self
    {
        $this->campus = $campus;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDateHeureDebut(): ?\DateTimeInterface
    {
        return $this->dateHeureDebut;
    }

    public function setDateHeureDebut(\DateTimeInterface $dateHeureDebut): self
    {
        $this->dateHeureDebut = $dateHeureDebut;

        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(int $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getDateLimiteInscription(): ?\DateTimeInterface
    {
        return $this->dateLimiteInscription;
    }

    public function setDateLimiteInscription(\DateTimeInterface $dateLimiteInscription): self
    {
        $this->dateLimiteInscription = $dateLimiteInscription;

        return $this;
    }

    public function getNbInscriptionsMax(): ?int
    {
        return $this->nbInscriptionsMax;
    }

    public function setNbInscriptionsMax(int $nbInscriptionsMax): self
    {
        $this->nbInscriptionsMax = $nbInscriptionsMax;

        return $this;
    }

    public function getInfosSortie(): ?string
    {
        return $this->infosSortie;
    }

    public function setInfosSortie(?string $infosSortie): self
    {
        $this->infosSortie = $infosSortie;

        return $this;
    }

    public function getOrganisateur(): ?Participant
    {
        return $this->organisateur;
    }

    public function setOrganisateur(?Participant $organisateur): self
    {
        $this->organisateur = $organisateur;

        return $this;
    }

    /**
     * @return Collection<int, Participant>
     */
    public function getParticipantsInscrits(): Collection
    {
        return $this->participantsInscrits;
    }

    public function addParticipantsInscrit(Participant $participantsInscrit): self
    {
        if (!$this->participantsInscrits->contains($participantsInscrit)) {
            $this->participantsInscrits->add($participantsInscrit);
            $participantsInscrit->addSortiesParticipe($this);
        }

        return $this;
    }

    public function removeParticipantsInscrit(Participant $participantsInscrit): self
    {
        if ($this->participantsInscrits->removeElement($participantsInscrit)) {
            $participantsInscrit->removeSortiesParticipe($this);
        }

        return $this;
    }
}
