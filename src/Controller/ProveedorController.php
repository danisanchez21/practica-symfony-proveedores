<?php

namespace App\Controller;

use App\Entity\Proveedor;
use App\Form\ProveedorType;
use App\Repository\ProveedorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProveedorController extends AbstractController
{
    /**
     * @Route("/proveedores/listar", name="proveedor_listar")
     */
    public function listar(
        Request $request,
        ProveedorRepository $repo,
        PaginatorInterface $paginator
    ): Response {
        // 1) Recogemos filtros y límite dinámico
        $busqueda = $request->query->get('q');
        $tipo = $request->query->get('tipo');
        $estado = $request->query->get('estado');
        $creadoDesde = $request->query->get('creadoDesde');
        $creadoHasta = $request->query->get('creadoHasta');
        $actualizadoDesde = $request->query->get('actualizadoDesde');
        $actualizadoHasta = $request->query->get('actualizadoHasta');
        $limit = $request->query->getInt('limit', 10);

        // 2) Montamos QueryBuilder con filtros
        $qb = $repo->createQueryBuilder('p');
        if ($busqueda) {
            $qb->andWhere('p.nombre LIKE :q OR p.email LIKE :q OR p.telefono LIKE :q')
                ->setParameter('q', '%' . $busqueda . '%');
        }
        if ($tipo) {
            $qb->andWhere('p.tipo = :tipo')->setParameter('tipo', $tipo);
        }
        if (null !== $estado && '' !== $estado) {
            $qb->andWhere('p.activo = :activo')
                ->setParameter('activo', $estado === '1');
        }
        if ($creadoDesde) {
            $qb->andWhere('p.creadoEn >= :desde')->setParameter('desde', new \DateTime($creadoDesde . ' 00:00:00'));
        }
        if ($creadoHasta) {
            $qb->andWhere('p.creadoEn <= :hasta')->setParameter('hasta', new \DateTime($creadoHasta . ' 23:59:59'));
        }
        if ($actualizadoDesde) {
            $qb->andWhere('p.actualizadoEn >= :actDesde')->setParameter('actDesde', new \DateTime($actualizadoDesde . ' 00:00:00'));
        }
        if ($actualizadoHasta) {
            $qb->andWhere('p.actualizadoEn <= :actHasta')->setParameter('actHasta', new \DateTime($actualizadoHasta . ' 23:59:59'));
        }

        // 3) Paginación
        $pagination = $paginator->paginate(
            $qb,
            $request->query->getInt('page', 1),
            $limit
        );

        return $this->render('proveedor/listar.html.twig', [
            'proveedores' => $pagination,
            'limit' => $limit,
        ]);
    }

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
