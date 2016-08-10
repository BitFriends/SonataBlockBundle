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

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ContainerTemplateType.
 *
 * @author Hugo Briand <briand@ekino.com>
 */
class ContainerTemplateType extends AbstractType
{

    /**
     * @var array
     */
    private $templateChoices;

    /**
     * @param array $templateChoices
     */
    public function __construct(array $templateChoices)
    {
        $this->templateChoices = array_flip($templateChoices);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('choices', $this->templateChoices);
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return ChoiceType::class;
    }

}
