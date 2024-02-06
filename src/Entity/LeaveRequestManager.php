<?php

namespace App\Entity;

use App\Repository\LeaveRequestManagerRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LeaveRequestManagerRepository::class)]
class LeaveRequestManager
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $periodFrom = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $periodTo = null;

    #[ORM\Column(length: 255)]
    private ?string $employeeName = null;

    #[ORM\Column(length: 255)]
    private ?string $validationStatus = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $comment = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPeriodFrom(): ?\DateTimeInterface
    {
        return $this->periodFrom;
    }

    public function setPeriodFrom(\DateTimeInterface $periodFrom): static
    {
        $this->periodFrom = $periodFrom;

        return $this;
    }

    public function getPeriodTo(): ?\DateTimeInterface
    {
        return $this->periodTo;
    }

    public function setPeriodTo(\DateTimeInterface $periodTo): static
    {
        $this->periodTo = $periodTo;

        return $this;
    }

    public function getEmployeeName(): ?string
    {
        return $this->employeeName;
    }

    public function setEmployeeName(string $employeeName): static
    {
        $this->employeeName = $employeeName;

        return $this;
    }

    public function getValidationStatus(): ?string
    {
        return $this->validationStatus;
    }

    public function setValidationStatus(string $validationStatus): static
    {
        $this->validationStatus = $validationStatus;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): static
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'periodFrom' => $this->periodFrom ? $this->periodFrom->format('d-m-Y') : null,
            'periodTo' => $this->periodTo ? $this->periodTo->format('d-m-Y') : null,
            'employeeName' => $this->employeeName,
            'validationStatus' => $this->validationStatus,
            'comment' => $this->comment,
        ];
    }
}
