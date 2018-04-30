Feature: Test validation.

    Background:
        Given I am on "/"

    Scenario: Module width error
        When I fill in "moduleWidth" with "1051"
        And I press "Calculate Parts"
        Then I should see "module width" in the ".alert" element 

    Scenario: Module thickness error
        When I fill in "moduleThickness" with "3"
        And I press "Calculate Parts"
        Then I should see "module thickness" in the ".alert" element 

    Scenario: Tilt error
        When I fill in "tilt" with ""
        And I press "Calculate Parts"
        Then I should see "tilt" in the ".alert" element 

    Scenario: Columns error
        When I fill in "moduleColumns" with "41"
        And I press "Calculate Parts"
        Then I should see "module columns" in the ".alert" element 

    Scenario: Code version error
        When I fill in "codeVersion" with ""
        And I press "Calculate Parts"
        Then I should see "code" in the ".alert" element 

    Scenario: Seismic error
        When I fill in "seismic" with ""
        And I press "Calculate Parts"
        Then I should see "seismic" in the ".alert" element 

    Scenario: Wind error
        When I fill in "codeVersion" with "5"
        And I fill in "wind" with "140"
        And I press "Calculate Parts"
        Then I should see "wind" in the ".alert" element 

    Scenario: Wind error
        When I fill in "snow" with ""
        And I press "Calculate Parts"
        Then I should see "snow" in the ".alert" element 

    Scenario: Racks error
        When I fill in "numberRacks" with "41"
        And I press "Calculate Parts"
        Then I should see "racks" in the ".alert" element 
