<?php

namespace Drupal\api\Controller;

use Drupal\api\Form\Type\ArticleType;
use Drupal\api\Transformer\ArticleTransformer;
use Drupal\controller_annotations\Configuration\Method;
use Drupal\controller_annotations\Configuration\ParamConverter;
use Drupal\controller_annotations\Configuration\Route;
use Drupal\controller_annotations\Configuration\Security;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\node\Entity\Node;
use League\Fractal\Manager;
use MediaMonks\RestApi\Exception\FormValidationException;
use MediaMonks\RestApi\Response\OffsetPaginatedResponse;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("articles")
 */
final class ArticleController extends AbstractTransformController
{

    const ENTITY_TYPE = 'article';

    /**
     * @param EntityTypeManagerInterface $entityTypeManager
     * @param Manager $fractalManager
     * @param FormFactoryInterface $formFactory
     * @param ArticleTransformer $transformer
     */
    public function __construct(
        EntityTypeManagerInterface $entityTypeManager,
        Manager $fractalManager,
        FormFactoryInterface $formFactory,
        ArticleTransformer $transformer
    ) {
        parent::__construct(
            $entityTypeManager,
            $fractalManager,
            $formFactory,
            $transformer
        );
    }

    /**
     * @Route()
     * @Method("GET")
     * @Security(access=true)
     *
     * @param Request $request
     *
     * @return OffsetPaginatedResponse
     */
    public function listAction(Request $request): OffsetPaginatedResponse
    {
        return $this->getPaginatedResponse($request, self::ENTITY_TYPE);
    }

    /**
     * @Route("/{article}")
     * @Method("GET")
     * @Security(access=true)
     * @ParamConverter("article",
     *     options={"bundle": ArticleController::ENTITY_TYPE}
     * )
     *
     * @param Node $article
     *
     * @return array
     */
    public function showAction(Node $article): array
    {
        return $this->transformSingle($article);
    }

    /**
     * @Route()
     * @Method("POST")
     * @Security(access=true)
     *
     * @param Request $request
     *
     * @return Response
     * @throws FormValidationException
     */
    public function createAction(Request $request): Response
    {
        return $this->handleForm(
            $request,
            ArticleType::class,
            self::ENTITY_TYPE
        );
    }
}
