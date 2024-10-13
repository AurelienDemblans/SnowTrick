<?php

declare (strict_types=1);

namespace App\Service;

use App\Entity\Trick;
use Symfony\Component\Form\FormInterface;

class TrickFormProcessor
{
    public function __construct(
        private readonly TrickAddFactory $trickAddFactory,
        private readonly PictureFactory $pictureFactory,
        private readonly VideoFactory $videoFactory,
    ) {
    }

    public function __invoke(FormInterface $form): Trick
    {
        $filledTrick = $form->getData();
        $picturesList = $form->get('trickPictures')->getData();
        $videosList = $form->get('trickVideos')->getData();
        $videosListUrl = $form->get('trickVideosUrl')->getData();

        try {
            $trickPictures = $this->pictureFactory->createPictureFromList($picturesList);
            $trickVideos = $this->videoFactory->createVideoFromList($videosList, $videosListUrl);
            $trick = $this->trickAddFactory->createTrick($filledTrick, $trickPictures, $trickVideos);
        } catch (\Throwable $th) {
            throw $th;
        }

        return $trick;
    }
}
