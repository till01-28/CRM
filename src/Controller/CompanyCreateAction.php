<?php

declare(strict_types=1);

namespace App\Controller;

use App\Component\Company\CompanyFactory;
use App\Component\Company\CompanyManager;
use App\Entity\Company;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CompanyCreateAction extends AbstractController
{
    public function __construct(
        private readonly CompanyFactory $companyFactory,
        private readonly CompanyManager $companyManager)
    {

    }

    /**
     * @throws \DateMalformedStringException
     */
    public function __invoke(Company $company):Company
    {
        $company = $this->companyFactory->create(
            $company->getName(),
            $company->getEmail(),
            $company->getPassword(),
        );

        $this->companyManager->save($company, true);

        return $company;
    }
}
