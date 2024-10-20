<?php

declare (strict_types=1);

namespace App\Service\Form;

use App\Entity\Trick;
use App\Exception\FormException;
use App\FormModel\TrickFormModel;
use App\Interface\TrickFactoryInterface;
use App\Service\Factory\PictureFactory;
use App\Service\Factory\VideoFactory;
use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;
use Symfony\Component\Form\FormInterface;

class TrickFormProcessor
{
    /** @param iterable  $trickFactories */
    public function __construct(
        private readonly PictureFactory $pictureFactory,
        private readonly VideoFactory $videoFactory,
        private readonly TrickFormModel $formModel,
        /** @var iterable<TrickFactoryInterface> */
        #[TaggedIterator(TrickFactoryInterface::TAG_NAME, defaultPriorityMethod:'getPriority')]
        private readonly iterable $trickFactories
    ) {
    }


    public function __invoke(FormInterface $form): Trick
    {
        $formModel = $this->formModel->initAndCreate($form);

        $trick = $formModel->getTrick();

        /** @var TrickFactoryInterface */
        foreach ($this->trickFactories as $trickFactory) {
            if (!$trickFactory->support($formModel)) {
                continue;
            }

            try {
                $trick = $trickFactory->build($formModel);
            } catch (\Throwable $th) {
                throw new FormException($th->getMessage());
            }
        }

        if (!$trick || count($trick->getTrickPictures()) < 1) {
            throw new FormException('Vous devez choisir au moins une image ou une image de couverture.');
        }

        try {
            $this->pictureFactory->removePicturesFromDirectory($formModel->getPicturesToDelete());
            $this->videoFactory->removeVideosFromDirectory($formModel->getVideosToDelete());
        } catch (\Throwable $th) {
            throw new FormException($th->getMessage());
        }

        return $trick;
    }
}
