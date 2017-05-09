<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\ThreadType;
use AppBundle\Entity\Thread;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class ThreadController extends Controller {

    /**
     * @Route("/threadNew/{id}", name="thread_new")
     */
    public function createNewThreadAction(Request $request, $id) {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $thread = new Thread();
        $thread->setPoster($user);
        $topic = $this->getDoctrine()->getRepository('AppBundle:Topic')->find($id);
        $thread->setTopic($topic);
        $form = $this->createForm(ThreadType::class, $thread);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($thread);
            $entityManager->flush();

            return $this->redirectToRoute('allThreadsTopic', array('id' => $id));
        }
        return $this->render('thread.html.twig', array(
                    'form' => $form->createView()
        ));
    }

    /**
     * @Route("/showAllThreadsTopic/{id}", name="allThreadsTopic")
     * @ParamConverter("topic")
     */
    public function showAllThreadsTopicAction(Request $request, $id) {
        $allThreads = $this->getDoctrine()->getRepository('AppBundle:Thread')->findBy(array('topic' => $id));

        return $this->render('allThreads.html.twig', array(
                    'threads' => $allThreads,
            'id'=>$id
        ));
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
