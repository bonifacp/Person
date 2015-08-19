
UWDOEM/Person
=============

Smoothly poll the University of Washington's [Person Web Service](https://wiki.cac.washington.edu/display/pws/Person+Web+Service) and [Student Web Service](https://wiki.cac.washington.edu/display/SWS/Student+Web+Service) to aggregate data on a given affiliate, using X.509 certificate authentication.

For example:

```
    // Intialize the connection
    Connection::createInstance("/path/to/my/private.key", "/path/to/my/public_cert.pem", "myprivatekeypassword");
    
    // Query the web services
    $student = Student::fromStudentNumber("1033334");
    
    echo $student->getAttr("RegisteredFirstMiddleName");
    // "JAMES AVERAGE"
    
    echo $student->getAttr("UWNetID");
    // "javerage"
    
    $employee = Employee::fromUWNetID("jschilz");
    
    echo $employee->getAttr("Department1");
    // "Student Financial Aid Office"
    
    echo $employee->getAttr("Title1");
    // "Web Developer"

```


Installation
===============

This library is published on packagist. To install using Composer, add the `"uwdoem/person": "0.1.*"` line to your "require" dependencies:

```
{
    "require": {
        "uwdoem/person": "0.1.*"
    }
}
```

Of course, if you're not using Composer then you can download the repository using the *Download ZIP* button at right.

Use
===

This client library provides a `Connection` class and four data-container classes: `Person`, `Student`, `Employee`, and `Alumni`.

If you have not already done so, follow PWS's instructions on [getting access to PWS](https://wiki.cac.washington.edu/display/pws/Getting+Access+to+PWS). A similar set of steps will allow you to [gain access to SWS](https://wiki.cac.washington.edu/display/SWS/Getting+Access+to+SWS). You'll need to place both the private private key you created and also the university-signed certificate on your web server, with read-accessibility for your web-server process.

Before querying the web services, you must first initialize the connection by calling `::createInstance`:

```
    // Intialize the connection
    Connection::createInstance($my_ssl_key_path, $my_ssl_cert_path, $my_ssl_key_passwd);
```

The arguments `$my_ssl_key_path` and `$my_ssl_cert_path` correspond to the absolute locations of your private key and university-signed certificate. The `$my_ssl_key_password` argument is OPTIONAL and should be provided only if you have a password associated with the provided private key file.

You may now issue queries against the web service:

```
    // Queries PWS/SWS for a student with StudentNumber "1033334".
    $student = Student::fromStudentNumber("1033334");
    
    // If no such student was found, then $student is null
    if ($student != null) {
        echo $student->getAttr("RegisteredFirstMiddleName");
    }
```

In the case above, there does exist a student with StudentNumber "1033334": one of the university's notional test students. So this script will output "JAMES AVERAGE".

The following methods may be used to query the database:

```
    // Available to Person, and all subclasses of Person
    $person = Person::fromUWNetID($uwnetid);
    $person = Person::fromUWRegID($uwregid);
    $person = Person::fromIdentifier("uwregid", $uwregid);
    $person = Person::fromIdentifier("uwnetid", $uwnetid);
    $person = Person::fromIdentifier("employeeid", $employeeid);
    $person = Person::fromIdentifier("studentnumber", $studentnumber);
    $person = Person::fromIdentifier("studentsystemkey", $studentsystemkey);
    $person = Person::fromIdentifier("developmentid", $developmentid);
    
    // Available only to Student
    $student = Student::fromStudentNumber($studentnumber);
    
    // Available only to Employee
    $employee = Employee::fromEmployeeID($employeeid);
    
    // Available only to Alumni
    $alumni = Alumni::fromDevelopmentID($developmentid);
```

You can cast between classes each of the container classes' `::fromPerson` method:

```
    $person = Person::fromUWNetID($uwnetid);
    
    // Cast the Person object into a Student
    $person = Student::fromPerson($person);
```

The `::hasAffiliation` method can tell you whether a given person is a student, employee, and/or alumni:

```
    $person = Person::fromUWNetID($uwnetid);
    
    // The ::hasAffiliation method check is useful, but not required:
    if ($person->hasAffiliation("employee") {
        $person = Employee::fromPerson($person);
    }
```

Use `::getAttr` to retrieve an attribute from a person:

```
    $person = Person::fromUWNetID($uwnetid);
    $displayName = $person->getAttr("DisplayName");
    
    $person = Student::fromPerson($person);
    $academicDepartment = $person->getAttr("Department1");

```

Exposed Attributes
==================

The container classes expose the following attributes, corresponding to those descibed in [this PWS glossary](https://wiki.cac.washington.edu/display/pws/PWS+Attribute+Glossary):

```
    Exposed by all classes:
        "DisplayName"
        "IsTestEntity"
        "RegisteredFirstMiddleName"
        "RegisteredName"
        "RegisteredSurname"
        "UIDNumber"
        "UWNetID"
        "UWRegID"
        "WhitepagesPublish"
        
    Exposed only by Employee:
        "EmployeeID"
        "Address1"
        "Address2"
        "Department1"
        "Department2"
        "Email1"
        "Email2"
        "Fax"
        "Name"
        "Phone1"
        "Phone2"
        "PublishInDirectory"
        "Title1"
        "Title2"
        "TouchDial"
        "VoiceMail"
    
    Exposed only by Student:
        "StudentNumber"
        "StudentSystemKey"
        "Class"
        "Department1"
        "Department2"
        "Department3"
        "Email"
        "Name"
        "Phone"
        "PublishInDirectory"
        
    Exposed only by Alumni:
        "DevelopmentID"

```

Compatibility
=============

* PHP5
* Person Web Service v1
* Student Web Service v5


Todo
====

* Poll the Student Web Service for more information on students, as appropriate.
* Infer well-capitalized DisplayFirstName, DisplayLastName, DisplayMI, DisplayMiddleName attributes.

License
====

Employees of the University of Washington may use this code in any capacity, without reservation.

Getting Involved
================

Feel free to open pull requests or issues. GitHub is the canonical location of this project.
