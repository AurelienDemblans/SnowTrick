<?php

declare (strict_types=1);

namespace App\FormModel;

use App\Entity\Trick;
use App\Repository\TrickPictureRepository;
use App\Repository\TrickVideoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class TrickFormModel
{
    private ?FormInterface $form = null;

    public function __construct(
        private readonly TrickPictureRepository $trickPictureRepository,
        private readonly TrickVideoRepository $trickVideoRepository,
    ) {
    }

    public function initAndCreate(FormInterface $form): self
    {
        $this->form = $form;

        return $this;
    }

    public function getCoverPicture(): ?UploadedFile
    {
        return $this->form->get('trickCoverPicture')->getData() ?? null;
    }
    public function getPictures(): ?array
    {
        return $this->form->get('trickPictures')->getData() ?? null;

    }
    public function getVideos(): ?array
    {
        return $this->form->get('trickVideos')->getData() ?? null;

    }
    public function getVideosUrl(): ?array
    {
        return $this->form->get('trickVideosUrl')->getData() ?? null;
    }

    public function getPicturesToDelete(): ?ArrayCollection
    {
        if ($this->form->has('pictures_id')) {
            $picturesToDelete = $this->form->get('pictures_id')?->getData() ? explode(',', $this->form->get('pictures_id')->getData()) : [];

            $pictureCollection = new ArrayCollection();
            foreach ($picturesToDelete as $pictureToDeleteId) {
                $picture = $this->trickPictureRepository->find($pictureToDeleteId);

                if ($picture !== null) {
                    $pictureCollection->add($picture);
                }
            }

            return $pictureCollection;
        } else {
            return null;
        }
    }

    public function getVideosToDelete(): ?ArrayCollection
    {
        if ($this->form->has('videos_id')) {
            $videosToDelete = $this->form->get('videos_id')?->getData() ? explode(',', $this->form->get('videos_id')->getData()) : [];

            $videoCollection = new ArrayCollection();
            foreach ($videosToDelete as $videoToDeleteId) {
                $video = $this->trickVideoRepository->find($videoToDeleteId);

                if ($video !== null) {
                    $videoCollection->add($video);
                }
            }

            return $videoCollection;
        } else {
            return null;
        }
    }

    public function getTrick(): Trick
    {
        return $this->form->getData();
    }
}
