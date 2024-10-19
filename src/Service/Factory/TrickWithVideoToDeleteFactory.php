<?php

declare (strict_types=1);

namespace App\Service\Factory;

use App\Entity\Trick;
use App\FormModel\TrickFormModel;
use App\Interface\TrickFactoryInterface;
use App\Repository\TrickVideoRepository;

class TrickWithVideoToDeleteFactory implements TrickFactoryInterface
{
    public const PRIORITY = 1000;

    public function __construct(
        private readonly VideoFactory $videoFactory,
        private readonly TrickVideoRepository $trickVideoRepository,
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
        $trick = $form->getTrick();

        foreach ($form->getVideosToDelete() as $video) {
            $trick->removeTrickVideo($video);
        }

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
        if ($form->getVideosToDelete() && is_array($form->getVideosToDelete()) && count($form->getVideosToDelete()) !== 0) {
            return true;
        }

        return false;
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
