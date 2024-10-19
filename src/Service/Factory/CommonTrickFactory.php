<?php

declare (strict_types=1);

namespace App\Service\Factory;

use App\Entity\Trick;
use App\Exception\FormException;
use App\FormModel\TrickFormModel;
use App\Interface\TrickFactoryInterface;
use App\Repository\TrickRepository;
use App\Service\SlugGenerator;
use DateTimeImmutable;

class CommonTrickFactory implements TrickFactoryInterface
{
    public const PRIORITY = 900;

    public function __construct(
        private readonly TrickRepository $trickRepository,
    ) {
    }

    /**
     * build
     *
     * @param  TrickFormModel $form
     *
     * @return Trick
     */
    public function build(TrickFormModel $form): Trick
    {
        $slugGenerator = new SlugGenerator();

        $trick = $form->getTrick();
        $existingTrick = $this->trickRepository->findOneByName($trick->getName());

        if ($existingTrick !== null && $existingTrick->getId() !== $trick->getId()) {
            throw new FormException('impossible de créer le trick : ce nom est déjà utilisé');
        }

        if ($trick->getId() === null) {
            $trick->setCreatedAt(new DateTimeImmutable());
        } else {
            $trick->setUpdatedAt(new DateTimeImmutable());
        }

        $trick->setSlug($slugGenerator($trick->getName()));

        return $trick;
    }

    /**
     * support
     *
     * @param  TrickFormModel $form
     *
     * @return bool
     */
    public function support(TrickFormModel $form): bool
    {
        return true;
    }

    /**
     * getPriority
     *
     * @return int
     */
    public static function getPriority(): int
    {
        return self::PRIORITY;
    }
}
