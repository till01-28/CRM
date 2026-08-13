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
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Controller\CompanyCreateAction;
use App\Repository\CompanyRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CompanyRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(),
        new Post(
            uriTemplate: '/companies/createCompany',
            controller: CompanyCreateAction::class,
            validate: false,
            name: 'createCompany'
        ),
        new Get(),
        new Patch(),
        new Delete()
    ],
    normalizationContext: ['groups' => ['company:read']],
    denormalizationContext: ['groups' => ['company:write']]
)]
#[ApiFilter(SearchFilter::class, properties: [
    'id' => 'exact',
    'name' => 'partial',
    'email' => 'partial'
])]
#[ApiFilter(OrderFilter::class, properties: ['id' => 'ACS'])]
#[ApiFilter(DateFilter::class, properties: ['lastActivityAt'])]
#[UniqueEntity('email',message:'This email is already registered')]
class Company implements PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['company:read', 'client:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['company:read', 'company:write', 'client:read'])]
    #[Assert\Length(min:2, minMessage:'Field should be at least 2 characters')]
    #[Assert\NotBlank(message:'This field should not be blank')]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(['company:read', 'company:write'])]
    #[Assert\Email(message:'This email is not a valid email address')]
    #[Assert\Length(min:12, minMessage: 'Field should be at least 12 characters')]
    #[Assert\NotBlank(message:'This field should not be blank')]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    #[Groups(['company:read', 'company:write'])]
    #[Assert\Length(min:8, minMessage: 'Field should be at least 8 characters')]
    #[Assert\NotBlank(message:'This field should not be blank')]
    private ?string $password = null;

    #[ORM\Column]
    #[Groups(['company:read'])]
    private ?DateTimeImmutable $lastActivityAt = null;

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
