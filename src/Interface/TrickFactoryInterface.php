<?php

declare (strict_types=1);

namespace App\Interface;

use App\Entity\Trick;
use App\FormModel\TrickFormModel;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag(self::TAG_NAME)]
interface TrickFactoryInterface
{
    public const TAG_NAME  = 'app.factory_tag';

    public function support(TrickFormModel $form): bool;

    public function build(TrickFormModel $form): Trick;

    public static function getPriority(): int;
}
