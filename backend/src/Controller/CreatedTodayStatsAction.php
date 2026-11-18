<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\ClientRepository;
use App\Repository\CompanyRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class CreatedTodayStatsAction extends AbstractController
{
    #[Route(
        '/api/dashboard/today-stats',
        name: 'api_dashboard_today_stats',
        methods: ['GET']
    )]
    public function __invoke(
        UserRepository $userRepository,
        CompanyRepository $companyRepository,
        ClientRepository $clientRepository,
    ): JsonResponse {
        return $this->json([
            'totalUsersToday' => $userRepository->countCreatedToday(),
            'totalClientsToday' => $clientRepository->countCreatedToday(),
            'totalCompaniesToday' => $companyRepository->countCreatedToday()
        ]);
    }
}
