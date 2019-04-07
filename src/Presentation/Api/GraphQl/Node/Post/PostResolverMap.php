<?php

declare(strict_types=1);

/*
 * This file is part of the Explicit Architecture POC,
 * which is created on top of the Symfony Demo application.
 *
 * (c) Herberto Graça <herberto.graca@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Acme\App\Presentation\Api\GraphQl\Node\Post;

use Acme\App\Core\Component\Blog\Domain\Post\PostId;
use Acme\App\Presentation\Api\GraphQl\Node\Post\Connection\Comment\PostCommentsResolver;
use ArrayObject;
use GraphQL\Type\Definition\ResolveInfo;
use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Resolver\ResolverMap as BaseResolverMap;

final class PostResolverMap extends BaseResolverMap
{
    /**
     * @var PostCommentsResolver
     */
    private $postCommentsResolver;

    public function __construct(PostCommentsResolver $postCommentsResolver)
    {
        $this->postCommentsResolver = $postCommentsResolver;
    }

    protected function map(): array
    {
        return [
            'Post' => [
                'comments' => function (PostViewModel $value, Argument $args, ArrayObject $context, ResolveInfo $info) {
                    return $this->postCommentsResolver->getPostCommentsConnection(new PostId($value->getId()));
                },
            ],
        ];
    }
}
