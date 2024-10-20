<?php

declare (strict_types=1);

namespace App\Service\Factory;

use App\Entity\Trick;
use App\FormModel\TrickFormModel;
use App\Interface\TrickFactoryInterface;
use App\Repository\TrickPictureRepository;
use Doctrine\Common\Collections\ArrayCollection;

class TrickWithPictureToDeleteFactory implements TrickFactoryInterface
{
    public const PRIORITY = 1000;

    public function __construct(
        private readonly PictureFactory $pictureFactory,
        private readonly TrickPictureRepository $trickPictureRepository,
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

        foreach ($form->getPicturesToDelete() as $picture) {
            $trick->removeTrickPicture($picture);
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
        if ($form->getPicturesToDelete() && $form->getPicturesToDelete() instanceof ArrayCollection && count($form->getPicturesToDelete()) !== 0) {
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
