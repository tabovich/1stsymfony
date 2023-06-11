<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/todo")]    // Est un préfixe de l'URI qui s'applique à TOUTE la classe
class ToDoController extends AbstractController
{
    #[Route('/', name: 'app_to_do')]
    public function index(Request $request): Response
    {
        //afficher notre tableau de todo
        //si j'ai mon tableau de todo dans ma session, je ne fais que l'afficher
        //sinon je l'initialise puis j'affiche
        $session = $request->getSession();
        if(!$session->has('todos')) {
            $todos = [
                'achat' => 'acheter clé usb',
                'cours' => 'Finaliser mon cours',
                'correction' => 'corriger mon examen'
            ];
            $session->set('todos', $todos);
            $this->addFlash('info', "la liste des todos viens d'être initialisée"); //ajout d'un flashbag
        }
        //si j'ai mon tableau de todo dans ma session, je ne fais que l'afficher

        return $this->render('to_do/index.html.twig');
    }


// --------------- FONCTION ADD TO DO ----------------------
    #[Route(
        '/add/{key}/{element}',
         name: 'todo.add',
         defaults: ['element' => 'vous n\'avez rien renseigné']
         )]
    public function addTodo(Request $request, $key, $element): RedirectResponse {
    $session = $request->getSession();
    //Vérifier si j'ai mon tableau de todos dans ma session
    if ($session->has('todos')) {

    //si oui
    //vérifier si on a déja un todo avec la meme key
    $todos = $session->get('todos');
    if(isset($todos[$key])) {
        //si oui afficher erreur
        $this->addFlash('error', "le todo d'id $key existe déjà dans la liste"); //ajout d'un flashbag
    } else {
        //si non on l'ajoute et on affiche un message de succès
        $todos[$key] = $element;
        $this->addFlash('success', "le todo d'id $key a été ajouté avec succès"); //ajout d'un flashbag
        $session->set('todos', $todos);
    }
    } else {
//si non
    //afficher une erreur et on va rediriger vers le controller initial index()
    $this->addFlash('error', "la liste des todos n'est pas encore initialisée"); //ajout d'un flashbag
    }
    //redirige vers la liste des todo
    return $this->redirectToRoute('app_to_do');
}


// ------------------------- FONCTION UPDATE -------------------->
#[Route('/update/{key}/{element}', name: 'todo.update')]
public function updateTodo(Request $request, $key, $element): RedirectResponse {
$session = $request->getSession();
//Vérifier si j'ai mon tableau de todos dans ma session
if ($session->has('todos')) {
//si oui
//vérifier si on a déja un todo avec la meme key
$todos = $session->get('todos');
if(!isset($todos[$key])) {
    //si oui afficher erreur
    $this->addFlash('error', "le todo d'id $key n'existe pas dans la liste"); //ajout d'un flashbag
} else {
    //si non on l'ajoute et on affiche un message de succès
    $todos[$key] = $element;
    $this->addFlash('success', "le todo d'id $key a été modifié avec succès"); //ajout d'un flashbag
    $session->set('todos', $todos);
}
} else {
//si non
//afficher une erreur et on va rediriger vers le controller initial index()
$this->addFlash('error', "la liste des todos n'est pas encore initialisée"); //ajout d'un flashbag
}
//redirige vers la liste des todo
return $this->redirectToRoute('app_to_do');
}



// ------------ FONCTION DELETE --------------------
#[Route('/delete/{key}', name: 'todo.delete')]
public function deleteTodo(Request $request, $key): RedirectResponse {
$session = $request->getSession();
//Vérifier si j'ai mon tableau de todos dans ma session
if ($session->has('todos')) {
//si oui
//vérifier si on a déja un todo avec la meme key
$todos = $session->get('todos');
if(!isset($todos[$key])) {
    //si oui afficher erreur
    $this->addFlash('error', "le todo d'id $key n'existe pas dans la liste"); //ajout d'un flashbag
} else {
    //si non on l'ajoute et on affiche un message de succès
    unset($todos[$key]);
    $this->addFlash('success', "le todo d'id $key a été supprimé avec succès"); //ajout d'un flashbag
    $session->set('todos', $todos);
}
} else {
//si non
//afficher une erreur et on va rediriger vers le controller initial index()
$this->addFlash('error', "la liste des todos n'est pas encore initialisée"); //ajout d'un flashbag
}
//redirige vers la liste des todo
return $this->redirectToRoute('app_to_do');
}

// ---------------FONCTION RESET -------------------
#[Route('/reset', name: 'todo.reset')]
public function resetTodo(Request $request): RedirectResponse {
$session = $request->getSession();
$session->remove('todos');  //supprimer l'objet todo qui sera réinitialisé lors de la redirection
//redirige vers la liste des todo
return $this->redirectToRoute('app_to_do');
}
}




