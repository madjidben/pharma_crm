<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\User;
use App\Entity\Position;
use App\Entity\BusinessUnit;
use App\Entity\Team;
use App\Entity\ProductCategory;
use App\Entity\Product;
use App\Entity\ProductForm;
use App\Entity\Wilaya;

class AppFixtures extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $userAdmin = new User();
        $userAdmin->setEmail('admin@stebiol.com')
            ->setFirstName("Madjid")
            ->setLastName("Bendjaballah")
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword($this->passwordHasher->hashPassword(
                $userAdmin,
                'admin'
            ));
        $manager->persist($userAdmin);
//-----------------------------------------Positions
$positionArray = array();      
$row = 1;
$file = fopen(dirname(__DIR__).'\DataFixtures\Assets\position.csv', "r");
while (($data = fgetcsv($file, 8000, ",")) !== FALSE) {
  
$row++;
$position = new Position();
$position->setName($data[1]);
$position->setType($data[2]);
$positionArray[]=$position; 
$manager->persist($position);

}
fclose($file);

//-----------------------------------------BusinessUnit
$businessUnitArray = array(); 
$row = 1;
$file = fopen(dirname(__DIR__).'\DataFixtures\Assets\businessUnit.csv', "r");
while (($data = fgetcsv($file, 8000, ",")) !== FALSE) {
$row++;
$businessUnit = new BusinessUnit();
$businessUnit->setName($data[1]);
$businessUnit->setManager($positionArray[$data[2]-1]);
$businessUnitArray[]=$businessUnit; 
$manager->persist($businessUnit);

}
fclose($file);

//-----------------------------------------Team
$teamArray = array(); 
$row = 1;
$file = fopen(dirname(__DIR__).'\DataFixtures\Assets\team.csv', "r");
while (($data = fgetcsv($file, 8000, ",")) !== FALSE) {
$row++;
$team = new Team();
$team->setName($data[2]);
$team->setBusinessUnit($businessUnitArray[$data[1]-1]);
$team->setManager($positionArray[$data[3]-1]);
$teamArray[]=$team; 
$manager->persist($team);

}
fclose($file);

//-----------------------------------------ProductCategory
$productCategoryArray = array(); 
$row = 1;
$file = fopen(dirname(__DIR__).'\DataFixtures\Assets\productCategory.csv', "r");
while (($data = fgetcsv($file, 8000, ",")) !== FALSE) {
$row++;
$productCategory = new ProductCategory();
$productCategory->setName($data[1]);
$productCategoryArray[]=$productCategory; 
$manager->persist($productCategory);

}
fclose($file);

//-----------------------------------------Product
$productArray = array(); 
$row = 1;
$file = fopen(dirname(__DIR__).'\DataFixtures\Assets\product.csv', "r");
while (($data = fgetcsv($file, 8000, ",")) !== FALSE) {
$row++;
$product = new Product();
$product->setName($data[2]);
$product->setCategory($productCategoryArray[$data[1]-1]);
$product->setManager($positionArray[$data[3]-1]);
$productArray[]=$product; 
$manager->persist($product);

}
fclose($file);

//-----------------------------------------ProductForm
$productFormArray = array(); 
$row = 1;
$file = fopen(dirname(__DIR__).'\DataFixtures\Assets\productForm.csv', "r");
while (($data = fgetcsv($file, 8000, ",")) !== FALSE) {
$row++;
$productForm = new ProductForm();
$productForm->setName($data[2]);
$productForm->setProduct($productArray[$data[1]-1]);
$productFormArray[]=$productForm; 
$manager->persist($productForm);

}
fclose($file);

//-----------------------------------------Wilaya
$wilayaArray = array(); 
$row = 1;
$file = fopen(dirname(__DIR__).'\DataFixtures\Assets\wilaya.csv', "r");
while (($data = fgetcsv($file, 8000, ",")) !== FALSE) {
$row++;
$wilaya = new Wilaya();
$wilaya->setName($data[2]);
$wilaya->setCode($data[1]);
$wilaya->setDataEntryManager($positionArray[$data[3]-1]);
$wilayaArray[]=$wilaya; 
$manager->persist($wilaya);
}
fclose($file);


        $manager->flush();
    }
}
