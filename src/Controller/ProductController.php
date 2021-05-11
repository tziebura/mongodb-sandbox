<?php


namespace App\Controller;


use App\Document\Product;
use App\Model\ProductRepository;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\DependencyInjection\Tests\Compiler\J;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductController
{

    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function post(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        $product = new Product();

        $product->setTitle($data['title'] ?? 'Test product');
        $product->setDescription($data['description'] ?? 'Test description');

        $this->productRepository->save($product);

        return new JsonResponse([
            'id'          => $product->getId(),
            'title'       => $product->getTitle(),
            'description' => $product->getDescription()
        ], Response::HTTP_CREATED);
    }

    public function getList()
    {
        $items = $this->productRepository->findAll();

        $result = [];

        foreach ($items as $item) {
            $data = [
                'id'          => $item->getId(),
                'title'       => $item->getTitle(),
                'description' => $item->getDescription()
            ];

            $result[] = $data;
        }

        return new JsonResponse($result);
    }

    public function getSingle(Request $request): JsonResponse
    {
        $product = $this->productRepository->find($request->get('id'));

        if (!$product) {
            throw new NotFoundHttpException();
        }

        return new JsonResponse([
            'id'          => $product->getId(),
            'title'       => $product->getTitle(),
            'description' => $product->getDescription()
        ]);
    }

    public function delete(Request $request): JsonResponse
    {
        $product = $this->productRepository->find($request->get('id'));

        if (!$product) {
            throw new NotFoundHttpException();
        }

        $this->productRepository->remove($product);

        return new JsonResponse();
    }
}