<?php

namespace Blog\BlogBundle\Controller;

use Blog\BlogBundle\Entity\Post;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class PostController extends Controller
{
    /**
     * @Route("/post", name="pages/index_post_route")
     */
    public function postAction()

    {
    $em = $this->getDoctrine()->getManager();
    
    $posts = $em->getRepository('BlogBundle:Post')->findAll();
    
    return $this->render('BlogBundle:pages:index.html.twig', array('posts'=>$posts));
    }

    /**
     * @Route("/post/create", name="pages/create_post_route")
     */
    public function createPostAction(Request $request)

    {
        $post=new Post();
        $form=$this->createFormBuilder($post)
        ->add('title', TextType::Class, array('attr'=>array('class'=>'form-control')))
        ->add('description', TextareaType::Class, array('attr'=>array('class'=>'form-control')))
        ->add('category', TextareaType::Class, array('attr'=>array('class'=>'form-control')))
        ->add('save', SubmitType::Class, array('label'=>'Create Post','attr'=>array('class'=>'
        btn btn-primary', 'style'=>'margin-top:20px')))
        ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            $title=$form['title']->getData();
            $description=$form['description']->getData();
            $category=$form['category']->getData();
            $post->setTitle($title);
            $post->setTitle($description);
            $post->setTitle($category);
           $em=$this->getDoctrine()->getManager();
           $em->persist($post);
            $em->flush();
            $this->addFlash('message', 'Post saved Sussessfully!');
            return $this->redirectToRoute('pages/index_post_route');
        }      
       
        return $this->render('BlogBundle:pages:create.html.twig', [
            'form'=>$form->createView()]);
    }


    /**
     * @Route("/post/update/{id}", name="pages/update_post_route")
     */
    public function updatePostAction(Request $request ,$id)
    {
        $post =$this->getDoctrine()->getRepository('BlogBundle:Post')->find($id);
        $post->setTitle($post->getTitle());
        $post->setTitle($post->getDescription());
        $post->setTitle($post->getCategory());
        $form=$this->createFormBuilder($post)
        ->add('title', TextType::Class, array('attr'=>array('class'=>'form-control')))
        ->add('description', TextareaType::Class, array('attr'=>array('class'=>'form-control')))
        ->add('category', TextareaType::Class, array('attr'=>array('class'=>'form-control')))
        ->add('save', SubmitType::Class, array('label'=>'Update Post','attr'=>array('class'=>'
        btn btn-primary', 'style'=>'margin-top:20px')))
        ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            $title=$form['title']->getData();
            $description=$form['description']->getData();
            $category=$form['category']->getData();
           $em=$this->getDoctrine()->getManager();
           $post=$em->getRepository('BlogBundle:Post')->find($id);

           $post->setTitle($title);
           $post->setDescription($description);
           $post->setCategory($category);

           $em->flush();
            $this->addFlash('message', '    Post updated Sussessfully!');
            return $this->redirectToRoute('pages/index_post_route');
        }      
        return $this->render('BlogBundle:pages:update.html.twig', [
            'form'=>$form->createView()]);
    }
    /**
     * @Route("/post/delete/{id}", name="pages/delete_post_route")
     */
    public function deletePostAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $post=$em->getRepository('BlogBundle:Post')->find($id);
        $em->remove($post);
        $em->flush();
        $this->addFlash('message', 'Post updated Sussessfully!');
        return $this->redirectToRoute('pages/index_post_route');
        
    }
     /**
     * @Route("/post/show/{id}", name="pages/show_post_route")
     */
    public function showPostAction($id){
 
    $post =$this->getDoctrine()->getRepository('BlogBundle:Post')->find($id);
    
        return $this->render('BlogBundle:pages:view.html.twig', ['post'=>$post]);
    }

}