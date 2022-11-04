<?php

namespace App\Form\modele;



use App\Entity\Campus;

class  Filter
{
    private ?Campus  $campus =null;

    private ?string $recherche=null;

    private ?\DateTimeInterface $Firstdate=null;

    private  ?\DateTimeInterface $SecondDate=null;

    private ?bool $sortieOrganisateur=null;

    private ?bool $sortieInscrit=null;

    private ?bool $sortieNonInscrit=null;

    private  ?bool $sortiesPasses=null;



    /**
     * @return Campus|null
     */
    public function getCampus(): ?Campus
    {
        return $this->campus;
    }

    /**
     * @param Campus|null $campus
     * @return filter
     */
    public function setCampus(?Campus $campus): filter
    {
        $this->campus = $campus;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getRecherche(): ?string
    {
        return $this->recherche;
    }

    /**
     * @param string|null $recherche
     * @return filter
     */
    public function setRecherche(?string $recherche): filter
    {
        $this->recherche = $recherche;
        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getFirstdate(): ?\DateTimeInterface
    {
        return $this->Firstdate;
    }

    /**
     * @param \DateTimeInterface|null $Firstdate
     * @return filter
     */
    public function setFirstdate(?\DateTimeInterface $Firstdate): filter
    {
        $this->Firstdate = $Firstdate;
        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getSecondDate(): ?\DateTimeInterface
    {
        return $this->SecondDate;
    }

    /**
     * @param \DateTimeInterface|null $SecondDate
     * @return filter
     */
    public function setSecondDate(?\DateTimeInterface $SecondDate): filter
    {
        $this->SecondDate = $SecondDate;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getSortieOrganisateur(): ?bool
    {
        return $this->sortieOrganisateur;
    }

    /**
     * @param bool|null $sortieOrganisateur
     * @return filter
     */
    public function setSortieOrganisateur(?bool $sortieOrganisateur): filter
    {
        $this->sortieOrganisateur = $sortieOrganisateur;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getSortieInscrit(): ?bool
    {
        return $this->sortieInscrit;
    }

    /**
     * @param bool|null $sortieInscrit
     * @return filter
     */
    public function setSortieInscrit(?bool $sortieInscrit): filter
    {
        $this->sortieInscrit = $sortieInscrit;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getSortieNonInscrit(): ?bool
    {
        return $this->sortieNonInscrit;
    }

    /**
     * @param bool|null $sortieNonInscrit
     * @return filter
     */
    public function setSortieNonInscrit(?bool $sortieNonInscrit): filter
    {
        $this->sortieNonInscrit = $sortieNonInscrit;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getSortiesPasses(): ?bool
    {
        return $this->sortiesPasses;
    }

    /**
     * @param bool|null $sortiesPasses
     * @return filter
     */
    public function setSortiesPasses(?bool $sortiesPasses): filter
    {
        $this->sortiesPasses = $sortiesPasses;
        return $this;
    }




}