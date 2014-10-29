<?php
/**
 * Created by PhpStorm.
 * User: Pavel Batanov <pavel@batanov.me>
 * Date: 19.06.2014
 * Time: 16:37
 */

namespace ScayTrase\Forms\ExtensionsBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ChoiceGroupType extends AbstractType
{
    /**
     * {@inheritDoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['choice_groups'] = $options['choice_groups'];
        $view->vars['choices'] = $options['choices'];
        $view->vars['enable_hider'] = $options['enable_hider'];
        $view->vars['hider_group'] = $options['hider_group'];
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setOptional(array('enable_hider', 'hider_group'))
            ->setDefaults(array('enable_hider' => false, 'hider_group' => ''))
            ->setRequired(array('choice_groups'));
    }


    public function getParent()
    {
        return 'choice';
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'choice_group';
    }
}
