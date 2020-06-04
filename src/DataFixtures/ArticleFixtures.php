<?php

namespace App\DataFixtures;

use Faker\Factory;
use DateTimeInterface;
use App\Entity\Article;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ArticleFixtures extends Fixture
{
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



    }

    private function randomFloat($min, $max, $decimals = 0) 
    {
        $scale = pow(10, $decimals);
        return mt_rand($min * $scale, $max * $scale) / $scale;
    }

}
