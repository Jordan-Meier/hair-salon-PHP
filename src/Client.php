<?php
    class Client
    {
        private $id;
        private $name;
        private $phone;
        private $stylist_id;

        function __construct($id = null, $name, $phone, $stylist_id)
        {
            $this->id = $id;
            $this->name = $name;
            $this->phone = $phone;
            $this->stylist_id = $stylist_id;
        }

        function getId()
        {
            return $this->id;
        }

        function setName($new_name)
        {
            $this->name = (string) $new_name;
        }

        function getName()
        {
            return $this->name;
        }

        function setPhone($new_phone)
        {
            $this->phone = (string) $new_phone;
        }

        function getPhone()
        {
            return $this->phone;
        }

        function setStylistId($new_stylist_id)
        {
            $this->stylist_id = $new_stylist_id;
        }

        function getStylistId()
        {
            return $this->stylist_id;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO clients (name, phone, stylist_id) VALUES ('{$this->getName()}', '{$this->getPhone()}', {$this->getStylistId()});");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_clients = $GLOBALS['DB']->query("SELECT * FROM  clients;");
            $clients = array();
            foreach($returned_clients as $client) {
                $name = $client['name'];
                $id = $client['id'];
                $phone = $client['phone'];
                $stylist_id = $client['stylist_id'];
                $new_client = new Client($id, $name, $phone, $stylist_id);
                array_push($clients, $new_client);
            }
            return $clients;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM clients;");
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

        function updateClient($new_name, $new_phone)
        {
            $GLOBALS['DB']->exec("UPDATE clients SET name = '{$new_name}', phone = '{$new_phone}' WHERE id = {$this->getId()};");

            $this->setName($new_name);
            $this->setPhone($new_phone);
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM clients WHERE stylist_id = {$this->getStylistId()};");
        }

        function deleteOneClient()
        {
            $GLOBALS['DB']->exec("DELETE FROM clients WHERE id = {$this->getId()};");
        }
    }
?>
