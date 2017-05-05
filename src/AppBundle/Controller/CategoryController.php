<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\CategoryType;
use AppBundle\Entity\Category;

class CategoryController extends Controller {

    /**
     * @Route("/categoryNew", name="category_new")
     */
    public function createNewCategoryPageAction(Request $request) {
        $category = new Category();
//        $category->setPoster($this->getUser());
//        $user = $this->container->get('security.token_storage')->getToken()->getUser();
//        $category->setPoster($user);
        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($category);
            $entityManager->flush();

            return $this->redirectToRoute('homepage');
        }
        return $this->render('category.html.twig', array(
                    'form' => $form->createView()
        ));
    }

}


