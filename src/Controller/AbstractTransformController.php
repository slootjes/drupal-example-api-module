<?php

namespace Drupal\api\Controller;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\ResourceInterface;
use League\Fractal\TransformerAbstract;
use MediaMonks\RestApi\Exception\FormValidationException;
use MediaMonks\RestApi\Response\OffsetPaginatedResponse;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractTransformController
{

    /**
     * @var EntityTypeManagerInterface
     */
    private $entityTypeManager;

    /**
     * @var Manager
     */
    private $fractalManager;

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var TransformerAbstract
     */
    private $transformer;

    /**
     * @param EntityTypeManagerInterface $entityTypeManager
     * @param Manager $fractalManager
     * @param FormFactoryInterface $formFactory
     * @param TransformerAbstract $transformer
     */
    public function __construct(
        EntityTypeManagerInterface $entityTypeManager,
        Manager $fractalManager,
        FormFactoryInterface $formFactory,
        TransformerAbstract $transformer
    ) {
        $this->entityTypeManager = $entityTypeManager;
        $this->fractalManager = $fractalManager;
        $this->formFactory = $formFactory;
        $this->transformer = $transformer;
    }

    /**
     * @param Request $request
     * @param string $type
     *
     * @return OffsetPaginatedResponse
     */
    protected function getPaginatedResponse(
        Request $request,
        string $type
    ): OffsetPaginatedResponse {
        $offset = $request->query->getInt('offset');
        $limit = $request->query->getInt('limit', 25);

        $nodeStorage = $this->getNodeStorage();

        $query = $nodeStorage->getQuery()
            ->condition('type', $type)
            ->sort('created', 'DESC');

        $countQuery = clone $query;
        $count = (int)$countQuery->count()->execute();

        $ids = $query->range($offset, $limit)->execute();

        return new OffsetPaginatedResponse(
            $this->transformCollection($nodeStorage->loadMultiple($ids)),
            $offset,
            $limit,
            $count
        );
    }

    /**
     * @return EntityStorageInterface
     */
    protected function getNodeStorage()
    {
        return $this->entityTypeManager->getStorage('node');
    }

    /**
     * @param ContentEntityInterface $entity
     *
     * @return array
     */
    protected function transformSingle(ContentEntityInterface $entity): array
    {
        return $this->transformResource(new Item($entity, $this->transformer));
    }

    /**
     * @param array $entities
     *
     * @return array
     */
    protected function transformCollection(array $entities): array
    {
        return $this->transformResource(
            new Collection($entities, $this->transformer)
        );
    }

    /**
     * @param ResourceInterface $resource
     *
     * @return array
     */
    protected function transformResource(ResourceInterface $resource): array
    {
        return $this->fractalManager->createData($resource)->toArray();
    }

    /**
     * @param Request $request
     * @param string $formType
     * @param string $nodeType
     *
     * @return Response
     * @throws FormValidationException
     */
    protected function handleForm(Request $request, string $formType, string $nodeType): Response
    {
        $form = $this->formFactory->create($formType);
        $form->submit($request->request->all());
        if (!$form->isValid()) {
            throw new FormValidationException($form);
        }

        $node = $this->getNodeStorage()->create(
            $form->getData() + ['type' => $nodeType]
        );
        $node->save();

        return new Response($node->id(), Response::HTTP_CREATED);
    }
}
