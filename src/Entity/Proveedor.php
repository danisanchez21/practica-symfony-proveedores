<?php

namespace App\Entity;

use App\Repository\ProveedorRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=ProveedorRepository::class)
 * @UniqueEntity(fields={"email"}, message="ERROR: Ya existe un proveedor con este email.")
 * @UniqueEntity(fields={"telefono"}, message="ERROR: Ya existe un proveedor con este teléfono.")
 */
class Proveedor
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="El nombre es obligatorio.")
     * @Assert\Length(max=255, maxMessage="El nombre no puede superar los {{ limit }} caracteres.")
     * @Assert\Regex(
     *     pattern="/^[A-Za-zÀ-ÿ0-9\s.\-,'()]+$/u",
     *     message="El nombre solo puede contener letras, guiones, puntos, paréntesis, comas, apóstrofes y espacios."
     * )
     */
    private $nombre;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="El email es obligatorio.")
     * @Assert\Email(message="El email '{{ value }}' no es válido.")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="El teléfono es obligatorio.")
     * @Assert\Regex(
     *     pattern="/^\+?[0-9\s\-]{9,20}$/",
     *     message="El teléfono puede incluir dígitos, espacios o guiones, y debe tener entre 9 y 20 caracteres."
     * )
     */
    private $telefono;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="El tipo de proveedor es obligatorio.")
     * @Assert\Choice(choices={"hotel", "pista", "complemento"}, message="El tipo debe ser hotel, pista o complemento.")
     */
    private $tipo;

    /**
     * @ORM\Column(type="boolean")
     * @Assert\Type(type="bool", message="El valor de estado debe ser verdadero o falso.")
     */
    private $estado;

    /**
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $creadoEn;

    /**
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $actualizadoEn;

    public function __construct()
    {
        $this->creadoEn = new \DateTime();
        $this->actualizadoEn = new \DateTime();
    }

    public function getId(): ?int { return $this->id; }
    public function getNombre(): ?string { return $this->nombre; }
    public function setNombre(string $nombre): self { $this->nombre = $nombre; return $this; }

    public function getEmail(): ?string { return $this->email; }
    public function setEmail(string $email): self { $this->email = $email; return $this; }

    public function getTelefono(): ?string { return $this->telefono; }
    public function setTelefono(string $telefono): self { $this->telefono = $telefono; return $this; }

    public function getTipo(): ?string { return $this->tipo; }
    public function setTipo(string $tipo): self { $this->tipo = $tipo; return $this; }

    public function getEstado(): ?bool { return $this->estado; }
    public function setEstado(bool $estado): self { $this->estado = $estado; return $this; }

    public function getCreadoEn(): ?\DateTimeInterface { return $this->creadoEn; }
    public function setCreadoEn(\DateTimeInterface $creadoEn): self { $this->creadoEn = $creadoEn; return $this; }

    public function getActualizadoEn(): ?\DateTimeInterface { return $this->actualizadoEn; }
    public function setActualizadoEn(\DateTimeInterface $actualizadoEn): self { $this->actualizadoEn = $actualizadoEn; return $this; }
}
