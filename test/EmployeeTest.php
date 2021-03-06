<?php

namespace UWDOEM\Person\Test;

use PHPUnit_Framework_TestCase;

class EmployeeTest extends PHPUnit_Framework_TestCase
{
    public function testEmployeeFill()
    {
        $uwnetid = "javerage";

        $p = MockEmployee::fromUWNetID($uwnetid);
        $this->assertEquals($p->getAttr("EmployeeID"), "123456789");
        $this->assertEquals($p->getAttr("Department1"), "Student Financial Aid Office");
        $this->assertEquals($p->getAttr("Email1"), "javerage@uw.edu");
        $this->assertEquals($p->getAttr("Title1"), "Web Developer");
    }

    public function testFromEmployeeID()
    {
        $p = MockEmployee::fromEmployeeID("123456789");
        $this->assertEquals($p->getAttr("Department1"), "Student Financial Aid Office");
    }
}
