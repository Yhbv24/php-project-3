<?php
        /**
        * @backupGlobals disabled
        * @backupStaticAttributes disabled
        */

        require_once "src/Stylist.php";
        require_once "src/Client.php";

        $server = "mysql:host=localhost:8889;dbname=hair_salon_test";
        $username = "root";
        $password = "root";
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
                // Arrange
                $first_name = "John";
                $last_name = "Smith";
                $phone_number = 1234567890;
                $test_stylist = new Stylist($first_name, $last_name, $phone_number, $id);

                // Act
                $test_stylist->save();

                // Assert
                $result = Stylist::getAll();
                $this->assertEquals($test_stylist, $result[0]);
            }

            function test_getAll()
            {
                // Arrange
                $first_name = "John";
                $last_name = "Smith";
                $phone_number = 1234567890;
                $test_stylist = new Stylist($first_name, $last_name, $phone_number, $id);
                $test_stylist->save();

                $first_name2 = "Lucy";
                $last_name2 = "Jones";
                $phone_number2 = 1234567890;
                $test_stylist2 = new Stylist($first_name2, $last_name2, $phone_number2, $id);
                $test_stylist2->save();

                // Act
                $result = Stylist::getAll();

                // Assert
                $this->assertEquals([$test_stylist, $test_stylist2], $result);
            }

            function test_deleteAllStylists()
            {
                //Arrange
                $first_name = "John";
                $last_name = "Smith";
                $phone_number = 1234567890;
                $test_stylist = new Stylist($id, $first_name, $last_name, $phone_number);
                $test_stylist->save();

                $first_name2 = "Lucy";
                $last_name2 = "Jones";
                $phone_number2 = 1234567890;
                $test_stylist2 = new Stylist($id, $first_name2, $last_name2, $phone_number2);
                $test_stylist2->save();

                //Act
                Stylist::deleteAll();

                //Assert
                $result = Stylist::getAll();
                $this->assertEquals([], $result);
            }

            function test_getId()
            {
                //Arrange
                $first_name = "John";
                $last_name = "Smith";
                $phone_number = 1234567890;
                $id = 2;
                $test_stylist = new Stylist($first_name, $last_name, $phone_number, $id);

                //Act
                $result = $test_stylist->getId();

                //Assert
                $this->assertEquals(2, $result);
            }

            function test_find()
            {
                //Arrange
                $first_name = "John";
                $last_name = "Smith";
                $phone_number = 1234567890;
                $test_stylist = new Stylist($first_name, $last_name, $phone_number, $id);
                $test_stylist->save();

                $first_name2 = "Lucy";
                $last_name2 = "Jones";
                $phone_number2 = 1234567890;
                $test_stylist2 = new Stylist($first_name2, $last_name2, $phone_number2, $id);
                $test_stylist2->save();

                //Act
                $id = $test_stylist->getId();
                $result = Stylist::find($id);

                //Assert
                $this->assertEquals($test_stylist, $result);
            }

            function testUpdate()
            {
                //Arrange
                $first_name = "John";
                $last_name = "Smith";
                $phone_number = 1234567890;
                $test_stylist = new Stylist($first_name, $last_name, $phone_number, $id);
                $test_stylist->save();

                $new_phone_number = 1234313454;

                //Act
                $test_stylist->update($new_first_name, $new_last_name, $new_phone_number);
                $result = $test_stylist->getPhoneNumber();

                //Assert
                $this->assertEquals(1234313454, $result);
            }

            function testDeleteStylist()
            {
                //Arrange
                $first_name = "John";
                $last_name = "Smith";
                $phone_number = 1234567890;
                $test_stylist = new Stylist($first_name, $last_name, $phone_number, $id);
                $test_stylist->save();

                $first_name2 = "Lucy";
                $last_name2 = "Jones";
                $phone_number2 = 1234567890;
                $test_stylist2 = new Stylist($first_name2, $last_name2, $phone_number2, $id);
                $test_stylist2->save();


                //Act
                $test_stylist->delete();
                $result = Stylist::getAll();

                //Assert
                $this->assertEquals([$test_stylist2], $result);
            }
        }
?>
