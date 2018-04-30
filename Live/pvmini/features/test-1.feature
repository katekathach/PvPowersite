Feature: Test UI

    @javascript
    Scenario: Test 1
        Given I am on "/"
        When I fill in the following:
            | projectname     | Mike's project |
            | projectaddress  | Mike's address |
            | projzip         | Mike's zip     |
            | cellType        | 60             |
            | moduleWidth     | 993            |
            | moduleThickness | 8              |
            | tilt            | 15             |
            | moduleColumns   | 14             |
            | numberRacks     | 1              |
            | codeVersion     | 10             |
            | seismic         | 1              |
            | wind            | 110            |
            | snow            | 20             |
        And I press "Calculate Parts"
        Then I should see:
            | #part-120008-04200 .part-number   | 120008-04200 |
            | #part-120008-04200 .name          | 4.2 m ProfiPlus XT Rail |
            | #part-120008-04200 .quantity      | 6 |
            | #part-120008-06200 .part-number   | 120008-06200 |
            | #part-120008-06200 .name          | 6.2 m ProfiPlus XT Rail |
            | #part-120008-06200 .quantity      | 1 |
            | #part-129006-000 .part-number     | 129006-000 |
            | #part-129006-000 .name            | Splice, DN1, Internal, Kit |
            | #part-129006-000 .quantity        | 16 |
            | #part-159003-003 .part-number     | 159003-003 |
            | #part-159003-003 .name            | Standard, Triangle, PvMini, Assembly, 15° |
            | #part-159003-003 .quantity        | 6 |
            | #part-128003-002 .part-number     | 128003-002 |
            | #part-128003-002 .name            | Cross Brace, PVMini, 60 Cell, Kit |
            | #part-128003-002 .quantity        | 1 |
            | #part-133180-280 .part-number     | 133180-280 |
            | #part-133180-280 .name            | 8 mm Laminate Eco8 End Clamp Kit |
            | #part-133180-280 .quantity        | 4 |
            | #part-133280-280 .part-number     | 133280-280 |
            | #part-133280-280 .name            | 8 mm Laminate Eco8 Mid Clamp Kit |
            | #part-133280-280 .quantity        | 26 |
            | #part-139008-003 .part-number     | 139008-003 |
            | #part-139008-003 .name            | 8mm Safety Hook |
            | #part-139008-003 .quantity        | 15 |
            | #center-rail-length | 1300 |
            | #center-rail-count    | 1 |
            | #intermediate-rail-length | 1300 |
            | #intermediate-rail-count | 6 |
            | #end-rail-length | 2610 |
            | #end-rail-count | 2 |
            | #instructions-1 | Cut (2) 1300mm rail(s) & (2) 2610mm rail(s) from (2) 4200mm stock rails. |
            | #instructions-2 | |
            | #instructions-3 | Cut (12) 1300mm rail(s) from (4) 4200mm stock rails. |
            | #instructions-4 | Cut (2) 2610mm rail(s) from (1) 6200mm stock rails. |		
            | #instructions-5 | with 9% [2760mm] of 31400mm wasted |
            | #cell-type | 60 cell |
            | #code-version | ASCE7-10 |
            | #module-width | 993 mm |
            | #wind | 110 mph |
            | #ground-snow | 20 psf |
            | #rack-size | 1V x 14 |
            | #system-length | 46.85 ft |
            | #tilt | 15 degrees |
            | #max-span | 8.5 ft |
            | #ballast-width | 21 in | 
            | #FCT | 0.49 kips |
            | #FCC | 1.81 kips |
            | #FCS | 0.06 kips |
            | #RCT | 1.5 kips |
            | #RCC | 1.33 kips |
            | #RCS | 0.57 kips |
            | #rebar-qty | 1 |
