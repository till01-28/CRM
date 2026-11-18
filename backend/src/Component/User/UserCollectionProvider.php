<?php

declare(strict_types=1);

namespace App\Component\User;

use ApiPlatform\State\ProviderInterface;
use App\Entity\User;
use Symfony\Bundle\SecurityBundle\Security;
use ApiPlatform\Metadata\Operation;

readonly class UserCollectionProvider implements ProviderInterface
{
    public function __construct(
        private ProviderInterface $collectionProvider,
        private Security $security,
    ) {
    }

    public function provide(
        Operation $operation,
        array $uriVariables = [],
        array $context = []
    ): object|array|null {
        $users = $this->collectionProvider->provide(
            $operation,
            $uriVariables,
            $context
        );

        $currentUser = $this->security->getUser();
        if (is_iterable($users)) {
            $userList = iterator_to_array($users); // Doctrine malumotlarni surov konteyneri ichida qiymatlar yig'indisi
            // qilib yoki qiymatlardan iborat bulgan obyekt sifatida qaytaradi, shuni tekshirish maqsatida biz
            // is_iterable() usulidan foydalandik. Agar yig'indi bulsa unda iterator_to_array() usuli yordamida
            // standard PHP arrayga uzgartir dedik.
        } else {
            $userList = [$users]; // bo'lmasa 1 user bo'lsa ham array qovislar quyib arrayga o'zgartir dedik.
        }
        // Ro‘yxatdan otib, hozirda tizimga kirgan foydalanuvchini anonim funksiyaga saqla dedik
        $filteredUsers = array_filter($userList, function ($user) use ($currentUser) {
            if (!$user instanceof User) {
                return true;
            }

            if ($currentUser instanceof User && $currentUser->getId() === $user->getId()) {
                return false;
            }

            return true;
        });
        return array_values($filteredUsers);
    }
}
