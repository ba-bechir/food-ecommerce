<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert; 
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(
 * fields={"email"}, message="Email dejà utilisé")
 */
class User implements UserInterface
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
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $hash;

     /**
     * @ORM\Column(type="string", length=10)
     */
    private $phoneNumber;

    /**
     * @Assert\EqualTo(propertyPath="hash", message="Les deux mots de passe ne sont pas identiques")
     */
    private $passwordConfirm;

    /**
     * @ORM\ManyToMany(targetEntity=Role::class, mappedBy="users")
     */
    private $userRoles;

    /**
     * @ORM\OneToMany(targetEntity=CartArticle::class, mappedBy="user")
     * @ORM\JoinColumn(name="cart_article_id", referencedColumnName="id")
     */
    private $cartArticle;


    public function __construct()
    {
        $this->userRoles = new ArrayCollection();
        $this->articles = new ArrayCollection();
        
    }

    public function getPasswordConfirm(): ?string
    {
        return $this->passwordConfirm;
    }

    public function setPasswordConfirm(string $passwordConfirm)
    {
        $this->passwordConfirm = $passwordConfirm;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getHash(): ?string
    {
        return $this->hash;
    }

    public function setHash(string $hash): self
    {
        $this->hash = $hash;

        return $this;
    }

     /** Fonctions UserInterface à implémenter obligatoirement */
     public function getRoles()
     {
         //map : transforme un tableau de role en tableau avec seulement des titres
         $roles = $this->userRoles->map(function($role)
         {
             return $role->getTitle();
         })->toArray();
 
         $roles[] = 'ROLE_USER';
         
         return $roles;
     }
 
     public function getPassword()
     {
         return $this->hash;
     }
 
     //Inutile pour l'algo bcrypt
     public function getSalt() { }
 
     public function getUsername()
     {
         return $this->email;
     }
 
     public function eraseCredentials(){ }
 
     /**
      * @return Collection|Role[]
      */
     public function getUserRoles(): Collection
     {
         return $this->userRoles;
     }
 
     public function addUserRole(Role $userRole): self
     {
         if (!$this->userRoles->contains($userRole)) {
             $this->userRoles[] = $userRole;
             $userRole->addUser($this);
         }
 
         return $this;
     }
 
     public function removeUserRole(Role $userRole): self
     {
         if ($this->userRoles->contains($userRole)) {
             $this->userRoles->removeElement($userRole);
             $userRole->removeUser($this);
         }
 
         return $this;
     }


     /**
      * @return Collection|Article[]
      */
     public function getArticles(): Collection
     {
         return $this->articles;
     }

     public function addArticle(Article $article): self
     {
         if (!$this->articles->contains($article)) {
             $this->articles[] = $article;
             $article->setUser($this);
         }

         return $this;
     }

     public function removeArticle(Article $article): self
     {
         if ($this->articles->contains($article)) {
             $this->articles->removeElement($article);
             // set the owning side to null (unless already changed)
             if ($article->getUser() === $this) {
                 $article->setUser(null);
             }
         }

         return $this;
     }

     public function getCartArticle(): ?CartArticle
     {
         return $this->cartArticle;
     }

     public function setCartArticle(?CartArticle $cartArticle): self
     {
         $this->cartArticle = $cartArticle;

         return $this;
     }

}
