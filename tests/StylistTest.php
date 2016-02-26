<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Stylist.php";
    require_once "src/Client.php";

    $server = 'mysql:host=localhost;dbname=hair_salon_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class StylistTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown()
        {
          Stylist::deleteAll();
          Client::deleteAll();
        }

        function test_save()
        {
            //Arrange
            $name = "Shirley";
            $test_Stylist = new Stylist($name);
            $test_Stylist->save();

            //Act
            $result = Stylist::getAll();

            //Assert
            $this->assertEquals($test_Stylist, $result[0]);
        }

        function test_getAll()
        {
            //Arrange
            $name = "Shirley";
            $name2 = "Bertha";
            $test_Stylist = new Stylist($name);
            $test_Stylist->save();
            $test_Stylist2 = new Stylist($name2);
            $test_Stylist2->save();

            //Act
            $result = Stylist::getAll();

            //Assert
            $this->assertEquals([$test_Stylist, $test_Stylist2], $result);
        }

        function test_getClients()
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
            $result = $test_stylist->getClients();

            //Assert
            $this->assertEquals([$test_client, $test_client2], $result);
        }

        function test_deleteAll()
        {
            //Arrange
            $name = "Shirley";
            $name2 = "Bertha";
            $test_Stylist = new Stylist($name);
            $test_Stylist->save();
            $test_Stylist2 = new Stylist($name2);
            $test_Stylist2->save();

            //Act
            Stylist::deleteAll();
            $result = Stylist::getAll();

            //Assert
            $this->assertEquals([], $result);
        }

        function test_find()
        {
            //Arrange
            $name = "Shirley";
            $name2 = "Bertha";
            $test_Stylist = new Stylist($name);
            $test_Stylist->save();
            $test_Stylist2 = new Stylist($name2);
            $test_Stylist2->save();

            //Act
            $result = Stylist::find($test_Stylist->getId());

            //Assert
            $this->assertEquals($test_Stylist, $result);
        }

        function testUpdate()
        {
            //Arrange
            $name = "Shirley";
            $id = null;
            $test_stylist = new Stylist($name, $id);
            $test_stylist->save();

            $new_name = "Brad";

            //Act
            $test_stylist->update($new_name);

            //Assert
            $this->assertEquals("Brad", $test_stylist->getName());
        }

        function testDelete()
        {
            //Arrange
            $name = "Shirley";
            $id = null;
            $test_stylist = new Stylist($name, $id);
            $test_stylist->save();

            $name2 = "Bertha";
            $test_stylist2 = new Stylist($name2, $id);
            $test_stylist2->save();


            //Act
            $test_stylist->delete();

            //Assert
            $this->assertEquals([$test_stylist2], Stylist::getAll());
        }

        function testDelete_StylistClients()
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
            $test_stylist->delete();

            //Assert
            $this->assertEquals([], Client::getAll());
        }



    }
?>
