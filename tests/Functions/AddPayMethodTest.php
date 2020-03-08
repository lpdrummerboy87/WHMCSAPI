<?php

namespace WHMCSAPI\Tests\Functions;

use WHMCSAPI\Exception\NotServiceable;
use WHMCSAPI\Tests\BaseTest;

class AddPayMethodTest extends BaseTest
{
    public function testCanUseAddPayMethodCommand()
    {
        $GLOBALS['whmcsApi']->quoteid = 1;
        $GLOBALS['whmcsApi']->command('AddPayMethod');
        $this->assertEquals('AddPayMethod', $GLOBALS['whmcsApi']->action);
    }

    public function testNoClientIDCauseException()
    {
        $this->assertNull($GLOBALS['whmcsApi']->clientid);
        $this->expectException(NotServiceable::class);
        $GLOBALS['whmcsApi']->execute();
    }

    public function testDefaultValuesAreSet()
    {
        $class = '\\WHMCSAPI\\Functions\\AddPayMethod';
        if (defined($class . '::DEFAULTS')) {
            foreach ($class::DEFAULTS as $attribute => $default) {
                $this->assertEquals($default, $GLOBALS['whmcsApi']->$attribute);
            }
        } else {
            $this->addToAssertionCount(1);
        }
    }

    public function testAttributesCanBeSet()
    {
        $GLOBALS['whmcsApi']->clientid = 1;
        $GLOBALS['whmcsApi']->description = 'WHMCSAPI Test Card';
        $GLOBALS['whmcsApi']->gateway_module_name = 'offlinecc';
        $GLOBALS['whmcsApi']->card_number = '4242424242424242';
        $GLOBALS['whmcsApi']->card_expiry = '1024';
        $GLOBALS['whmcsApi']->set_as_default = true;
        $this->assertEquals('4242424242424242', $GLOBALS['whmcsApi']->card_number);
        $this->assertEquals('1024', $GLOBALS['whmcsApi']->card_expiry);
    }

    public function testCanMakeAPICall()
    {
        $result = $GLOBALS['whmcsApi']->execute();
        $this->assertStringContainsString('{"result":"success"', $result);
    }
}
