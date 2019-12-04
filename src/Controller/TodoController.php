<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Tache;
use App\Form\TacheType;
use App\Repository\TacheRepository;

class TodoController extends AbstractController
{
    /**
     * @Route("/todo", name="todo")
     */
    
    /* Afficher toutes les tâches */

    public function index(TacheRepository $repo)
    {
 
        $taches = $repo->findAll();
        
        return $this->render('todo/index.html.twig', [
            'controller_name' => 'TodoController',
            'taches' => $taches
        ]);
    }

    /**
     * @route("/" , name="home")
     */
    
    /* Afficher la page d'accueil */
    
     public function home()
    { 
        return $this->render('todo/home.html.twig');
    }

    /**
     * @route("/todo/new" , name="create")
     * @route("/todo/{id}/delete", name="delete")
     */

    public function form(Tache $tache = null, Request $request, EntityManagerInterface $manager)
    {
        /* Création d'une nouvelle tâche */
        if(!$tache){
            $tache = new Tache();
        
            $form = $this->createForm(TacheType::class, $tache);

            $form->handleRequest($request);


            if($form->isSubmitted() && $form->isValid()){
                $tache->setCreatedAt(new \DateTime());

                $manager->persist($tache);
                $manager->flush();

                return $this->redirectToRoute('todo');
            }
        }
        /* Si la tâche existe, possibilité de l'effacer */
        else {

            $form = $this->createForm(TacheType::class, $tache);

            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){

                $manager->remove($tache);
                $manager->flush();

                return $this->redirectToRoute('todo');
            };
        }

        return $this->render('todo/create.html.twig', [
            'formTache' => $form->createView(),
            'deleteMode' => $tache->getId() !== null
        ]);
    }

    /**
     *@route("/todo/{id}/show", name="show") 
     */

    /* Ouverture d'une tâche à modifier */
    
    public function formod(Tache $tache = null, Request $request, EntityManagerInterface $manager)
    {
        
        $formod = $this->createForm(TacheType::class, $tache);

        $formod->handleRequest($request);
        
        if($formod->isSubmitted() && $formod->isValid()){
            $tache->setCreatedAt(new \DateTime());

            $manager->persist($tache);
            $manager->flush();

            return $this->redirectToRoute('todo');
        
        }
    
        return $this->render('todo/mod.html.twig', [
            'formTache' => $formod->createView(),
            'modMode' => $tache->getId() !== null
        ]);
        
    }
}