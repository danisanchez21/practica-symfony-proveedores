<?php

namespace App\Controller;

use App\Entity\Proveedor;
use App\Form\ProveedorType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/proveedores')]
class ProveedorController extends AbstractController
{
    //Método para listar todos los proveedores
    
    /**
     * @Route("/proveedores/listar", name="proveedor_listar")
     */
    public function index(EntityManagerInterface $em): Response
    {
        $proveedores = $em->getRepository(Proveedor::class)->findAll();

        return $this->render('proveedor/listar.html.twig', [
            'proveedores' => $proveedores,
        ]);
    }

    //Método para crear proveedores

    /**
     * @Route("/proveedores/nuevo", name="proveedor_nuevo")
     */
    public function nuevo(Request $request, EntityManagerInterface $em): Response
    {
        $proveedor = new Proveedor();
        $form = $this->createForm(ProveedorType::class, $proveedor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($proveedor);
            $em->flush();

            return $this->redirectToRoute('proveedor_listar');
        }

        return $this->render('proveedor/nuevo.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    //Método para editar proveedores

    /**
     * @Route("/proveedores/editar/{id}", name="proveedor_editar")
     */
    public function editar(Request $request, Proveedor $proveedor, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(ProveedorType::class, $proveedor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $proveedor->setActualizadoEn(new \DateTime());
            $em->flush();

            return $this->redirectToRoute('proveedor_listar');
        }

        return $this->render('proveedor/editar.html.twig', [
            'form' => $form->createView(),
            'proveedor' => $proveedor,
        ]);
    }

    //Método para borrar proveedores

    /**
     * @Route("/proveedores/borrar/{id}", name="proveedor_borrar")
     */
    public function borrar(Proveedor $proveedor, EntityManagerInterface $em): Response
    {
        $em->remove($proveedor);
        $em->flush();

        return $this->redirectToRoute('proveedor_listar');
    }
}
