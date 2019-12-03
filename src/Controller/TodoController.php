<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Tache;
use App\Form\TacheType;
use App\Repository\TacheRepository;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

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
     * @route
     */
    public function form(Request $request, EntityManagerInterface $manager)
    {
        $tache = new Tache();

        $form = $this->createForm(TacheType::class, $tache);

        $form->handleRequest($request);

        dump($tache);

        if($form->isSubmitted() && $form->isValid()){
            $tache->setCreatedAt(new \DateTime());

            $manager->persist($tache);
            $manager->flush();

            return $this->redirectToRoute('todo');
        }
        
        return $this->render('todo/create.html.twig', [
            'formTache' => $form->createView()
        ]);
    }
}
