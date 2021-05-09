<?php

namespace App\Controller;

use App\Entity\Agence;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AgenceController extends AbstractController
{
    // ************************************************************************ //
    // NOTE: It's better to create a service layer and use it for DRY principe. //
    // ************************************************************************ //

    /**
     * @Route("/agence/ajouter", name ="ajouter_agence", methods={"GET", "POST"})
     */
    public function ajouter (Request $request, EntityManagerInterface $entityManager) {
        // init the agence model.
        $agence = new Agence();

        // create a from through the symfony form builder. 
        $form = $this->createFormBuilder($agence)
            // fileds.
            ->add('nom', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('telAgence', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('addressVille', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('ajouter', SubmitType::class, [
                'label' => 'Ajouter une agence',
                'attr' => ['class' => 'btn btn-primary form-control mt-3']
            ])
            // form builded.
            ->getForm();
  
        // process form data.
        $form->handleRequest($request);

        // look here if we use post request (submitted).
        if($form->isSubmitted() && $form->isValid()) {
            // extract form data.
            $agence = $form->getData();

            // $entityManager through the dependency injection.

            // save it to database.
            $entityManager->persist($agence);

            // execute the query saved with the persist method.
            $entityManager->flush();

            // redirect to '/admin'.
            return $this->redirectToRoute('admin_route');
        }

      // otherwise, we use get request.
        return $this->render('pages/admin/ajouter.html.twig', [
            // needed for manage UI through twig.
            'agence' => true,
            'voiture' => false,
            // create a view from the form builder.
            'form' => $form->createView()
        ]);
    }


    // BETTER TO USE PUT OR PATCH METHOD HER. //
    /**
     * @Route("/agence/modifier/{id}", name ="modifier_agence", methods={"GET", "POST"})
     */
    public function modifier (Request $request, EntityManagerInterface $entityManager, $id) {
        // init the agence model.
        $agence = new Agence();

        // find the agence using the id.
        $agence = $entityManager->getRepository(Agence::class)->find($id);

        $form = $this->createFormBuilder($agence)
            // fileds.
            ->add('nom', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('telAgence', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('addressVille', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('modifier', SubmitType::class, [
                'label' => 'Modifier une agence',
                'attr' => ['class' => 'btn btn-primary form-control mt-3']
            ])
            // form builded.
            ->getForm();

        // process form data.
        $form->handleRequest($request);

        // look here if we use post request (submitted).
        if($form->isSubmitted() && $form->isValid()) {
            // execute the query.
            $entityManager->flush();

            // redirect to '/admin'.
            return $this->redirectToRoute('admin_route');
        }

        // otherwise, we use get request.
        return $this->render('pages/admin/modifier.html.twig', [
            // needed for manage UI through twig.
            'agence' => true,
            'voiture' => false,
            // create a view from the form builder.
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/agence/consulter/{id}", name="agence_voir", methods={"GET"})
     */
    public function voir (EntityManagerInterface $entityManager, $id)
    {
        // find the agence using the id. 
        $agence = $entityManager->getRepository(Agence::class)->find($id);
      
        // render the view and pass the $agence as variable.
        return $this->render('pages/admin/voir.html.twig', [ 
            'voiture' => false,
            'agence' => $agence 
        ]);
    }

    /**
     * @Route("/agence/supprimer/{id}", name="agence_a_supprimer", methods={"DELETE"})
     */
    public function delete (Request $request, EntityManagerInterface $entityManager, $id) {
        // find the agence using the id. 
        $agence = $entityManager->getRepository(Agence::class)->find($id);

        // remove the found agence.
        $entityManager->remove($agence);

        // execute the query.
        $entityManager->flush();

        // create response instance.
        $response = new Response();

        // send a response --> success <--.
        $response->send();
    }

    // // BETTER TO USE THE DELETE METHOD //
    // /**
    //  * @Route("/agence/supprimer/{id}", name="agence_a_supprimer", methods={"GET"})
    //  */
    // public function deleteByUseGetMethod(Request $request, EntityManagerInterface $entityManager, $id) {
    //     // find the agence using the id. 
    //     $agence = $entityManager->getRepository(Agence::class)->find($id);

    //     // remove the found agence.
    //     $entityManager->remove($agence);

    //     // execute the query.
    //     $entityManager->flush();

    //     // redirect to '/admin'.
    //     return $this->redirectToRoute('admin_route');
    // }
}
