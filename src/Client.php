<?php
    class Client
    {
        private $first_name;
        private $last_name;
        private $phone_number;
        private $stylist_id;
        private $id;

        function __construct($first_name, $last_name, $phone_number, $stylist_id, $id = null)
        {
            $this->first_name = $first_name;
            $this->last_name = $last_name;
            $this->phone_number = $phone_number;
            $this->stylist_id = $stylist_id;
            $this->id = $id;
        }

        function getId()
        {
            return $this->id;
        }

        function getStylistId()
        {
            return $this->stylist_id;
        }

        function setFirstName($new_first_name)
        {
            $this->first_name = (string) $new_first_name;
        }

        function getFirstName()
        {
            return $this->first_name;
        }

        function setLastName($new_last_name)
        {
            $this->last_name = (string) $new_last_name;
        }

        function getLastName()
        {
            return $this->last_name;
        }

        function setPhoneNumber($new_phone_number)
        {
            $this->phone_number = $new_phone_number;
        }

        function getPhoneNumber()
        {
            return $this->phone_number;
        }

        function save()
        {
            $GLOBALS["DB"]->exec("INSERT INTO clients (first_name, last_name, phone_number, stylist_id) VALUES ('{$this->getFirstName()}', '{$this->getLastName()}', {$this->getPhoneNumber()}, {$this->getStylistId()});");
            $this->id = $GLOBALS["DB"]->lastInsertId();
        }

        static function getAll()
        {
            $returned_clients = $GLOBALS["DB"]->query("SELECT * FROM clients;");
            $clients = array();

            foreach($returned_clients as $client) {
                $first_name = $client["first_name"];
                $last_name = $client["last_name"];
                $phone_number = $client["phone_number"];
                $stylist_id = $client["stylist_id"];
                $id = $client["id"];
                $test_client = new Client($first_name, $last_name, $phone_number, $stylist_id, $id);
                array_push($clients, $test_client);
            }

            return $clients;
        }

        static function deleteAll()
        {
            $GLOBALS["DB"]->exec("DELETE FROM clients;");
        }

        static function find($search_id)
        {
            $found_client = null;
            $clients = Client::getAll();

            foreach($clients as $client) {
                $client_id = $client->getId();
                if ($client_id == $search_id) {
                    $found_client = $client;
                }
            }

            return $found_client;
        }

        function update($new_first_name, $new_last_name, $new_phone_number)
        {
            if ($new_first_name) {
                $GLOBALS['DB']->exec("UPDATE clients SET first_name = '{$new_first_name}' WHERE id = {$this->getId()};");
                $this->setFirstName($new_first_name);
            }

            if ($new_last_name) {
                $GLOBALS['DB']->exec("UPDATE clients SET last_name = '{$new_last_name}' WHERE id = {$this->getId()};");
                $this->setLastName($new_last_name);
            }

            if ($new_phone_number) {
                $GLOBALS['DB']->exec("UPDATE clients SET phone_number = {$new_phone_number} WHERE id = {$this->getId()};");
                $this->setPhoneNumber($new_phone_number);
            }
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM stylists WHERE client_id = {$this->getId()};");
            $GLOBALS['DB']->exec("DELETE FROM clients WHERE id = {$this->getId()};");
        }
    }
?>
