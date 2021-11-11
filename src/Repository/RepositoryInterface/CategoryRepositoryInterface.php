<?php


namespace App\Repository\RepositoryInterface;


use App\Entity\Category;

interface CategoryRepositoryInterface
{
    /**
     * @return Category[]
     */
    public function getAllCategory(): array;

    /**
     * @param int $categoryId
     * @return Category
     */
    public function getOneCategory(int $categoryId):object;

    /**
     * @param Category $category
     * @return object
     */
    public function setCreateCategory(Category $category): object;

    /**
     * @param Category $category
     * @return object
     */
    public function setUpdateCategory(Category $category): object;

    /**
     * @param Category $category
     * @return mixed
     */
    public function setDeleteCategory(Category $category);
}