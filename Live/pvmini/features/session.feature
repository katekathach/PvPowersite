Feature: Test that session persistence is working.

    @javascript
    Scenario: Does the data populate correctly when I press the back button?
        Given I am on "/"
        When I fill in the following:
            | projectname     | Test |
            | projectaddress  | 1234 Test |
            | projzip         | 85716 |
            | cellType        | 60 |
            | moduleWidth     | 1050 |
            | moduleThickness | 40 |
            | tilt            | 20 |
            | moduleColumns   | 6 |
            | numberRacks     | 1 |
            | codeVersion     | 5 |
            | seismic         | 0 |
            | wind            | 90 |
            | snow            | 0 |
        And I press "Calculate Parts"
        And I move backward one page
        Then I should see:
            | #projectname     | Test |
            | #projectaddress  | 1234 Test |
            | #projzip         | 85716 |
            | #cellType        | 60 |
            | #moduleWidth     | 1050 |
            | #moduleThickness | 40 |
            | #tilt            | 20 |
            | #moduleColumns   | 6 |
            | #numberRacks     | 1 |
            | #codeVersion     | 5 |
            | #seismic         | 0 |
            | #wind            | 90 |
            | #snow            | 0 |

