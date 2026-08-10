<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Controller\UserCreateAction;
use App\Repository\UserRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ApiResource(
    operations: [
        new Get(),
        new Post(
            uriTemplate: '/users/createUser',
            controller: UserCreateAction::class,
            validate: false,
            name: 'createUser'
        ),
        new GetCollection(),
        new Put(),
        new Delete(),

    ],
    normalizationContext: ['groups' => ['user:read']],
    denormalizationContext: ['groups' => ['user:write']]
)]
#[ApiFilter(SearchFilter::class, properties: [
    'id' => 'exact',
    'email' => 'partial',
    'phone' => 'start'
])]
#[ApiFilter(OrderFilter::class, properties: [ 'id'])]
#[ApiFilter(DateFilter::class, properties: ['lastActivityAt'])]

class User implements PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(min: 2, minMessage:'Field should be at least 2 characters')]
    #[Assert\NotBlank(message: 'This field should not be blank')]
    #[Groups(['user:read', 'user:write'])]
    private ?string $familyName = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(min:2, minMessage: 'Field should be at least 2 characters')]
    #[Assert\NotBlank(message:'This field should not be blank')]
    #[Groups(['user:read','user:write'])]
    private ?string $givenName = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(min:15, minMessage: 'Field should be at least 15 characters')]
    #[Assert\NotBlank(message:'This field should not be blank')]
    #[Groups(['user:read','user:write'])]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(min:8, minMessage: 'Field should be at least 8 characters')]
    #[Assert\NotBlank(message:'This field should not be blank')]
    #[Groups(['user:read','user:write'])]
    private ?string $password = null;

    #[ORM\Column]
    #[Groups(['user:read'])]
    private array $role = ["ROLE_USER"];

    #[ORM\Column]
    #[Groups(['user:read'])]
    private ?DateTimeImmutable $lastActivityAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFamilyName(): ?string
    {
        return $this->familyName;
    }

    public function setFamilyName(string $familyName): static
    {
        $this->familyName = $familyName;

        return $this;
    }

    public function getGivenName(): ?string
    {
        return $this->givenName;
    }

    public function setGivenName(string $givenName): static
    {
        $this->givenName = $givenName;

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

    public function getRole(): array
    {
        return $this->role;
    }

    public function setRole(array $role): static
    {
        $this->role = $role;

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
}
