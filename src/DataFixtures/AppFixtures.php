<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Role;
use App\Entity\User;
use DateTimeInterface;
use App\Entity\Article;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{

    private $encoder;
   
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    
    public function load(ObjectManager $manager)
    {
        $fakerFood = \Faker\Factory::create();
        $fakerFood->addProvider(new \FakerRestaurant\Provider\fr_FR\Restaurant($fakerFood));

        $faker = Factory::create('fr-FR'); 

        $randomFood = [
            $fakerFood->foodName(),  
            $fakerFood->beverageName(),
            $fakerFood->dairyName(),
            $fakerFood->vegetableName(),  
            $fakerFood->fruitName(),
            $fakerFood->meatName(), 
            $fakerFood->sauceName(),
        ];
        
        for($i = 0 ; $i <= 100 ; $i++)
        {
            $article = new Article();

            $article->setArticleName($faker->randomElement($randomFood))
                    ->setPrice($this->randomFloat(1, 20, 2))
                    ->setQuantity(mt_rand(0,100))
                    ->setPhotos($faker->imageUrl(348,220))
                    ->setOrigine($faker->country)
                    ->setComposition($faker->sentence())
                    ->setNutritionInformation('<p>'.join('</p><p>', $faker->paragraphs(3)).'</p>')
                    ->setIngredients('<p>'.join('</p><p>', $faker->paragraphs(2)).'</p>')
                    ->setExpirationDate($faker->dateTimeBetween('now', '+2 years'));

            $manager->persist($article);
        }

        $manager->flush();


        //Appel de Faker
        $faker = Factory::create('fr-FR');  

        $adminRole = new Role();
        $adminRole->setTitle('ROLE_ADMIN');
        $manager->persist($adminRole);

        $adminUser = new User();
        $adminUser->setFirstName('Bechir')
                    ->setLastName('BA')
                    ->setEmail('ba.bechir@symfony.com')
                    ->setHash($this->encoder->encodePassword($adminUser, 'password'))
                    ->addUserRole($adminRole);
        $manager->persist($adminUser);


        //Fixtues utilisateurs
        $users = [];
        $genres = ['male', 'female'];
        for ($i = 0 ; $i <=10 ; $i++){
            $user = new User();
            //Génère un élément aléatoire du tableau genre
            $genre = $faker->randomElement($genres);
        
            $hash = $this->encoder->encodePassword($user, 'password');

            $user->setFirstName($faker->firstname($genre))
                    ->setLastName($faker->lastname)
                    ->setEmail($faker->email)
                    ->setHash($hash);
            
            $manager->persist($user);
            $users[] = $user;

            $manager->flush();
        }
    }

    private function randomFloat($min, $max, $decimals = 0) 
    {
        $scale = pow(10, $decimals);
        return mt_rand($min * $scale, $max * $scale) / $scale;
    }

}
