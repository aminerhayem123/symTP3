<?php

namespace App\Controller;

use App\Entity\Agence;
use App\Entity\Voiture;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class VoitureController extends AbstractController
{
    // ************************************************************************ //
    // NOTE: It's better to create a service layer and use it for DRY principe. //
    // ************************************************************************ //

    /**
     * @Route("/voiture/ajouter", name ="ajouter_voiture", methods={"GET", "POST"})
     */
    public function ajouter (Request $request, EntityManagerInterface $entityManager) {
        // init the voiture model.
        $voiture = new Voiture();
        
        // fetch agences.
        // NOTE: should use services for apply the DRY principe.  
        $agences = $this->getDoctrine()->getRepository(Agence::class)->findAll();
        
        // use only the nom attribute as display value 
        // and the id attribute as real value.
        // $choices = array_map(
        //     fn ($agence) => [$agence->getNom() => $agence],
        //     $agences
        // );
        
        // not functional programming like the prev.
        // behavoir but work fine with form builder
        $choices = function ($agences) {
            $stack = [];
            foreach ($agences as $key => $agence) {
                $stack[$agence->getNom()] = $agence;
            }

            return $stack;
        };

        // create a from through the symfony form builder. 
        $form = $this->createFormBuilder($voiture)
            // fileds.
            ->add('marque', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('coleur', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('description', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('nombreDePlace', IntegerType::class, ['attr' => ['class' => 'form-control']])
            ->add('agence', ChoiceType::class, [
                'attr' => ['class' => 'form-control'],
                'choices' => $choices($agences)
            ])
            ->add('ajouter', SubmitType::class, [
                'label' => 'Ajouter une voiture',
                'attr' => ['class' => 'btn btn-primary mt-3 form-control']
            ])
            // form builded.
            ->getForm();
 
        // process form data.
        $form->handleRequest($request);
 
        // look here if we use post request (submitted).
        if($form->isSubmitted() && $form->isValid()) {
            // extract form data.
            $voiture = $form->getData();
            // populate the agence id.
            $voiture->setAgenceId($voiture->getAgence()->getId());

            // save it to database.
            $entityManager->persist($voiture);

            // execute the query saved with the persist method.
            $entityManager->flush();

            // redirect to '/admin'.
            return $this->redirectToRoute('admin_route');
        }

        // otherwise hre we have get request.
        return $this->render('pages/admin/ajouter.html.twig', [ 
            // needed for manage UI through twig.
            'agence' => false,
            'voiture' => true,
            // create a view from the form builder.
            'form' => $form->createView()
        ]);
    }

    // BETTER TO USE PUT OR PATCH METHOD HER. //
    /**
     * @Route("/voiture/modifier/{id}", name ="modifier_voiture", methods={"GET", "POST"})
     */
    public function modifier (Request $request, EntityManagerInterface $entityManager, $id) {
        // init the voiture model.
        $voiture = new Voiture();
        
        // find the voiture using the id.
        $voiture = $entityManager->getRepository(Voiture::class)->find($id);
                
        // fetch agences.
        // NOTE: should use services for apply the DRY principe.  
        $agences = $this->getDoctrine()->getRepository(Agence::class)->findAll();
        
        // use only the nom attribute as display value 
        // and the id attribute as real value.
        // $choices = array_map(
        //     fn ($agence) => [$agence->getNom() => $agence],
        //     $agences
        // );
        
        // not functional programming like the prev.
        // behavoir but work fine with form builder
        $choices = function ($agences) {
            $stack = [];
            foreach ($agences as $key => $agence) {
                $stack[$agence->getNom()] = $agence;
            }

            return $stack;
        };

        $selected = function ($agences, $voiture) {
            foreach ($agences as $key => $agence) {
                if ($agence->getId() == $voiture->getAgenceId())
                    return $agence->getNom();
            }
        };

        // create a from through the symfony form builder. 
        $form = $this->createFormBuilder($voiture)
            // fileds.
            ->add('marque', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('coleur', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('description', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('nombreDePlace', IntegerType::class, ['attr' => ['class' => 'form-control']])
            ->add('nombreDePlace', IntegerType::class, ['attr' => ['class' => 'form-control']])
            ->add('agenceId', HiddenType::class, ['data' => $voiture->getAgenceId() ])
            ->add('agence', ChoiceType::class, [
                'attr' => ['class' => 'form-control'],
                'choices' => $choices($agences),
                // default selected data.
                'empty_data' => $selected($agences, $voiture)
            ])
            ->add('modifier', SubmitType::class, [
                'label' => 'Modifier une voiture',
                'attr' => ['class' => 'btn btn-primary mt-3 form-control']
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
        return $this->render('pages/admin/modifier.html.twig', array(
            // needed for manage UI through twig.
            'agence' => false,
            'voiture' => true,
            // create a view from the form builder.
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/voiture/consulter/{id}", name="voiture_voir", methods={"GET"})
     */
    public function voir (EntityManagerInterface $entityManager, $id)
    {
        // find the voiture using the id. 
        $voiture = $entityManager->getRepository(Voiture::class)->find(£ID);

        // render the view and pass the $voiture as variable.
        return $this->render('pages/admin/voir.html.twig', [ 
            'agence' => false,
            'voiture' => $voiture
        ]);
    }

    /**
     * @Route("/voiture/supprimer/{id}", name="voiture_a_supprimer", methods={"DELETE"})
     */
    public function delete(Request $request, EntityManagerInterface $entityManager, $id) {
        // find the voiture using the id. 
        $voiture = $entityManager->getRepository(Voiture::class)->find($id);

        // remove the found voiture.
        $entityManager->remove($voiture);

        // execute the query.
        $entityManager->flush();

        // create response instance.
        $response = new Response();

        // send a response --> success <--.
        $response->send();
    }

    // // BETTER TO USE THE DELETE METHOD //
    // /**
    //  * @Route("/voiture/supprimer/{id}", name="voiture_a_supprimer", methods={"GET"})
    //  */
    // public function deleteByUseGetMethod(Request $request, EntityManagerInterface $entityManager, $id) {
    //     // find the voiture using the id. 
    //     $voiture = $entityManager->getRepository(Voiture::class)->find($id);

    //     // remove the found voiture.
    //     $entityManager->remove($voiture);

    //     // execute the query.
    //     $entityManager->flush();

    //     // redirect to '/admin'.
    //     return $this->redirectToRoute('admin_route');
    // }
}
