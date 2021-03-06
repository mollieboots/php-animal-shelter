<?php

    class AnimalType
    {
        private $type;
        private $id;

        function __construct($type, $id = null)
        {
            $this->type = $type;
            $this->id = $id;
        }

        function setType($new_type)
        {
            $this->type = $new_type;
        }

        function getType()
        {
            return $this->type;
        }

        function getID()
        {
            return $this->id;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO animal_type (type) VALUES ('{$this->getType()}')");
            $this->id= $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_types = $GLOBALS['DB']->query("SELECT * FROM animal_type;");
            $types = array();
            foreach($returned_types as $animal_type) {
                $type = $animal_type['type'];
                $id = $animal_type['id'];
                $new_type = new AnimalType($type, $id);
                array_push($types, $new_type);
            }
            return $types;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM animal_type;");
        }

        static function find($search_id)
        {
            $found_type = null;
            $types = AnimalType::getAll();
            foreach($types as $type) {
                $type_id = $type->getId();
                if ($type_id == $search_id) {
                    $found_type = $type;
                }
            }
            return $found_type;
        }

        function getAnimals()
        {
            $animals = Array();
            $returned_animals = $GLOBALS['DB']->query("SELECT * FROM  animal WHERE type_id = {$this->getId()};");
            foreach($returned_animals as $animal) {
                $name = $animal['name'];
                $gender = $animal['gender'];
                $date_admitted = $animal['date_admitted'];
                $breed = $animal['breed'];
                $id = $animal['id'];
                $type_id = $animal['type_id'];
                $new_animal = new Animal($name, $gender, $date_admitted, $breed, $type_id, $id);
                array_push($animals, $new_animal);
            }
            return $animals;
        }
    }



?>
