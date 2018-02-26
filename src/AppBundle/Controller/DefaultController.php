<?php

namespace AppBundle\Controller;

use AppBundle\DTO\ProductDTOCollection;
use AppBundle\Exception\ProductsApiException;
use AppBundle\Form\AddProductType;
use AppBundle\Form\SearchProductType;
use AppBundle\Query\SearchQuery;
use AppBundle\Service\ProductService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @param Request $request
     * @return Response
     */
    public function indexAction(Request $request)
    {
        try {
            $form = $this->createForm(SearchProductType::class);
            $form->handleRequest($request);

            if ($form->isSubmitted()) {
                $formData = $form->getData();

                $query = new SearchQuery(
                    $formData[SearchProductType::SEARCH_FOR_KEY],
                    $formData[SearchProductType::SORT_ORDER_KEY]
                );

                return $this->render('default/index.html.twig', [
                    'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
                    'products' => $this->getProductService()->getProducts($query),
                    'form' => $form->createView(),
                    'error' => ''
                ]);
            }

            return $this->render('default/index.html.twig', [
                'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
                'products' => $this->getProductService()->getProducts(new SearchQuery()),
                'form' => $form->createView(),
                'error' => ''
            ]);
        } catch (ProductsApiException $exception) {
            return $this->render('default/index.html.twig', [
                'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
                'products' => new ProductDTOCollection([]),
                'form' => $form->createView(),
                'error' => $exception->getMessage()
            ]);
        }
    }

    /**
     * @Route("/add", name="add_product")
     * @param Request $request
     * @return Response
     */
    public function addProduct(Request $request)
    {
        $form = $this->createForm(AddProductType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            die('todo');
        }

        return $this->render('default/addProduct.html.twig', [
            'form' => $form->createView(),
        ]);


    }

    /**
     * @return ProductService
     */
    private function getProductService() : ProductService
    {
        return $this->container->get('AppBundle\Service\ProductService');
    }
}
