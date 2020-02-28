<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategorieRepository as CR;
use App\Form\AjouterCategorieType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface as EMI;
use App\Entity\Categorie;

class CategorieController extends AbstractController
{
    /**
     * @Route("/categorie", name="categorie")
     */
    public function index(CR $cr)
    {
        $categories = $cr->findAll();
        return $this->render('categorie/list.html.twig',
            compact($categories));
    }

    /**
     * @Route("/categorie/add", name="categorie_form", methods="GET")
     */
    public function form()
    {
        $form = $this->createForm(AjouterCategorieType::class);
        return $this->render('categorie/form.html.twig', [ 'form' => $form->createView() ]);
    }

    /**
     * @Route("/categorie/add", name="categorie_add", methods="POST")
     */
    public function add(Request $rq, EMI $em)
    {
        // Les données du $_POST peuvent être récupérés avec
        // $request->request->get("nomDuFormulaire") qui est un array (comme $_POST)
        try{
            // Créer le formulaire
            $form = $this->createForm(AjouterCategorieType::class);

            // Passer la requête HTTP au formulaire
            $form->handleRequest($rq);

            if( $form->isSubmitted() && $form->isValid() ){
                // Récupérer les données envoyées (si le formulaire est lié à une entité, getData() renvoie un
                // objet de la classe de cette entité )
                $data = $form->getData();

                $em->persist($data);
                $em->flush();
                $this->addFlash('success', 'La catégorie  a bien été enregistrée !');
                return $this->redirectToRoute("home");
            }
            elseif(!$form->isValid()) {
                $this->addFlash('error', 'Les données du formulaire ne sont pas valides');
                // $form = $this->createForm(CategorieType::class, $form->getData());
                return $this->render('categorie/form.html.twig', [
                    'form' => $form->createView(),
                ]);
            }


        } catch (\Doctrine\DBAL\DBALException $e) {
            dd($e->getMessage(), $e);
        }
        catch (\Exception $e){
            dd($e->getMessage(), $e);
        }
        return $this->render('categorie/list.html.twig', []);

    }

    /**
     * @Route("/categorie/liste", name="categorie_list")
     */
    public function list(CR $cr)
    {
        $categories = $cr->findAll();
        // Récupération des propriétés d'un objet Categorie (PB : récupère aussi les relations (i.e. annonces))
        $champs = array_keys((array)$categories[0]);
        $champs = array_map(function($val){ return str_replace(Categorie::class, "", $val); }, $champs);

        return $this->render('categorie/list.html.twig', compact("categories"));
    }


}
