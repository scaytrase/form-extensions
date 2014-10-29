<?php
/**
 * Created by PhpStorm.
 * User: Pavel Batanov <pavel@batanov.me>
 * Date: 05.06.2014
 * Time: 17:03
 */

namespace ScayTrase\Forms\ExtensionsBundle\Form\Type;


use Doctrine\Common\Persistence\ObjectManager;
use ScayTrase\Forms\ExtensionsBundle\Form\DataTransformer\EntityToArrayViewTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EntityAutocompleteType extends AbstractType
{
    /**
     * @var ObjectManager
     */
    protected $objectManager;

    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $transformer = new EntityToArrayViewTransformer(
            $this->objectManager,
            $options['class'],
            $options['visible_property_path']
        );
        $builder->addViewTransformer($transformer);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setRequired(array('class', 'action', 'visible_property_path'))
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
        return 'entity_autocomplete';
    }
}
