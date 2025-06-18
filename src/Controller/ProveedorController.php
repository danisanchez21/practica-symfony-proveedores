<?php

namespace App\Controller;

use App\Entity\Proveedor;
use App\Form\ProveedorType;
use App\Repository\ProveedorRepository; // <- añadido necesario
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

//#[Route('/proveedores')]
class ProveedorController extends AbstractController
{
    //Método para listar todos los proveedores con filtros y búsqueda

    /**
     * @Route("/proveedores/listar", name="proveedor_listar")
     */
    public function listar(Request $request, ProveedorRepository $repo): Response
    {
        $busqueda = $request->query->get('q');
        $tipo = $request->query->get('tipo');
        $estado = $request->query->get('estado');
        $creadoDesde = $request->query->get('creadoDesde');
        $creadoHasta = $request->query->get('creadoHasta');
        $actualizadoDesde = $request->query->get('actualizadoDesde');
        $actualizadoHasta = $request->query->get('actualizadoHasta');

        $qb = $repo->createQueryBuilder('p');

        if ($busqueda) {
            $qb->andWhere('p.nombre LIKE :q OR p.email LIKE :q OR p.telefono LIKE :q')
                ->setParameter('q', '%' . $busqueda . '%');
        }
        if ($tipo) {
            $qb->andWhere('p.tipo = :tipo')
                ->setParameter('tipo', $tipo);
        }
        if ($estado !== null && $estado !== '') {
            $qb->andWhere('p.activo = :estado')
                ->setParameter('estado', $estado === '1');
        }
        if ($creadoDesde) {
            $qb->andWhere('p.creadoEn >= :creadoDesde')
                ->setParameter('creadoDesde', new \DateTime($creadoDesde . ' 00:00:00'));
        }
        if ($creadoHasta) {
            $qb->andWhere('p.creadoEn <= :creadoHasta')
                ->setParameter('creadoHasta', new \DateTime($creadoHasta . ' 23:59:59'));
        }
        if ($actualizadoDesde) {
            $qb->andWhere('p.actualizadoEn >= :actualizadoDesde')
                ->setParameter('actualizadoDesde', new \DateTime($actualizadoDesde . ' 00:00:00'));
        }
        if ($actualizadoHasta) {
            $qb->andWhere('p.actualizadoEn <= :actualizadoHasta')
                ->setParameter('actualizadoHasta', new \DateTime($actualizadoHasta . ' 23:59:59'));
        }

        $proveedores = $qb->getQuery()->getResult();

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
