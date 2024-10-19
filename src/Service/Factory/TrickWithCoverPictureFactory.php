<?php

declare (strict_types=1);

namespace App\Service\Factory;

use App\Entity\Trick;
use App\Exception\FormException;
use App\FormModel\TrickFormModel;
use App\Interface\TrickFactoryInterface;

class TrickWithCoverPictureFactory implements TrickFactoryInterface
{
    public const PRIORITY = 850;

    public function __construct(
        private readonly PictureFactory $pictureFactory,
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

        if ($trick->getCoverPictureOnly()) {
            $previousCover = $trick->getCoverPictureOnly();
            $previousCover->setMainPicture(false);
        }

        try {
            $coverPicture = $this->pictureFactory->createPicture($form->getCoverPicture(), true);
        } catch (\Throwable $th) {
            throw new FormException($th->getMessage());
        }

        $trick->addTrickPicture($coverPicture);

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
        if ($form->getCoverPicture()) {
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
