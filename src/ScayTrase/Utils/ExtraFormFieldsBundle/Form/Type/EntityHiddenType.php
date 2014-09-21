<?php
/**
 * Created by PhpStorm.
 * User: Pavel Batanov <pavel@batanov.me>
 * Date: 30.05.2014
 * Time: 18:06
 */

namespace ScayTrase\Utils\ExtraFormFieldsBundle\Form\Type;


use Doctrine\Common\Persistence\ObjectManager;
use ScayTrase\Utils\ExtraFormFieldsBundle\Form\DataTransformer\EntityToIdTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EntityHiddenType extends AbstractType
{
    /**
     * @var ObjectManager
     */
    protected $objectManager;

    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new EntityToIdTransformer($this->objectManager, $options['class']);
        $builder->addModelTransformer($transformer);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setRequired(array('class'))
            ->setDefaults(
                array(
                    'invalid_message' => 'The entity does not exist.',
                )
            );
    }

    public function getParent()
    {
        return 'hidden';
    }

    public function getName()
    {
        return 'entity_hidden';
    }
}