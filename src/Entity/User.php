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
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ApiResource(
    operations: [
        new GetCollection(
            security: "is_granted('ROLE_ADMIN')"
        ),
        new Get(
            security: "is_granted('ROLE_ADMIN') || object === user"
        ),
        new Post(
            uriTemplate: '/users/createUser',
            controller: UserCreateAction::class,
            validate: false,
            name: 'createUser'
        ),
        new Post(
            uriTemplate: '/users/auth',
            name: 'userAuth'
        ),
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
#[UniqueEntity('email', message: 'This email is already exist')]
class User implements PasswordAuthenticatedUserInterface, UserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['user:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(min: 2, minMessage:'Field should be at least 2 characters')]
    #[Assert\NotBlank(message: 'This field should not be blank')]
    #[Groups(['user:read', 'user:write'])]
    #[Assert\Regex(
        pattern: '/^[a-zA-Z]{2,}$/',
        message: 'Family name should contain only letters and at least 2 characters long'
    )]
    private ?string $familyName = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(min:2, minMessage: 'Field should be at least 2 characters')]
    #[Assert\NotBlank(message:'This field should not be blank')]
    #[Groups(['user:read','user:write'])]
    #[Assert\Regex(
        pattern: '/^[a-zA-Z]{2,}$/',
        message: 'Given name should contain only letters and at least 2 characters long'
    )]
    private ?string $givenName = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(min:12, minMessage: 'Field should be at least 12 characters')]
    #[Assert\NotBlank(message:'This field should not be blank')]
    #[Assert\Email(message: 'This is not a valid email address')]
    #[Groups(['user:read','user:write'])]
    #[Assert\Regex(
        pattern: '/^[^\s@]+@[^\s@]+\.[^\s@]{2,4}$/',
        message: 'Invalid email address, please provide a valid email address.'
    )]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(min:8, minMessage: 'Field should be at least 8 characters')]
    #[Assert\NotBlank(message:'This field should not be blank')]
    #[Groups(['user:read','user:write'])]
    #[Assert\Regex(
        pattern: '/(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#(){}[\]^+=._-]).{8,}$/',
        message: 'Password should contain at least one uppercase, one lowercase, one digit, one special character and
        8 characters.'
    )]
    private ?string $password = null;

    #[ORM\Column]
    #[Groups(['user:read'])]
    private array $role = ["ROLE_USER"];

    #[ORM\Column]
    #[Groups(['user:read'])]
    private ?DateTimeImmutable $lastActivityAt = null;

    #[ORM\ManyToOne]
    #[Groups(['user:read', 'user:write'])]
    private ?MediaObject $image = null;

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

    public function getRoles(): array
    {
        return ["ROLE_USER"];
    }

    public function eraseCredentials(): void
    {

    }

    public function getUserIdentifier(): string
    {
        return $this->getEmail();
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
