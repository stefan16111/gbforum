<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\TopicType;
use AppBundle\Entity\Topic;

class TopicController extends Controller {

    /**
     * @Route("/topicNew", name="topic_new")
     */
    public function createNewTopicAction(Request $request) {
        $topic = new Topic();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $topic->setPoster($user);
        $form = $this->createForm(TopicType::class, $topic);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($topic);
            $entityManager->flush();

            return $this->redirectToRoute('homepage');
        }
        return $this->render('newPost.html.twig', array(
                    'form' => $form->createView()
        ));
    }
    
    /**
     * @Route("/showAllTopicFromCat/{id}", name="allTopicCategory")
     */
    public function showAllTopicFromCategoryAction(Request $request, $id)
    {
        $allTopic = $this->getDoctrine()->getRepository('AppBundle:Topic')->findOneBy(array('category' => $id));
        
        return $this->render('topic.html.twig',
                array('topics' => $allTopic)
        );
    }

}


