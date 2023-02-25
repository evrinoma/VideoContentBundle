<?php

declare(strict_types=1);

/*
 * This file is part of the package.
 *
 * (c) Nikolay Nikolaev <evrinoma@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Evrinoma\VideoContentBundle\Controller;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Evrinoma\DtoBundle\Factory\FactoryDtoInterface;
use Evrinoma\UtilsBundle\Controller\AbstractWrappedApiController;
use Evrinoma\UtilsBundle\Controller\ApiControllerInterface;
use Evrinoma\VideoContentBundle\Dto\VideoContentApiDtoInterface;
use Evrinoma\VideoContentBundle\Exception\VideoContentCannotBeSavedException;
use Evrinoma\VideoContentBundle\Exception\VideoContentInvalidException;
use Evrinoma\VideoContentBundle\Exception\VideoContentNotFoundException;
use Evrinoma\VideoContentBundle\Facade\VideoContent\FacadeInterface;
use Evrinoma\VideoContentBundle\Serializer\GroupInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use JMS\Serializer\SerializerInterface;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

final class VideoContentApiController extends AbstractWrappedApiController implements ApiControllerInterface
{
    private string $dtoClass;

    private ?Request $request;

    private FactoryDtoInterface $factoryDto;

    private FacadeInterface $facade;

    public function __construct(
        SerializerInterface $serializer,
        RequestStack $requestStack,
        FactoryDtoInterface $factoryDto,
        FacadeInterface $facade,
        string $dtoClass
    ) {
        parent::__construct($serializer);
        $this->request = $requestStack->getCurrentRequest();
        $this->factoryDto = $factoryDto;
        $this->dtoClass = $dtoClass;
        $this->facade = $facade;
    }

    /**
     * @Rest\Post("/api/video_content/create", options={"expose": true}, name="api_video_content_create")
     * @OA\Post(
     *     tags={"video_content"},
     *     description="the method perform create video_content",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 allOf={
     *                     @OA\Schema(
     *                         type="object",
     *                         @OA\Property(property="class", type="string", default="Evrinoma\VideoContentBundle\Dto\VideoContentApiDto"),
     *                         @OA\Property(property="active", type="string"),
     *                         @OA\Property(property="body", type="string"),
     *                         @OA\Property(property="title", type="string"),
     *                         @OA\Property(property="position", type="int"),
     *                         @OA\Property(property="url", type="string"),
     *                         @OA\Property(property="start", type="string"),
     *                         @OA\Property(property="video", type="string",  format="binary"),
     *                         @OA\Property(property="preview", type="string",  format="binary")
     *                     )
     *                 }
     *             )
     *         )
     *     )
     * )
     * @OA\Response(response=200, description="Create video_content")
     *
     * @return JsonResponse
     */
    public function postAction(): JsonResponse
    {
        /** @var VideoContentApiDtoInterface $videoContentApiDto */
        $videoContentApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);

        $this->setStatusCreated();

        $json = [];
        $error = [];
        $group = GroupInterface::API_POST_VIDEO_CONTENT;

        try {
            $this->facade->post($videoContentApiDto, $group, $json);
        } catch (\Exception $e) {
            $json = [];
            $error = $this->setRestStatus($e);
        }

        return $this->setSerializeGroup($group)->JsonResponse('Create video_content', $json, $error);
    }

    /**
     * @Rest\Post("/api/video_content/save", options={"expose": true}, name="api_video_content_save")
     * @OA\Post(
     *     tags={"video_content"},
     *     description="the method perform save video_content for current entity",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 allOf={
     *                     @OA\Schema(
     *                         type="object",
     *                         @OA\Property(property="class", type="string", default="Evrinoma\VideoContentBundle\Dto\VideoContentApiDto"),
     *                         @OA\Property(property="id", type="string"),
     *                         @OA\Property(property="active", type="string"),
     *                         @OA\Property(property="body", type="string"),
     *                         @OA\Property(property="title", type="string"),
     *                         @OA\Property(property="position", type="int"),
     *                         @OA\Property(property="url", type="string"),
     *                         @OA\Property(property="start", type="string"),
     *                         @OA\Property(property="video", type="string",  format="binary"),
     *                         @OA\Property(property="preview", type="string",  format="binary")
     *                     )
     *                 }
     *             )
     *         )
     *     )
     * )
     * @OA\Response(response=200, description="Save video_content")
     *
     * @return JsonResponse
     */
    public function putAction(): JsonResponse
    {
        /** @var VideoContentApiDtoInterface $videoContentApiDto */
        $videoContentApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);

        $json = [];
        $error = [];
        $group = GroupInterface::API_PUT_VIDEO_CONTENT;

        try {
            $this->facade->put($videoContentApiDto, $group, $json);
        } catch (\Exception $e) {
            $json = [];
            $error = $this->setRestStatus($e);
        }

        return $this->setSerializeGroup($group)->JsonResponse('Save video_content', $json, $error);
    }

    /**
     * @Rest\Delete("/api/video_content/delete", options={"expose": true}, name="api_video_content_delete")
     * @OA\Delete(
     *     tags={"video_content"},
     *     @OA\Parameter(
     *         description="class",
     *         in="query",
     *         name="class",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             default="Evrinoma\VideoContentBundle\Dto\VideoContentApiDto",
     *             readOnly=true
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="id Entity",
     *         in="query",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             default="3",
     *         )
     *     )
     * )
     * @OA\Response(response=200, description="Delete video_content")
     *
     * @return JsonResponse
     */
    public function deleteAction(): JsonResponse
    {
        /** @var VideoContentApiDtoInterface $videoContentApiDto */
        $videoContentApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);

        $this->setStatusAccepted();

        $json = [];
        $error = [];

        try {
            $this->facade->delete($videoContentApiDto, '', $json);
        } catch (\Exception $e) {
            $json = [];
            $error = $this->setRestStatus($e);
        }

        return $this->JsonResponse('Delete video_content', $json, $error);
    }

    /**
     * @Rest\Get("/api/video_content/criteria", options={"expose": true}, name="api_video_content_criteria")
     * @OA\Get(
     *     tags={"video_content"},
     *     @OA\Parameter(
     *         description="class",
     *         in="query",
     *         name="class",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             default="Evrinoma\VideoContentBundle\Dto\VideoContentApiDto",
     *             readOnly=true
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="id Entity",
     *         in="query",
     *         name="id",
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="active",
     *         in="query",
     *         name="active",
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="position",
     *         in="query",
     *         name="position",
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="title",
     *         in="query",
     *         name="title",
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="body",
     *         in="query",
     *         name="body",
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="start",
     *         in="query",
     *         name="start",
     *         @OA\Schema(
     *             type="date",
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="url",
     *         in="query",
     *         name="url",
     *         @OA\Schema(
     *             type="string",
     *         )
     *     )
     * )
     * @OA\Response(response=200, description="Return video_content")
     *
     * @return JsonResponse
     */
    public function criteriaAction(): JsonResponse
    {
        /** @var VideoContentApiDtoInterface $videoContentApiDto */
        $videoContentApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);

        $json = [];
        $error = [];
        $group = GroupInterface::API_CRITERIA_VIDEO_CONTENT;

        try {
            $this->facade->criteria($videoContentApiDto, $group, $json);
        } catch (\Exception $e) {
            $json = [];
            $error = $this->setRestStatus($e);
        }

        return $this->setSerializeGroup($group)->JsonResponse('Get video_content', $json, $error);
    }

    /**
     * @Rest\Get("/api/video_content", options={"expose": true}, name="api_video_content")
     * @OA\Get(
     *     tags={"video_content"},
     *     @OA\Parameter(
     *         description="class",
     *         in="query",
     *         name="class",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             default="Evrinoma\VideoContentBundle\Dto\VideoContentApiDto",
     *             readOnly=true
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="id Entity",
     *         in="query",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             default="3",
     *         )
     *     )
     * )
     * @OA\Response(response=200, description="Return video_content")
     *
     * @return JsonResponse
     */
    public function getAction(): JsonResponse
    {
        /** @var VideoContentApiDtoInterface $videoContentApiDto */
        $videoContentApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);

        $json = [];
        $error = [];
        $group = GroupInterface::API_GET_VIDEO_CONTENT;

        try {
            $this->facade->get($videoContentApiDto, $group, $json);
        } catch (\Exception $e) {
            $json = [];
            $error = $this->setRestStatus($e);
        }

        return $this->setSerializeGroup($group)->JsonResponse('Get video_content', $json, $error);
    }

    /**
     * @param \Exception $e
     *
     * @return array
     */
    public function setRestStatus(\Exception $e): array
    {
        switch (true) {
            case $e instanceof VideoContentCannotBeSavedException:
                $this->setStatusNotImplemented();
                break;
            case $e instanceof UniqueConstraintViolationException:
                $this->setStatusConflict();
                break;
            case $e instanceof VideoContentNotFoundException:
                $this->setStatusNotFound();
                break;
            case $e instanceof VideoContentInvalidException:
                $this->setStatusUnprocessableEntity();
                break;
            default:
                $this->setStatusBadRequest();
        }

        return [$e->getMessage()];
    }
}
