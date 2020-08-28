<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 */
class Article
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $articleName;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $origine;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $composition;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $nutritionInformation;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $ingredients;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $expirationDate;

  
    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity=CartArticle::class, mappedBy="article")
     */
    private $cartArticles;

    /**
     * @ORM\OneToMany(targetEntity=Image::class, mappedBy="article", orphanRemoval=true, cascade={"persist"})
     */
    private $images;



    public function __construct()
    {
       
        $this->user = new ArrayCollection();
        $this->cartArticles = new ArrayCollection();
        $this->images = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getArticleName()
    {
        return $this->articleName;
    }

    public function setArticleName($articleName)
    {
        $this->articleName = $articleName;

        return $this;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getPhotos()
    {
        return $this->photos;
    }

    public function setPhotos($photos)
    {
        $this->photos = $photos;

        return $this;
    }

    public function getOrigine(): ?string
    {
        return $this->origine;
    }

    public function setOrigine(string $origine): self
    {
        $this->origine = $origine;

        return $this;
    }

    public function getComposition(): ?string
    {
        return $this->composition;
    }

    public function setComposition(string $composition): self
    {
        $this->composition = $composition;

        return $this;
    }

    public function getNutritionInformation(): ?string
    {
        return $this->nutritionInformation;
    }

    public function setNutritionInformation(string $nutritionInformation): self
    {
        $this->nutritionInformation = $nutritionInformation;

        return $this;
    }

    public function getIngredients(): ?string
    {
        return $this->ingredients;
    }

    public function setIngredients(string $ingredients): self
    {
        $this->ingredients = $ingredients;

        return $this;
    }

    public function getExpirationDate(): ?\DateTimeInterface
    {
        return $this->expirationDate;
    }

    public function setExpirationDate(\DateTimeInterface $expirationDate): self
    {
        $this->expirationDate = $expirationDate;

        return $this;
    }


    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCart(): ?Cart
    {
        return $this->cart;
    }

    public function setCart(?Cart $cart): self
    {
        $this->cart = $cart;

        return $this;
    }

    public function addUser(User $user): self
    {
        if (!$this->user->contains($user)) {
            $this->user[] = $user;
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->user->contains($user)) {
            $this->user->removeElement($user);
        }

        return $this;
    }

    /**
     * @return Collection|CartArticle[]
     */
    public function getCartArticles(): Collection
    {
        return $this->cartArticles;
    }

    public function addCartArticle(CartArticle $cartArticle): self
    {
        if (!$this->cartArticles->contains($cartArticle)) {
            $this->cartArticles[] = $cartArticle;
            $cartArticle->setItem($this);
        }

        return $this;
    }

    public function removeCartArticle(CartArticle $cartArticle): self
    {
        if ($this->cartArticles->contains($cartArticle)) {
            $this->cartArticles->removeElement($cartArticle);
            // set the owning side to null (unless already changed)
            if ($cartArticle->getItem() === $this) {
                $cartArticle->setItem(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Image[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setArticle($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
            // set the owning side to null (unless already changed)
            if ($image->getArticle() === $this) {
                $image->setArticle(null);
            }
        }

        return $this;
    }

}
