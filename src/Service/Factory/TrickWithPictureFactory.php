<?php

declare (strict_types=1);

namespace App\Service\Factory;

use App\Entity\Trick;
use App\Exception\FormException;
use App\FormModel\TrickFormModel;
use App\Interface\TrickFactoryInterface;

class TrickWithPictureFactory implements TrickFactoryInterface
{
    public const PRIORITY = 800;

    public function __construct(
        private readonly PictureFactory $pictureFactory
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

        try {
            $trickPictures = $this->pictureFactory->createPictureFromList($form->getPictures());
        } catch (\Throwable $th) {
            throw new FormException($th->getMessage());
        }

        foreach ($trickPictures as $trickPicture) {
            $trick->addTrickPicture($trickPicture);
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
        if ($form->getPictures() && is_array($form->getPictures()) && count($form->getPictures()) !== 0) {
            return true;
        }
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
