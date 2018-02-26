<?php

namespace Drupal\api\Transformer;

use Drupal\node\Entity\Node;
use League\Fractal\TransformerAbstract;

final class ArticleTransformer extends TransformerAbstract
{

    /**
     * @param Node $article
     *
     * @return array
     */
    public function transform(Node $article)
    {
        return [
            'id' => (int)$article->id(),
            'title' => $article->get('title')->value,
            'body' => $article->get('body')->value,
        ];
    }
}
