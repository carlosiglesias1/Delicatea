<?php
class Usuario implements JsonSerializable
{
    private int $idUsr;
    private string $nick;
    private string $pass;
    private ?string $mail;
    private ?string $token;
    private ?bool $verificado;
    private ?int $rol;

    public function __construct(array $parametros = null)
    {
        if ($parametros != null) {
            foreach ($parametros as $key => $value) {
                $this->{$key} = $value;
            }
        }
    }

    public function toString(): string
    {
        return $this->idUsr . " | " . $this->nick . " | " . $this->pass . " | " . $this->mail;
    }

    public function jsonSerialize()
    {
        return array($this->idUsr, $this->nick, $this->pass, $this->mail, $this->token, $this->verificado, $this->rol);
    }
    /**
     * Get the value of email
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */
    public function setMail($email)
    {
        $this->mail = $email;

        return $this;
    }

    /**
     * Get the value of token
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set the value of token
     *
     * @return  self
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get the value of verificado
     */
    public function getVerificado()
    {
        return $this->verificado;
    }

    /**
     * Set the value of verificado
     *
     * @return  self
     */
    public function setVerificado($verificado)
    {
        $this->verificado = $verificado;

        return $this;
    }

    /**
     * Get the value of rol
     */
    public function getRol()
    {
        return $this->rol;
    }

    /**
     * Set the value of rol
     *
     * @return  self
     */
    public function setRol($rol)
    {
        $this->rol = $rol;

        return $this;
    }

    /**
     * Get the value of nick
     */
    public function getNick():string
    {
        return $this->nick;
    }

    /**
     * Set the value of nick
     *
     * @return  self
     */
    public function setNick($nick)
    {
        $this->nick = $nick;

        return $this;
    }

    /**
     * Get the value of pass
     */
    public function getPass():string
    {
        return $this->pass;
    }

    /**
     * Set the value of pass
     *
     * @return  self
     */
    public function setPass($pass)
    {
        $this->pass = $pass;

        return $this;
    }

    /**
     * Get the value of idUsr
     */
    public function getIdUsr()
    {
        return $this->idUsr;
    }

    /**
     * Set the value of idUsr
     *
     * @return  self
     */
    public function setIdUsr($idUsr)
    {
        $this->idUsr = $idUsr;

        return $this;
    }
}
