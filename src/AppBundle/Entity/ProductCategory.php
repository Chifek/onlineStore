<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="ProductCategory")
 */
class ProductCategory
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $productId;

    /**
     * @ORM\Column(type="integer")
     */
    private $categoryId;

    public function setProductId($productId)
    {
        $this->productId = $productId;

        return $this;
    }

    public function getProductId()
    {
        return $this->productId;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;

        return $this;
    }

    public function getCategoryId()
    {
        return $this->categoryId;
    }
}
