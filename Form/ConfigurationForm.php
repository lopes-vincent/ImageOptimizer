<?php

namespace ImageOptimizer\Form;

use ImageOptimizer\ImageOptimizer;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Thelia\Form\BaseForm;
use Thelia\Model\ConfigQuery;

class ConfigurationForm extends BaseForm
{
    protected function buildForm(): void
    {
        $form = $this->formBuilder;

        $form->add(ImageOptimizer::JPEG_OPTIMIZE_QUALITY_CONFIG_KEY,
            TextType::class,
            [
                'data' => ConfigQuery::read(ImageOptimizer::JPEG_OPTIMIZE_QUALITY_CONFIG_KEY, "70"),
            ]
        );

        $form->add(ImageOptimizer::PNG_OPTIMIZE_QUALITY_CONFIG_KEY,
            TextType::class,
            [
                'data' => ConfigQuery::read(ImageOptimizer::PNG_OPTIMIZE_QUALITY_CONFIG_KEY, "70-90"),
            ]
        );
    }
}
