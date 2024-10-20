<?php

declare (strict_types=1);

namespace App\Service\Factory;

use App\Entity\Trick;
use App\Exception\FormException;
use App\FormModel\TrickFormModel;
use App\Interface\TrickFactoryInterface;

class TrickWithVideoFactory implements TrickFactoryInterface
{
    public const PRIORITY = 800;

    public function __construct(
        private readonly VideoFactory $videoFactory
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
            $trickVideos = $this->videoFactory->createVideoFromList($form->getVideos());
        } catch (\Throwable $th) {
            throw new FormException($th->getMessage());
        }

        foreach ($trickVideos as $trickVideo) {
            $trick->addTrickVideo($trickVideo);
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
        if ($form->getVideos() && is_array($form->getVideos()) && count($form->getVideos()) !== 0) {
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
