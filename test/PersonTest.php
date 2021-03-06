<?php

namespace UWDOEM\Person\Test;

use PHPUnit_Framework_TestCase;

class PersonTest extends PHPUnit_Framework_TestCase
{
    public function testSetGetAttr()
    {
        $p = new MockPerson();

        $p->setAttr("key1", "value1");
        $p->setAttr("key2", "value2");

        $this->assertEquals($p->getAttr("key1"), "value1");
        $this->assertEquals($p->getAttr("key2"), "value2");
    }

    public function testFromUWNetID()
    {
        $p = MockPerson::fromUWNetID("javerage");
        $this->assertEquals($p->getAttr("DisplayName"), "James Average Student");

        $p = MockPerson::fromUWNetID("nosuchuser");
        $this->assertNull($p);
    }

    public function testFromUWRegID()
    {
        $p = MockPerson::fromUWRegID("9136CCB8F66711D5BE060004AC494FFE");
        $this->assertEquals($p->getAttr("DisplayName"), "James Average Student");

        $p = MockPerson::fromUWRegID("nosuchuser");
        $this->assertNull($p);
    }

    public function testHasAffiliation()
    {
        $uwnetid = "javerage";
        $p = MockPerson::fromUWNetID($uwnetid);

        $this->assertTrue($p->hasAffiliation("member"));
        $this->assertTrue($p->hasAffiliation("student"));
        $this->assertTrue($p->hasAffiliation("alum"));
        $this->assertTrue($p->hasAffiliation("staff"));
        $this->assertTrue($p->hasAffiliation("employee"));

        $this->assertFalse($p->hasAffiliation("sdfasdfjkl;sdfa"));
    }

    public function testClassCasting()
    {
        $uwnetid = "javerage";

        $p = MockPerson::fromUWNetID($uwnetid);
        $s = MockStudent::fromPerson($p);

        $this->assertEquals($s->getAttr("StudentNumber"), "1033334");
    }

    public function testIdentifierSearch()
    {
        $p = MockPerson::fromIdentifier("employee_id", "123456789");
        $this->assertEquals($p->getAttr("DisplayName"), "James Average Student");

        $p = MockPerson::fromIdentifier("uwnetid", "nosuchuser");
        $this->assertNull($p);
    }

    public function testGetAttrs()
    {
        $p = MockPerson::fromIdentifier("employee_id", "123456789");
        $attrs = $p->getAttrs();

        $this->assertArrayHasKey("DisplayName", $attrs);
        $this->assertArrayHasKey("RegisteredName", $attrs);

        $this->assertEquals("James Average Student", $attrs["DisplayName"]);
        $this->assertEquals("JAMES A STUDENT", $attrs["RegisteredName"]);
    }

    /**
     * If we attempt to create a person from a bad identifier type, then an error shall
     * be raised
     *
     * @return void
     * @expectedException \Exception
     * @expectedExceptionMessageRegExp #Identifier key 'badIdentifierKey' must be one of.*#
     */
    public function testFromBadIdentifier()
    {
        $p = MockPerson::fromIdentifier('badIdentifierKey', 'identifierValue');
    }
}
