<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Tache;
use App\Repository\TacheRepository;

class TodoController extends AbstractController
{
    /**
     * @Route("/todo", name="todo")
     */
    public function index(TacheRepository $repo)
    {
        //$repo = $this->getDoctrine()->getRepository(Tache::class);

        $taches = $repo->findAll();
        
        return $this->render('todo/index.html.twig', [
            'controller_name' => 'TodoController',
            'taches' => $taches
        ]);
    }

    /**
     * @route("/" , name="home")
     */
    public function home()
    {
        return $this->render('todo/home.html.twig');
    }

    /**
     * @route("/todo/new" , name="create")
     */
    public function create(Request $request, EntityManagerInterface $manager)
    {
        $tache = new Tache();

        $form = $this->createFormBuilder($tache)
                     ->add('title')
                     ->add('content')
                     ->getForm();
        
        return $this->render('todo/create.html.twig', [
            'formTache' => $form->createView()
        ]);
    }
}
