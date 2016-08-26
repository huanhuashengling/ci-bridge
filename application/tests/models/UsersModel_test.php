<?php
/**
 * Part of CI PHPUnit Test
 *
 * @author     Kenji Suzuki <https://github.com/kenjis>
 * @license    MIT License
 * @copyright  2015 Kenji Suzuki
 * @link       https://github.com/kenjis/ci-phpunit-test
 */

namespace {

    class UsersModelTest extends TestCase
    {
        public function setUp()
        {
            $this->resetInstance();
            $this->CI->load->model('UsersModel');
            $this->obj = $this->CI->UsersModel;
        }

        /**
         * @group testAddressType
         * @group testAddress
         */
        public function testAddEvaluationIndex()
        {
            $test = "Test success add evaluation index.";
            $data = [
                'coursesId' => 1,
                'description' => "evaluation index",
                'lastUpdatedBy' => 'wenjie',
                'lastUpdateDate' => date("Y-m-d"),
                'orderNumber' => 5,
            ];
            $evaluationIndexsId = $this->obj->addEvaluationIndex($data);
            $actual = (boolean)$evaluationIndexsId;
            $expected = true;
            $this->assertEquals($expected, $actual, $test);

            return $evaluationIndexsId;
        }

        /**
         * @depends testAddAddressType
         * @group testAddressType
         * @group testAddress
         */
        // public function testGetOneAddressType($addressTypesId)
        // {
        //     $test = "Test success get one address type";
            
        //     $addressType = $this->obj->getOneAddressType($addressTypesId);
        //     $actual = $addressType['name'];
        //     $expected = 'Test address type';
        //     $this->assertEquals($expected, $actual, $test); 
        // }

        /**
         * @depends testAddAddressType
         * @group testAddressType
         * @group testAddress
         */
        // public function testEditEvaluationIndex($addressTypesId)
        // {
        //     $test = "Test success update address type";
        //     $data = [
        //         'id' => $addressTypesId,
        //         'name' => 'Test address type update',
        //         'description' => 'Test address type description update',
        //     ];
        //     $actual = $this->obj->updateAddressType($data);
        //     $expected = true;
        //     $this->assertEquals($expected, $actual, $test); 

        //     $addressType = $this->obj->getOneAddressType($addressTypesId);
        //     $actual = $addressType['name'];
        //     $expected = 'Test address type update';
        //     $this->assertEquals($expected, $actual, $test); 
        // }

        /**
         * @depends testAddAddressType
         * @group testAddressType
         * @group testAddress 
         */
        // public function testDeleteAddressType($addressTypesId)
        // {
        //     $test = "Test success delete address type";
            
        //     $actual = $this->obj->deleteAddressType($addressTypesId);
        //     $expected = true;
        //     $this->assertEquals($expected, $actual, $test); 

        //     $actual = $this->obj->getOneAddressType($addressTypesId);
        //     $expected = false;
        //     $this->assertEquals($expected, $actual, $test); 
        // }
        // 
        public function testGetClassStudentsByClassesId()
        {
            $test = "Test success get class students";
            $classesId = 2;
            $actual = $this->obj->getClassStudentsByClassesId($classesId);
            var_dump($actual);die();
            $expected = true;
            $this->assertEquals($expected, $actual, $test); 
        }
    }
}
