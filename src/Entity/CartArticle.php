<?php

namespace App\Entity;

use App\Repository\CartArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CartArticleRepository::class)
 */
class CartArticle
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Cart::class, inversedBy="cartArticles")
     * @ORM\JoinColumn(name="cart_id", referencedColumnName="id")
     */
    private $cart;

    /**
     * @ORM\ManyToOne(targetEntity=Article::class, inversedBy="cartArticles")
     * @ORM\JoinColumn(name="article_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $article;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $quantity;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="cartArticle")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\Column(type="boolean")
     */
    private $envoyeAuCommercant = 0;

    /**
     * @ORM\Column(type="boolean")
     */
    private $enCoursdePreparation = 0;

    /**
     * @ORM\Column(type="boolean")
     */
    private $commandePrete = 0;

    public function __construct()
    {
        $this->user = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getItem(): ?Article
    {
        return $this->item;
    }

    public function setItem(?Article $item): self
    {
        $this->item = $item;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(?int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(User $user): self
    {
        if (!$this->user->contains($user)) {
            $this->user[] = $user;
            $user->setCartArticle($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->user->contains($user)) {
            $this->user->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getCartArticle() === $this) {
                $user->setCartArticle(null);
            }
        }

        return $this;
    }

    /**
     * Get the value of article
     */ 
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * Set the value of article
     *
     * @return  self
     */ 
    public function setArticle($article)
    {
        $this->article = $article;

        return $this;
    }

    /**
     * Set the value of user
     *
     * @return  self
     */ 
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    public function getEnvoyeAuCommercant(): ?bool
    {
        return $this->envoyeAuCommercant;
    }

    public function setEnvoyeAuCommercant(bool $envoyeAuCommercant): self
    {
        $this->envoyeAuCommercant = $envoyeAuCommercant;

        return $this;
    }

    public function getEnCoursdePreparation(): ?bool
    {
        return $this->enCoursdePreparation;
    }

    public function setEnCoursdePreparation(bool $enCoursdePreparation): self
    {
        $this->enCoursdePreparation = $enCoursdePreparation;

        return $this;
    }

    public function getCommandePrete(): ?bool
    {
        return $this->commandePrete;
    }

    public function setCommandePrete(bool $commandePrete): self
    {
        $this->commandePrete = $commandePrete;

        return $this;
    }
}
