<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\PostType;
use AppBundle\Entity\Post;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class PostController extends Controller {

    /**
     * @Route("/post/{id}", name="post")
     */
    public function indexAction(Request $request, $id) {

        $post = $this->getDoctrine()->getRepository('AppBundle:Post')->find($id);

        $form = $this->createForm(PostType::class, $post);
        return $this->render('post.html.twig', array(
                    'form' => $form->createView()
        ));
    }

    /**
     * @Route("/createNew", name="create_new")
     */
    public function createNewPostPageAction(Request $request) {
        $post = new Post();
//        $post->setPoster($this->getUser());
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $post->setPoster($user);
        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($post);
            $entityManager->flush();

            return $this->redirectToRoute('post', array('id'=>$post->getId()));
        }
        return $this->render('newPost.html.twig', array(
                    'form' => $form->createView()
        ));
    }

}
