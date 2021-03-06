<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    require_once "src/Client.php";
    require_once "src/Stylist.php";

    $server = 'mysql:host=localhost;dbname=hair_salon_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);


    class ClientTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Client::deleteAll();
            Stylist::deleteAll();
        }

        function test_save()
        {
            //Arrange
            $name = "Shirley";
            $id = null;
            $test_stylist = new Stylist($name, $id);
            $test_stylist->save();


            $name = "Barbara";
            $phone = "123-456-7899";
            $stylist_id = $test_stylist->getId();
            $test_client = new Client($id = null, $name, $phone, $stylist_id);
            $test_client->save();

            //Act
            $result = Client::getAll();
            //Assert
            $this->assertEquals($test_client, $result[0]);
        }

        function test_getAll()
        {
            //Arrange
            $name = "Shirley";
            $id = null;
            $test_stylist = new Stylist($name, $id);
            $test_stylist->save();

            $name = "Barbara";
            $phone = "123-456-7899";
            $stylist_id = $test_stylist->getId();
            $test_client = new Client($id = null, $name, $phone, $stylist_id);
            $test_client->save();


            $name2 = "Buffy";
            $phone2 = "126-456-7777";
            $stylist_id2 = $test_stylist->getId();
            $test_client2 = new Client($id2 = null, $name2, $phone2, $stylist_id2);
            $test_client2->save();


            //Act
            $result = Client::getAll();

            //Assert
            $this->assertEquals([$test_client, $test_client2], $result);
        }

        function test_deleteAll()
        {
            //Arrange
            $name = "Shirley";
            $id = null;
            $test_stylist = new Stylist($name, $id);
            $test_stylist->save();

            $name = "Barbara";
            $phone = "123-456-7899";
            $stylist_id = $test_stylist->getId();
            $test_client = new Client($id = null, $name, $phone, $stylist_id);
            $test_client->save();


            $name2 = "Buffy";
            $phone2 = "126-456-7777";
            $stylist_id2 = $test_stylist->getId();
            $test_client2 = new Client($id2 = null, $name2, $phone2, $stylist_id2);
            $test_client2->save();

            //Act
            Client::deleteAll();
            $result = Client::getAll();

            //Assert
            $this->assertEquals([], $result);
        }

        function test_find()
        {
            //Arrange
            $name = "Shirley";
            $id = null;
            $test_stylist = new Stylist($name, $id);
            $test_stylist->save();

            $name = "Barbara";
            $phone = "123-456-7899";
            $stylist_id = $test_stylist->getId();
            $test_client = new Client($id = null, $name, $phone, $stylist_id);
            $test_client->save();


            $name2 = "Buffy";
            $phone2 = "126-456-7777";
            $stylist_id2 = $test_stylist->getId();
            $test_client2 = new Client($id2 = null, $name2, $phone2, $stylist_id2);
            $test_client2->save();

            //Act
            $result = Client::find($test_client->getId());

            //Assert
            $this->assertEquals($test_client, $result);
        }

        function testUpdateClient()
        {
            //Arrange
            $name = 'Shirley';
            $test_Stylist = new Stylist($name);
            $test_Stylist->save();

            $name = "Barbara";
            $phone = "123-456-7899";
            $stylist_id = $test_Stylist->getId();
            $test_client = new Client($id = null, $name, $phone, $stylist_id);
            $test_client->save();

            $new_name = "Georgia";
            $new_phone = "678-987-1234";


            //Act
            $test_client->updateClient($new_name, $new_phone);
            // $result = Client::getAll();

            //Assert
            $this->assertEquals(["Georgia", "678-987-1234"], [$test_client->getName(), $test_client->getPhone()]);
        }

        function testDeleteClients()
        {
            //Arrange
            $name = 'Shirley';
            $test_Stylist = new Stylist($name);
            $test_Stylist->save();

            $name = "Barbara";
            $phone = "123-456-7899";
            $stylist_id = $test_Stylist->getId();
            $test_client = new Client($id = null, $name, $phone, $stylist_id);
            $test_client->save();


            //Act
            $test_client->delete();

            //Assert
            $this->assertEquals([], Client::getAll());
        }

        function testDeleteOneClient()
        {
            //Arrange
            $name = "Shirley";
            $id = null;
            $test_stylist = new Stylist($name, $id);
            $test_stylist->save();

            $name = "Barbara";
            $phone = "123-456-7899";
            $stylist_id = $test_stylist->getId();
            $test_client = new Client($id = null, $name, $phone, $stylist_id);
            $test_client->save();


            $name2 = "Buffy";
            $phone2 = "126-456-7777";
            $stylist_id2 = $test_stylist->getId();
            $test_client2 = new Client($id2 = null, $name2, $phone2, $stylist_id2);
            $test_client2->save();

            //Act
            $test_client->deleteOneClient();
            //Assert
            $this->assertEquals([$test_client2], Client::getAll());
        }


    }

?>
