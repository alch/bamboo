<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 * @author Aldo Chiecchia <zimage@tiscali.it>
 */

namespace Elcodi\AdminProductBundle\Controller\Component;

use Doctrine\ORM\Tools\Pagination\Paginator;
use Mmoreram\ControllerExtraBundle\Annotation\Entity as EntityAnnotation;
use Mmoreram\ControllerExtraBundle\Annotation\Form as FormAnnotation;
use Mmoreram\ControllerExtraBundle\Annotation\Paginator as PaginatorAnnotation;
use Mmoreram\ControllerExtraBundle\ValueObject\PaginatorAttributes;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\FormView;

use Elcodi\AdminCoreBundle\Controller\Abstracts\AbstractAdminController;
use Elcodi\AdminMediaBundle\Controller\Interfaces\GalleriableComponentControllerInterface;
use Elcodi\Component\Product\Entity\Interfaces\ProductInterface;

/**
 * Class ProductComponentController
 *
 * @Route(
 *      path = "product"
 * )
 */
class ProductComponentController
    extends
    AbstractAdminController
    implements
    GalleriableComponentControllerInterface
{
    /**
     * Component for entity list.
     *
     * As a component, this action should not return all the html macro, but
     * only the specific component
     *
     * @param Paginator           $paginator           Paginator instance
     * @param PaginatorAttributes $paginatorAttributes Paginator attributes
     * @param integer             $page                Page
     * @param integer             $limit               Limit of items per page
     * @param string              $orderByField        Field to order by
     * @param string              $orderByDirection    Direction to order by
     *
     * @return array Result
     *
     * @Route(
     *      path = "s/list/component/{page}/{limit}/{orderByField}/{orderByDirection}",
     *      name = "admin_product_list_component",
     *      requirements = {
     *          "page" = "\d*",
     *          "limit" = "\d*",
     *      },
     *      defaults = {
     *          "page" = "1",
     *          "limit" = "50",
     *          "orderByField" = "id",
     *          "orderByDirection" = "DESC",
     *      },
     * )
     * @Template("AdminProductBundle:Product:listComponent.html.twig")
     * @Method({"GET"})
     *
     * @PaginatorAnnotation(
     *      attributes = "paginatorAttributes",
     *      class = "elcodi.core.product.entity.product.class",
     *      page = "~page~",
     *      limit = "~limit~",
     *      orderBy = {
     *          {"x", "~orderByField~", "~orderByDirection~"}
     *      }
     * )
     */
    public function listComponentAction(
        Paginator $paginator,
        PaginatorAttributes $paginatorAttributes,
        $page,
        $limit,
        $orderByField,
        $orderByDirection
    )
    {
        return [
            'paginator'        => $paginator,
            'page'             => $page,
            'limit'            => $limit,
            'orderByField'     => $orderByField,
            'orderByDirection' => $orderByDirection,
            'totalPages'       => $paginatorAttributes->getTotalPages(),
            'totalElements'    => $paginatorAttributes->getTotalElements(),
        ];
    }

    /**
     * New element component action
     *
     * As a component, this action should not return all the html macro, but
     * only the specific component
     *
     * @param FormView         $formView Form view
     * @param ProductInterface $product  Product
     *
     * @return array Result
     *
     * @Route(
     *      path = "/{id}/component",
     *      name = "admin_product_edit_component",
     *      requirements = {
     *          "id" = "\d+",
     *      }
     * )
     * @Route(
     *      path = "/new/component",
     *      name = "admin_product_new_component",
     *      methods = {"GET"}
     * )
     * @Template("AdminProductBundle:Product:editComponent.html.twig")
     * @Method({"GET"})
     *
     * @EntityAnnotation(
     *      class = {
     *          "factory" = "elcodi.factory.product",
     *          "method" = "create",
     *          "static" = false
     *      },
     *      name = "product",
     *      mapping = {
     *          "id" = "~id~"
     *      },
     *      mappingFallback = true,
     * )
     * @FormAnnotation(
     *      class = "elcodi_admin_product_form_type_product",
     *      name  = "formView",
     *      entity = "product",
     *      handleRequest = true,
     *      validate = "isValid"
     * )
     */
    public function editComponentAction(
        FormView $formView,
        ProductInterface $product
    )
    {
        return [
            'product' => $product,
            'form'     => $formView,
        ];
    }

    /**
     * View gallery action
     *
     * @param mixed $entity Entity
     *
     * @return array result
     *
     * @Route(
     *      path = "/{id}/gallery/component",
     *      name = "admin_product_gallery_component"
     * )
     * @Template("AdminProductBundle:Gallery/Component:view.html.twig")
     * @Method({"GET"})
     *
     * @EntityAnnotation(
     *      class = "elcodi.core.product.entity.product.class",
     *      mapping = {
     *          "id" = "~id~"
     *      }
     * )
     */
    public function galleryComponentAction($entity)
    {
        /**
         * @var ProductInterface $entity
         */

        return [
            'entity' => $entity,
            'images' => $entity->getImages(),
        ];
    }
}
