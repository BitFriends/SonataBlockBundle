<?php

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\BlockBundle\Form\Type;

use Sonata\BlockBundle\Block\BlockServiceManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\TranslatorInterface;

class ServiceListType extends AbstractType
{

    /**
     * @var \Sonata\BlockBundle\Block\BlockServiceManagerInterface
     */
    private $manager;

    /**
     * @var \Symfony\Component\Translation\TranslatorInterface
     */
    private $translator;

    /**
     * @param \Sonata\BlockBundle\Block\BlockServiceManagerInterface $manager
     * @param \Symfony\Component\Translation\TranslatorInterface $translator
     */
    public function __construct(
        BlockServiceManagerInterface $manager,
        TranslatorInterface $translator = null
    ) {
        $this->manager    = $manager;
        $this->translator = $translator;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $manager    = $this->manager;
        $translator = $this->translator;

        $resolver->setRequired('context');

        $resolver->setDefault(
            'choices',
            function (Options $options) use ($manager, $translator) {
                $choices = array();

                $services = $manager->getServicesByContext(
                    $options['context'],
                    $options['include_containers']
                );

                foreach ($services as $code => $service) {+
                    $blockTitle = $service->getName();

                    if ($translator) {
                        $metadata = $service->getBlockMetadata();
                        $title    = $metadata->getTitle();
                        $domain   = $metadata->getDomain();

                        $blockTitle = $translator->trans(
                            $title,
                            array(),
                            $domain
                        );
                    }

                    $name = sprintf('%s - %s', $blockTitle, $code);

                    $choices[$name] = $code;
                }

                return $choices;
            }
        );
        $resolver->setDefault('include_containers', false);
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return ChoiceType::class;
    }

}
