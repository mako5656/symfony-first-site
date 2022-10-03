<?php

namespace App\Controller;

use App\Entity\Person;
use App\Form\HelloType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

use Doctrine\ORM\EntityManagerInterface;

use App\Form\PersonType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use Doctrine\ORM\Query\ResultSetMappingBuilder;

use Symfony\Component\Validator\Validator\ValidatorInterface;

use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Component\Finder\Finder;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

class HelloController extends AbstractController
{
    #[Route('/hello', name:'hello')]
    public function index(Request $request, SessionInterface $session)
    {
        $formobj = new HelloForm();
        $form = $this->createForm(HelloType::class, $formobj);
        $form->handleRequest($request);

        if ($request->getMethod() == 'POST'){
            $formobj = $form->getData();
            $session->getFlashBag()->add('info.mail', $formobj);
            $msg = 'Hello, ' . $formobj->getName() . '!!';
        } else {
            $msg = 'Send Form';
        }
        return $this->render('hello/index.html.twig', [
            'title' => 'Hello',
            'message' => $msg,
            'bag' => $session->getFlashBag(),
            'form' => $form->createView(),
        ]);
    }

    #[Route('/find', name:'find')]
    public function find(Request $request, EntityManagerInterface $em)
    {
        $formobj = new FindForm();
        $form = $this->createFormBuilder($formobj)
            ->add('find', TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Click'))
            ->getForm();

        $repository = $em->getRepository(Person::class);

        $manager = $em;
        $mapping = new ResultSetMappingBuilder($manager);
        $mapping->addRootEntityFromClassMetadata('App\Entity\Person', 'p');

        if ($request->getMethod() == 'POST'){
            $form->handleRequest($request);
            $findstr = $form->getData()->getFind();
            $arr = explode(',', $findstr);
            $query = $manager->createNativeQuery(
                'SELECT * FROM person WHERE age between ?1 AND ?2', $mapping)
                ->setParameters(array(1 => $arr[0], 2 => $arr[1]));
            $result = $query->getResult();
        } else {
            $query = $manager->createNativeQuery(
                'SELECT * FROM person', $mapping);
            $result = $query->getResult();
        }
        return $this->render('hello/find.html.twig', [
            'title' => 'Hello',
            'form' => $form->createView(),
            'data' => $result,
        ]);
    }

    #[Route('/create', name:'create')]
    public function create(Request $request, ValidatorInterface $validator, EntityManagerInterface $em)
    {
        $form = $this->createFormBuilder()
            ->add('name', TextType::class,
                array(
                    'required' => true,
                    'constraints' => [
                        new Assert\Length(array(
                            'min' => 3, 'max' => 10,
                            'minMessage' => '３文字以上必要です。',
                            'maxMessage' => '10文字以内にして下さい。'))
                    ]
                )
            )
            ->add('save', SubmitType::class, array('label' => 'Click'))
            ->getForm();

        if ($request->getMethod() == 'POST'){
            $form->handleRequest($request);
            if ($form->isValid()){
                $msg = 'Hello, ' . $form->get('name')->getData() . '!';
            } else {
                $msg = 'ERROR!';
            }
        } else {
            $msg = 'Send Form';
        }
        return $this->render('hello/create.html.twig', [
            'title' => 'Hello',
            'message' => $msg,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/update/{id}', name:'update')]
    public function update(Request $request, Person $person, EntityManagerInterface $em)
    {
        $form = $this->createFormBuilder($person)
            ->add('name', TextType::class)
            ->add('mail', TextType::class)
            ->add('age', IntegerType::class)
            ->add('save', SubmitType::class, array('label' => 'Click'))
            ->getForm();

        if ($request->getMethod() == 'POST'){
            $form->handleRequest($request);
            $person = $form->getData();
            $manager = $em;
            $manager->flush();
            return $this->redirect('/hello');
        } else {
            return $this->render('hello/create.html.twig', [
                'title' => 'Hello',
                'message' => 'Update Entity id=' . $person->getId(),
                'form' => $form->createView(),
            ]);
        }
    }

    #[Route('/delete/{id}', name:'delete')]
    public function delete(Request $request, Person $person, EntityManagerInterface $em)
    {
        $form = $this->createFormBuilder($person)
            ->add('name', TextType::class)
            ->add('mail', TextType::class)
            ->add('age', IntegerType::class)
            ->add('save', SubmitType::class, array('label' => 'Click'))
            ->getForm();


        if ($request->getMethod() == 'POST'){
            $form->handleRequest($request);
            $person = $form->getData();
            $manager = $em;
            $manager->remove($person);
            $manager->flush();
            return $this->redirect('/hello');
        } else {
            return $this->render('hello/create.html.twig', [
                'title' => 'Hello',
                'message' => 'Delete Entity id=' . $person->getId(),
                'form' => $form->createView(),
            ]);
        }
    }

    #[Route('/clear', name:'clear')]
    public function clear(Request $request, SessionInterface $session)
    {
        $session->getFlashBag()->clear();
        return $this->redirect('/hello');
    }
}

class FindForm
{
    private $find;

    public function getFind()
    {
        return $this->find;
    }
    public function setFind($find)
    {
        $this->find = $find;
    }
}

class HelloForm
{
    private $name;
    private $mail;

    public function getName()
    {
        return $this->name;
    }
    public function setName($name)
    {
        $this->name = $name;
    }

    public function getMail()
    {
        return $this->mail;
    }
    public function setMail($mail)
    {
        $this->mail = $mail;
    }

    public function __toString()
    {
        return '*** ' . $this->name . ' [' . $this->mail . '] ***';
    }
}
