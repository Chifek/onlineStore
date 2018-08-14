<?php

namespace AppBundle\Controller;

use AppBundle\Entity\News;
use AppBundle\Entity\Category;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Product;
use AppBundle\Entity\ProductCategory;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Category::class);
        $categories = $repository->findAll();

        $getNews = $this->getDoctrine()->getRepository(News::class);
        $news = $getNews->findAll();

        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')) . DIRECTORY_SEPARATOR,
            'categories' => $categories,
            'news' => $news
        ]);
    }

    /**
     * @Route("/senddata", name="senddata")
     */
    public function sendData(Request $request)
    {
        $image = $request->files->get('img');
        if ($image !== null) $imageName = date("Ymdis") . $image->getClientOriginalName();
        if (($image instanceof UploadedFile) && ($image->getError() === 0)) {
            $image->move($this->getParameter('product_img_directory'), $imageName);
        }
        $requestAll = $request->request->all();
        $em = $this->getDoctrine()->getManager();
        $product = new Product();
        $product->setName($requestAll['title']);
        $product->setPrice($requestAll['price']);
        if ($image !== null) {
            $product->setImage($imageName);
            $product->setType($image->getClientMimeType());
        }
        if ($requestAll['discount'] === "") {
            $product->setDiscount($requestAll['discount'] = 0);
        } else {
            $product->setDiscount($requestAll['discount']);
        }
        $product->setBrand($requestAll['brandId']);
        $product->setDescription($requestAll['description']);

        $em->persist($product);
        $em->flush();
        $product->getId();

        if (isset($requestAll['category']) === true) {
            for ($i = 0; $i < count($requestAll['category']); $i++) {
                $em = $this->getDoctrine()->getManager();
                $productCategory = new ProductCategory();
                $productCategory->setCategoryId($requestAll['category'][$i]);
                $productCategory->setProductId($product->getId());
                $em->persist($productCategory);
                $em->flush();
            }
        }

        return $this->redirectToRoute('adminMainPage');
    }

    /**
     * @Route("/search", name="search")
     * @Method({"GET"})
     */
    public function searchProduct(Request $request)
    {
        $finder = $this->get('fos_elastica.finder.app.product');
        $query = $request->query->get('search');
        $resultSearch = $finder->find($query, null, ['search_type' => 'dfs_query_then_fetch']); //?????????? OPTIONS

        $repository = $this->getDoctrine()->getRepository(Category::class);
        $categories = $repository->findAll();

        return $this->render('search/search.html.twig', [
            'categories' => $categories,
            'result' => $resultSearch
        ]);
    }
}
