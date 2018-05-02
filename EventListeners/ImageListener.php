<?php
/*************************************************************************************/
/*      This file is part of the Thelia package.                                     */
/*                                                                                   */
/*      Copyright (c) OpenStudio                                                     */
/*      email : dev@thelia.net                                                       */
/*      web : http://www.thelia.net                                                  */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE.txt  */
/*      file that was distributed with this source code.                             */
/*************************************************************************************/

namespace ImageOptimizer\EventListeners;

require_once __DIR__ . '/../vendor/autoload.php';

use ImageOptimizer\OptimizerFactory;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Thelia\Core\Event\Image\ImageEvent;
use Thelia\Core\Event\TheliaEvents;

class ImageListener implements EventSubscriberInterface
{
    /**
     * @var \ImageOptimizer\Optimizer
     */
    protected $optimizer;

    public function __construct()
    {
        $factory = new OptimizerFactory(array(
            'execute_only_first_png_optimizer' => false,
            'execute_only_first_jpeg_optimizer' => false
        ));

        $this->optimizer = $factory->get();
    }

    public function optimize(ImageEvent $event, $eventName, EventDispatcherInterface $dispatcher)
    {
        if (null !== $event->getImageObject()) {
            $inputFile = $event->getCacheFilepath();

            if (file_exists($inputFile)) {
                $this->optimizer->optimize($inputFile);
            }
        }
    }

    /**
     * @inheritdoc
     */
    public static function getSubscribedEvents()
    {
        return [
            TheliaEvents::IMAGE_PROCESS => ['optimize', 1]
        ];
    }
}
