<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Controller\ClientCreateAction;
use App\Repository\ClientRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(),
        new Post(
            uriTemplate: '/clients/createClient',
            controller: ClientCreateAction::class,
            validate: false,
            name: 'createClient'
        ),
        new Get(),
        new Put(),
        new Delete(),
    ],
    normalizationContext: ['groups' => ['client:read']],
    denormalizationContext: ['groups' => ['client:write']]
)]
#[ApiFilter(SearchFilter::class, properties: [
    'id' => 'exact',
    'name' => 'partial',
    'email' => 'exact'
])]
#[ApiFilter(OrderFilter::class, properties: ['id' => 'ASC'])]
#[ApiFilter(DateFilter::class, properties: ['lastActivityAt' => 'exact'])]

class Client implements PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['client:read', 'company:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['client:read', 'client:write'])]
    #[Assert\Length(min:2, minMessage: 'Field should be at least 2 characters')]
    #[Assert\NotBlank(message:'This field should not be blank')]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(['client:read','client:write'])]
    #[Assert\Email(message:'This field should be a valid email address')]
    #[Assert\Length(min:12, minMessage: 'Field should be at least 12 characters long')]
    #[Assert\NotBlank(message:'This field should not be blank')]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    #[Groups(['client:read','client:write'])]
    #[Assert\Length(min:8, minMessage: 'Field should be at least 8 characters long')]
    #[Assert\NotBlank(message:'This field should not be blank')]
    private ?string $password = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['client:read', 'client:write'])]
    #[Assert\NotBlank(message:'This field should not be blank')]
    private ?Company $company = null;

    #[ORM\Column]
    #[Groups(['client:read'])]
    private ?DateTimeImmutable $lastActivityAt = null;

    #[ORM\ManyToOne]
    #[Groups(['client:read', 'client:write'])]
    private ?MediaObject $image = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): static
    {
        $this->company = $company;

        return $this;
    }

    public function getLastActivityAt(): ?DateTimeImmutable
    {
        return $this->lastActivityAt;
    }

    public function setLastActivityAt(DateTimeImmutable $lastActivityAt): static
    {
        $this->lastActivityAt = $lastActivityAt;

        return $this;
    }

    public function getImage(): ?MediaObject
    {
        return $this->image;
    }

    public function setImage(?MediaObject $image): static
    {
        $this->image = $image;

        return $this;
    }
}
