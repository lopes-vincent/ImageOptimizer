<?php

namespace ImageOptimizer\Controller\Admin;

use ImageOptimizer\Form\ConfigurationForm;
use ImageOptimizer\ImageOptimizer;
use Thelia\Controller\Admin\BaseAdminController;
use Symfony\Component\Routing\Annotation\Route;
use Thelia\Core\HttpFoundation\Request;
use Thelia\Core\Template\ParserContext;
use Thelia\Model\ConfigQuery;


/**
 * @Route("/admin/module/ImageOptimizer", name="configuration")
 */
class ConfigurationController extends BaseAdminController
{
    /**
     * @Route("", name="_view", methods="GET")
     */
    public function view()
    {
        return $this->render("imageOptimizer/configuration");
    }

    /**
     * @Route("/save", name="_save", methods="POST")
     */
    public function save(ParserContext $parserContext)
    {
        $form = $this->createForm(ConfigurationForm::class);
        try {
            $data = $this->validateForm($form)->getData();

            $fields = [
                ImageOptimizer::JPEG_OPTIMIZE_QUALITY_CONFIG_KEY,
                ImageOptimizer::PNG_OPTIMIZE_QUALITY_CONFIG_KEY
            ];

            foreach ($fields as $field) {
                ConfigQuery::write($field ,$data[$field]);
            }

            return $this->generateSuccessRedirect($form);
        } catch (\Exception $exception) {
            $form->setErrorMessage($exception->getMessage());

            $parserContext
                ->addForm($form)
                ->setGeneralError($exception->getMessage());

            return $this->generateErrorRedirect($form);
        }
    }
}
