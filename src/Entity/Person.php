<?php

namespace App\Entity;

use App\Repository\PersonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PersonRepository::class)]
class Person
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: "必ず値を入力して下さい。")]
    private ?string $name = null;

    #[ORM\Column(type: 'string',length: 255, nullable: true)]
    #[Assert\Email(message: "メールアドレスを入力して下さい。")]
    #[Assert\NotBlank(message: "必ず値を入力して下さい。")]
    private ?string $mail = null;

    #[ORM\Column(type:'integer', nullable: true)]
    #[Assert\Type(type: 'integer')]
    #[Assert\NotBlank(message: "必ず値を入力して下さい。")]
    private ?int $age = null;

    #[ORM\OneToMany(mappedBy: 'person', targetEntity: Message::class)]
    private Collection $messages;

    public function __construct()
    {
        $this->messages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(?string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(?int $age): self
    {
        $this->age = $age;

        return $this;
    }

    /**
     * @return Collection<int, Message>
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages->add($message);
            $message->setPerson($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getPerson() === $this) {
                $message->setPerson(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getName();
    }
}
