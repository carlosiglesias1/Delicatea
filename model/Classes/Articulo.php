<?php
    class Articulo {
        private int $idArticulo;
        private string $nombre;
        private string $descripcionCorta;
        private string $descripcionLarga;
        private Marca $marca;
        private Categoria $categoria;
        private Subcategoria $subcategoria;
        private float $coste;
        private IVA $iva;
        private int $stock;

        public function __construct(array $parametros)
        {
            foreach($parametros as $key=>$value){
                    $this->{$key} = $value;
            }
        }

        /**
         * Get the value of stock
         */ 
        public function getStock()
        {
                return $this->stock;
        }

        /**
         * Set the value of stock
         *
         * @return  self
         */ 
        public function setStock($stock)
        {
                $this->stock = $stock;

                return $this;
        }

        /**
         * Get the value of iva
         */ 
        public function getIva()
        {
                return $this->iva;
        }

        /**
         * Set the value of iva
         *
         * @return  self
         */ 
        public function setIva($iva)
        {
                $this->iva = $iva;

                return $this;
        }

        /**
         * Get the value of coste
         */ 
        public function getCoste()
        {
                return $this->coste;
        }

        /**
         * Set the value of coste
         *
         * @return  self
         */ 
        public function setCoste($coste)
        {
                $this->coste = $coste;

                return $this;
        }

        /**
         * Get the value of subcategoria
         */ 
        public function getSubcategoria()
        {
                return $this->subcategoria;
        }

        /**
         * Set the value of subcategoria
         *
         * @return  self
         */ 
        public function setSubcategoria($subcategoria)
        {
                $this->subcategoria = $subcategoria;

                return $this;
        }

        /**
         * Get the value of categoria
         */ 
        public function getCategoria()
        {
                return $this->categoria;
        }

        /**
         * Set the value of categoria
         *
         * @return  self
         */ 
        public function setCategoria($categoria)
        {
                $this->categoria = $categoria;

                return $this;
        }

        /**
         * Get the value of marca
         */ 
        public function getMarca()
        {
                return $this->marca;
        }

        /**
         * Set the value of marca
         *
         * @return  self
         */ 
        public function setMarca($marca)
        {
                $this->marca = $marca;

                return $this;
        }

        /**
         * Get the value of descripcionLarga
         */ 
        public function getDescripcionLarga()
        {
                return $this->descripcionLarga;
        }

        /**
         * Set the value of descripcionLarga
         *
         * @return  self
         */ 
        public function setDescripcionLarga($descripcionLarga)
        {
                $this->descripcionLarga = $descripcionLarga;

                return $this;
        }

        /**
         * Get the value of descripcionCorta
         */ 
        public function getDescripcionCorta()
        {
                return $this->descripcionCorta;
        }

        /**
         * Set the value of descripcionCorta
         *
         * @return  self
         */ 
        public function setDescripcionCorta($descripcionCorta)
        {
                $this->descripcionCorta = $descripcionCorta;

                return $this;
        }

        /**
         * Get the value of nombre
         */ 
        public function getNombre()
        {
                return $this->nombre;
        }

        /**
         * Set the value of nombre
         *
         * @return  self
         */ 
        public function setNombre($nombre)
        {
                $this->nombre = $nombre;

                return $this;
        }

        /**
         * Get the value of idArticulo
         */ 
        public function getIdArticulo()
        {
                return $this->idArticulo;
        }

        /**
         * Set the value of idArticulo
         *
         * @return  self
         */ 
        public function setIdArticulo($idArticulo)
        {
                $this->idArticulo = $idArticulo;

                return $this;
        }
    }