<?php

namespace AppBundle\Controller;

use AppBundle\Command\AddProductCommand;
use AppBundle\Command\DeleteProductCommand;
use AppBundle\Command\UpdateProductCommand;
use AppBundle\DTO\ProductDTOCollection;
use AppBundle\Exception\ProductsApiException;
use AppBundle\Form\ProductType;
use AppBundle\Form\SearchProductType;
use AppBundle\Query\GetProductQuery;
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
                'error' => $request->get('error', '')
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
    public function addProduct(Request $request) : Response
    {
        try {
            $form = $this->createForm(ProductType::class);
            $form->handleRequest($request);

            if ($form->isSubmitted()) {
                $formData = $form->getData();
                $amount = (int)$formData[ProductType::AMOUNT_KEY];
                $addProductCommand = new AddProductCommand(
                    (int)AddProductCommand::NULL_ID,
                    $formData[ProductType::NAME_KEY],
                    $amount
                );
                $this->getProductService()->addProduct($addProductCommand);

                return $this->redirect($this->generateUrl('homepage'));
            }

            return $this->render('default/addProduct.html.twig', [
                'form' => $form->createView(),
            ]);
        } catch (ProductsApiException $exception) {
            $this->redirect($this->generateUrl('homepage', ['add_error' => $exception->getMessage()]));
        } catch (\Exception $exception) {
            $this->redirect($this->generateUrl('homepage', ['add_error' => $exception->getMessage()]));
        }

        return $this->redirect($this->generateUrl('homepage'));
    }

    /**
     * @Route("/update/{id}", requirements={"/d+"}, name="update_product")
     * @param Request $request
     * @param $id
     * @return null|Response
     */
    public function updateProduct(Request $request, $id) : Response
    {
        try {
            $form = $this->createForm(ProductType::class);
            $form->handleRequest($request);

            if ($form->isSubmitted()) {
               $formData = $form->getData();
               $updateProductCommand = new UpdateProductCommand(
                   (int)$formData['id'],
                   (string)$formData['name'],
                   (int)$formData['amount']
               );
               $this->getProductService()->updateProduct($updateProductCommand);

               return $this->redirect($this->generateUrl('homepage'));
            } else {
                $productDTO = $this->getProductService()->getProduct(new GetProductQuery((int)$id));
                $form = $this->createForm(
                    ProductType::class,
                    [
                        'id' => $productDTO->getId(),
                        'name' => $productDTO->getName(),
                        'amount' => $productDTO->getAmount()
                    ]
                );

                return $this->render('default/updateProduct.html.twig', [
                    'form' => $form->createView(),
                ]);
            }
        } catch (ProductsApiException $exception) {
            return $this->redirect($this->generateUrl('homepage', ['error' => $exception->getMessage()]));
        } catch (Exception $exception) {
            return $this->redirect($this->generateUrl('homepage', ['error' => $exception->getMessage()]));
        }

        return $this->redirect($this->generateUrl('homepage'));
    }

    /**
     * @Route("/delete/{id}", requirements={"/d+"}, name="delete_product")
     * @param $id
     * @return Response
     */
    public function deleteProduct($id) : Response
    {
        try {
            $this->getProductService()->deleteProduct(new DeleteProductCommand((int)$id));

            return $this->redirect($this->generateUrl('homepage'));
        }  catch (ProductsApiException $exception) {
            return $this->redirect($this->generateUrl('homepage', ['error' => $exception->getMessage()]));
        } catch (Exception $exception) {
            return $this->redirect($this->generateUrl('homepage', ['error' => $exception->getMessage()]));
        }

        return $this->redirect($this->generateUrl('homepage'));
    }




    /**
     * @return ProductService
     */
    private function getProductService() : ProductService
    {
        return $this->container->get('AppBundle\Service\ProductService');
    }
}
