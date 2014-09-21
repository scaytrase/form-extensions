<?php
/**
 * Created by PhpStorm.
 * User: Pavel Batanov <pavel@batanov.me>
 * Date: 30.05.2014
 * Time: 18:05
 */

namespace ScayTrase\Utils\ExtraFormFieldsBundle\Form\DataTransformer;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Symfony\Component\PropertyAccess\PropertyAccessor;

class EntityToArrayViewTransformer implements DataTransformerInterface
{
    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @var string
     */
    protected $class;

    /**
     * @var string
     */
    protected $path;

    public function __construct(ObjectManager $objectManager, $class, $path)
    {
        $this->objectManager = $objectManager;
        $this->class = $class;
        $this->path = $path;
    }

    public function transform($entity)
    {

        if (null === $entity) {
            return array('id' => '', 'label' => '');
        }

        $accessor = new PropertyAccessor();


        return array('id' => $entity->getId(), 'label' => $accessor->getValue($entity, $this->path));
    }

    public function reverseTransform($id)
    {
        if (!$id) {
            return null;
        }

        $entity = $this->objectManager
            ->getRepository($this->class)
            ->find($id);

        if (null === $entity) {
            throw new TransformationFailedException();
        }

        return $entity;
    }
}