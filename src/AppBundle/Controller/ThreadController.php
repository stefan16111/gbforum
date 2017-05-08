<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\ThreadType;
use AppBundle\Entity\Thread;

class ThreadController extends Controller {

    /**
     * @Route("/threadNew", name="thread_new")
     */
    public function createNewThreadAction(Request $request) {
        $thread = new Thread();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $thread->setPoster($user);
        $form = $this->createForm(ThreadType::class, $thread);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($thread);
            $entityManager->flush();

            return $this->redirectToRoute('homepage');
//            return $this->redirect($request->getUri());
        }
        return $this->render('new.html.twig', array(
                    'form' => $form->createView()
        ));
    }

    /**
     * @Route("/showAllThreadsTopic/{id}", name="allThreadsTopic")
     */
    public function showAllThreadsTopicAction(Request $request, $id) {
        $allTopic = $this->getDoctrine()->getRepository('AppBundle:Thread')->findBy(array('topic' => $id));

        return $this->render('allThreads.html.twig', array('topics' => $allTopic)
        );
    }

    /**
     * @Route("/showThread/{id}", name="thread")
     */
    public function showThreadAction(Request $request, $id) {
        $thread = $this->getDoctrine()->getRepository('AppBundle:Thread')->find($id);

        return $this->render('thread.html.twig', array('thread' => $thread)
        );
    }

}
