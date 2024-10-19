<?php

declare (strict_types=1);

namespace App\Service\Factory;

use App\Entity\Trick;
use App\FormModel\TrickFormModel;
use App\Interface\TrickFactoryInterface;
use App\Repository\TrickPictureRepository;
use Doctrine\ORM\EntityManagerInterface;

class TrickWithPictureToDeleteFactory implements TrickFactoryInterface
{
    public const PRIORITY = 1000;

    public function __construct(
        private readonly PictureFactory $pictureFactory,
        private readonly TrickPictureRepository $trickPictureRepository,
        private readonly EntityManagerInterface $em,
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
        dd('coucou');
        $trick = $form->getTrick();

        foreach ($form->getPicturesToDelete() as $picture) {
            $trick->removeTrickPicture($picture);
        }

        $this->em->flush();

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
        if ($form->getPicturesToDelete() && is_array($form->getPicturesToDelete()) && count($form->getPicturesToDelete()) !== 0) {
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
