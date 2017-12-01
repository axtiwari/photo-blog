<?php

namespace Api\V1\Http\Controllers;

use Api\V1\Http\Requests\PaginatedRequest;
use Api\V1\Http\Resources\PaginatedResource;
use Api\V1\Http\Resources\TagPlainResource;
use App\Managers\Tag\Contracts\TagManager;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

/**
 * Class TagsController.
 *
 * @package Api\V1\Http\Controllers
 */
class TagsController extends Controller
{
    /**
     * @var ResponseFactory
     */
    private $responseFactory;

    /**
     * @var TagManager
     */
    private $tagManager;

    /**
     * TagsController constructor.
     *
     * @param ResponseFactory $responseFactory
     * @param TagManager $tagManager
     */
    public function __construct(ResponseFactory $responseFactory, TagManager $tagManager)
    {
        $this->responseFactory = $responseFactory;
        $this->tagManager = $tagManager;
    }

    /**
     * @apiVersion 1.0.0
     * @api {get} /v1/tags?page=:page&per_page=:per_page Find
     * @apiName Find
     * @apiGroup Tags
     * @apiHeader {String} Accept application/json
     * @apiParam {Integer{1..N}} [page=1]
     * @apiParam {Integer{1..100}} [per_page=20]
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     *     "total": 100,
     *     "per_page": 10,
     *     "current_page": 2,
     *     "last_page": 10,
     *     "next_page_url": "http://path/to/api/resource?page=3",
     *     "prev_page_url": "http://path/to/api/resource?page=1",
     *     "from": 10,
     *     "to": 20,
     *     "data": [
     *         {
     *             "value": "sky"
     *         }
     *     ]
     * }
     */

    /**
     * Paginate over tags.
     *
     * @param PaginatedRequest $request
     * @return JsonResponse
     */
    public function paginate(PaginatedRequest $request): JsonResponse
    {
        $paginator = $this->tagManager->paginate(
            $request->get('page', 1),
            $request->get('per_page', 20),
            $request->query()
        );

        return $this->responseFactory->json(new PaginatedResource($paginator, TagPlainResource::class), Response::HTTP_OK);
    }
}
